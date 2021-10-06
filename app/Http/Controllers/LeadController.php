<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\lead_comment;
use App\Models\lead_follower;
use App\Models\leadModel;
use App\Models\MainCompany;
use App\Models\next_plan;
use App\Models\tags_industry;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
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
        $prefix=MainCompany::where('ismaincompany',true)->pluck('lead_prefix','id')->first();
            $allemployees = Employee::all()->pluck('name', 'id')->all();
            $allcustomers = Customer::all()->pluck('name', 'id')->all();
//            dd($allcustomers);
            $companies=company::all()->pluck('name', 'id')->all();
            $lastlead = leadModel::orderBy('id', 'desc')->first();
        if (isset($lastlead)) {
            // Sum 1 + last id
            $ischange=$lastlead->lead_id;
            $ischange=explode("-", $ischange);
            if($ischange[0]==$prefix){
                $lastlead->lead_id++;
                $lead_id = $lastlead->lead_id;
            }else{
                $arr=[$prefix,$ischange[1]];
                $pre=implode('-',$arr);
                $pre ++;
                $lead_id=$pre;
            }
        } else {
            $lead_id =($prefix ? :'Lead') . "-0001";
        }
        $tags = tags_industry::all();
        $last_tag = tags_industry::orderBy('id', 'desc')->first();
        return view("lead.lead_create", compact("lead_id","companies","allemployees","allcustomers", "tags", "last_tag"));
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
        $next_plan=new next_plan();
        $next_plan->description=$request->description;
        $next_plan->to_date=Carbon::create($request->end_date.''.$request->time);
        $next_plan->from_date=Carbon::create($request->start_date);
        $next_plan->contact_id=$request->lead_id;
        $next_plan->work_done=0;
        $next_plan->save();
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

    public function qualified($id){
        $lead=Customer::where("id",$id)->first();
        $lead->is_qualified=1;
        $lead->update();
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
        $comments = new lead_comment();
        $comments->contact_id = $request->lead_id;
        $comments->user_id = Auth::guard('employee')->user()->id;
        $comments->comment = $request->comment;
        $comments->save();
        return redirect()->back();
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
