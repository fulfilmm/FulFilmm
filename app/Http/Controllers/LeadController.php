<?php

namespace App\Http\Controllers;

use App\Jobs\leadactivityschedulemail;
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
use Illuminate\Support\Facades\Mail;

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

        return view();
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
        $next_plan->type=$request->type;
        $next_plan->date_time=Carbon::create($request->date_time);
        $next_plan->contact_id=$request->lead_id;
        $next_plan->work_done=0;
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
