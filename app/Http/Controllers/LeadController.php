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
        $auth=Auth::guard('employee')->user();
        if ($auth->role->name=="Super Admin") {
            $all_leads =leadModel::with("customer", "saleMan", "tags")->get();
            }else{
            $all_leads=leadModel::with("customer", "saleMan", "tags")->orWhere('created_id',Auth::guard('employee')->user()->id)->orWhere('sale_man_id',Auth::guard('employee')->user()->id)->get();
        }
        $followers=lead_follower::with('user')->get();
//        dd($followers);

        return view("lead.lead", compact("all_leads",'followers'));
    }

    public function my_followed(){
        $leads=lead_follower::where("follower_id",Auth::guard('employee')->user()->id)->get();
        $all_leads=[];
        foreach ($leads as $lead){
            $followed_lead=leadModel::with("customer", "saleMan", "tags")->where('id',$lead->lead_id)->first();
            array_push($all_leads,$followed_lead);
        }
        $followers=lead_follower::with('user')->get();
        return view('lead.followed_lead',compact('all_leads','followers'));
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
//        dd($request->all());

            $lead = new leadModel();
            $lead->lead_id = $request->lead_id;
            $lead->title = $request->lead_title;
            $lead->created_id=Auth::guard('employee')->user()->id;
            $lead->customer_id = $request->customer_id;
            $lead->priority = $request->priority;
            $lead->organization_name=$request->org_name;
            if ($request->qualified =="on") {
                $lead->is_qualified = 1;
            } else {
                $lead->is_qualified = 0;
            }
            $lead->sale_man_id = $request->sale_man;
            $lead->tags_id = $request->tags;
            $lead->description = $request->description;
            $lead->save();
            if($request->to_date!=null){
            $this->next_plan($request->next_plan_textarea,$request->to_date,$request->from_date);
            }
            return redirect("/leads")->with("message", "Succssful");

    }
    public function next_plan($description,$to_date,$from_date){
        $lead=leadModel::orderBy('id','desc')->first();
        $next_plan=new next_plan();
        $next_plan->description=$description;
        $next_plan->to_date=Carbon::create($to_date);
        $next_plan->from_date=Carbon::create($from_date);
        $next_plan->lead_id=$lead->id;
        $next_plan->work_done=0;
        $next_plan->save();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $allemps=Employee::all();
        $lead = leadModel::with("customer", "saleMan", "tags")->where('id', $id)->first();
        $comments=lead_comment::with("user")->where("lead_id",$id)->get();
        $followers=lead_follower::with("user")->where("lead_id",$id)->get();
        $next_plan=next_plan::where("lead_id",$id)->first();
        return view("lead.lead_view", compact("lead","comments","allemps","followers","next_plan"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $allemployees = Employee::all()->pluck('name', 'id')->all();
        $allcustomers = Customer::all()->pluck('name', 'id')->all();
        $tags = tags_industry::all();
        $last_tag = tags_industry::orderBy('id', 'desc')->first();
        $lead=leadModel::where("id",$id)->first();
        $next_plan=next_plan::where("lead_id",$id)->first();
        return view("lead.edit", compact( "allemployees", "allcustomers", "tags", "last_tag","lead","next_plan"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        dd($request->all());
        $lead = leadModel::where("id",$id)->first();
        $lead->lead_id = $request->lead_id;
        $lead->title = $request->lead_title;
        $lead->customer_id = $request->customer_id;
        $lead->priority = $request->priority;
        if ($request->qualified == 'on') {
            $lead->is_qualified = 1;
        } else {
            $lead->is_qualified = 0;
        }
        $lead->sale_man_id = $request->sale_man;
        $lead->tags_id = $request->tags;
        $lead->description = $request->description;
        $lead->update();
        $this->update_next_plan($id,$request->from_date,$request->to_date,$request->next_plan_textarea);

        return redirect(route('leads.show',$id))->with("message", "Succssful");
    }
    public function update_next_plan($id,$from_date,$to_date,$description){
    $next_plan=next_plan::where("lead_id",$id)->first();
    if($next_plan!=null){
        $next_plan->from_date=$from_date;
        $next_plan->to_date=$to_date;
        $next_plan->description=$description;
        $next_plan->update();

    }else{
        $new_next_plan=new next_plan();
        $new_next_plan->from_date=$from_date;
        $new_next_plan->to_date=$to_date;
        $new_next_plan->description=$description;
        $new_next_plan->lead_id=$id;
        $new_next_plan->work_done=0;
        $new_next_plan->save();
    }
}
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lead=leadModel::where("id",$id)->first();
        $lead->delete();
        return redirect()->back()->with("message","Delete $lead->title successful");
    }
    public function qualified($id){
        $lead=leadModel::where("id",$id)->first();
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
        $comments->lead_id = $request->lead_id;
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
            $isfollowed=lead_follower::where("lead_id",$request->lead_id)->where("follower_id",$request->follower[$i])->first();
            if($isfollowed==null){
                $ticket_follower = new lead_follower();
                $ticket_follower->lead_id = $request->lead_id;
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
        $lead=next_plan::where("lead_id",$id)->first();
        $lead->work_done=1;
        $lead->update();
        return redirect()->back()->with("message","Congratulations your next plan completed");
    }
}
