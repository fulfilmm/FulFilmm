<?php

namespace App\Http\Controllers;

use App\Jobs\leadactivityschedulemail;

use App\Models\Customer;

use App\Models\deal;
use App\Models\lead_comment;
use App\Models\lead_follower;


use App\Models\next_plan;
use App\Models\OfficeBranch;
use App\Models\Region;
use App\Models\SalePipelineRecord;
use App\Models\SaleZone;
use App\Models\tags_industry;
use App\Repositories\Contracts\CompanyContract;
use App\Repositories\Contracts\CustomerContract;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LeadController extends Controller
{
    public $state = ['Yangon Division', 'Mandalay Division', 'Bago Division', 'Ayeyarwady Division', 'Tanintharyi Division', 'Magway Division', 'Sagaing Division', 'Kachin State', 'Kayah State', 'Kayin State', 'Chin State', 'Mon State', 'Rakhine State', 'Shan State'];

    private $customerContract, $company_contract;

    public function __construct(CustomerContract $customerContract, CompanyContract $company_contract)
    {
        $this->customerContract = $customerContract;
        $this->company_contract = $company_contract;

    }
    public function index()
    {
        $customers=Customer::where('customer_type','Lead')->get();
        return view('customer.lead',compact('customers'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $auth=Auth::guard('employee')->user();
        $tags = tags_industry::all();
        $last_tag = tags_industry::orderBy('id', 'desc')->first();
        $companies = $this->company_contract->all()->pluck('name', 'id')->all();
        $parent_companies = $this->company_contract->parentCompanies()->pluck('name', 'id')->all();
        $zone=SaleZone::all();
        $auth=Auth::guard('employee')->user();
        if($auth->role->name=='Super Admin'||$auth->role->name=='CEO'||$auth->role->name=='Sale Manager'){
            $branch=OfficeBranch::all();
            $region=Region::all();
        }else{
            $branch=OfficeBranch::where('id',$auth->office_branch_id)->get();
            $region=Region::where('branch_id',$auth->office_branch_id)->get();
        }
        return view('Lead.create', compact('companies', 'last_tag', 'tags','parent_companies','zone','region','branch'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//
    }
    public function activity_schedule(Request $request){
        $this->validate($request,[
            'description'=>'required',
            'date_time'=>'required',
            'type'=>'required'
        ]);
        $next_plan=new next_plan();
        $next_plan->description=$request->description;
        $next_plan->type=$request->type;
        $next_plan->date_time=Carbon::create($request->date_time);
        $next_plan->contact_id=$request->lead_id;
        $next_plan->work_done=0;
        if(isset($request->repeat)){
            $next_plan->repeat=$request->repeat;
            $next_plan->repeat_type=$request->repeat_type;
        }

        $next_plan->emp_id=Auth::guard('employee')->user()->id;
        $next_plan->save();

        $followers=lead_follower::with('user','leads')->where('contact_id',$request->lead_id)->get();

        if(!$followers->isEmpty()) {

            foreach ($followers as $follower) {
                $details = array(
                    'email' => $follower->user->email,
                    'subject' => 'Activity schedule Notification',
                    'lead_name' => $follower->leads->name,
                    'lead_id'=>$request->lead_id,
                    'type' => $request->type,
                    'follower_name'=>$follower->user->name,
                    'desc' => $request->description,
                    'date' => $request->date_time,
                );
                $emailJobs = new leadactivityschedulemail($details);
                $this->dispatch($emailJobs);

            }
        }
        return redirect(route('customers.show',$request->lead_id))->with('success','Activity Schedule Add Success');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function qualified(Request $request,$id){
        $lead=Customer::where("id",$id)->first();
        $lead->status=$request->status;
        $lead->update();
       if($request->status=='Qualified'){
           $exist_in_deal=deal::where('contact',$id)->first();
           $exist_in_deal->sale_stage = isset($request->status)?$request->status:'New';
           $exist_in_deal->update();
           $deal_record =SalePipelineRecord::where('deal_id',$exist_in_deal->id)->first();
           $deal_record->state =isset($request->status)?$request->status:'New';
           $deal_record->emp_id = Auth::guard('employee')->user()->id;
           $deal_record->update();
       }
        return redirect()->back();
    }

    public function tag_add(Request $request)
    {
        $tag = new tags_industry();
        $tag->tag_industry = $request->tag_industry;
        $tag->save();
        return response()->json([
            'tags' => "success",
        ]);
    }
    public function comment(Request $request){
       if($request->comment!=null){
           $comments = new lead_comment();
           $comments->contact_id = $request->lead_id;
           $comments->user_id = Auth::guard('employee')->user()->id;
           $comments->comment = $request->comment;
           $comments->save();
           return redirect()->back()->with('success','Added note');
       }else{
           return redirect()->back()->with('error','Type note');
       }

    }
    public function comment_delete($id){
        $comment=lead_comment::where("id",$id)->first();
        $comment->delete();
        return redirect()->back();
    }
    public function lead_follower(Request $request){
        for ($i = 0; $i < count($request->follower); $i++) {
            $isfollowed=lead_follower::where("contact_id",$request->lead_id)->where("follower_id",$request->follower[$i])->first();
            if($isfollowed==null){
                $ticket_follower = new lead_follower();
                $ticket_follower->contact_id = $request->lead_id;
                $ticket_follower->follower_id = $request->follower[$i];
                $ticket_follower->save();
            }
        }
        return redirect()->back();
    }
    public function unfollower(Request $request){
        foreach ($request->follower as $key=>$value) {
            $unfollow_emp=lead_follower::where('follower_id',$value)->first();
            $unfollow_emp->delete();
        }
        return redirect()->back();
    }
    public function work_done($id){
        $lead=next_plan::where("id",$id)->first();
        $lead->work_done=1;
        $lead->update();
        return redirect()->back()->with("message","Congratulations your next plan completed");
    }
    public function delete_schedule($id){
        $schedule=next_plan::where('id',$id)->first();
        $schedule->delete();
        return redirect()->back()->with('success','Activity Schedule Delete Successful');
    }
}
