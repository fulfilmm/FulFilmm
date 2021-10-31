<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\SaleActivity;
use App\Models\SaleActivityComment;
use App\Models\SaleActivityFollower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SaleActivityController extends Controller
{
    public function index(){

       if(Auth::guard('employee')->user()->role->name=='SuperAdmin'||Auth::guard('employee')->user()->role->name=='CEO'){
           $activities=SaleActivity::with('employee')->get();
       }else{
           $activities=SaleActivity::with('employee')->where('emp_id',Auth::guard('employee')->user()->id)->orWhere('report_to',Auth::guard('employee')->user()->id)->get();
       }
        $followers=SaleActivityFollower::with('employee')->get();
        $unreach_activity=[];
        foreach ($activities as $activity) {
            if (Auth::guard('employee')->user()->id == $activity->report_to && $activity->status==0) {
               array_push($unreach_activity,$activity);
            }
        }
//        dd($unreach_activity);
        return view('activity.activities',compact('activities','followers','unreach_activity'));
    }
    public function create(){
        $customers=Customer::all()->pluck('name','id')->all();
        $emps=Employee::all();
        return view('activity.create',compact('customers','emps'));
    }
    public function store(Request $request){
//        dd($request->all());
        $this->validate($request,[
            'customer_id'=>'required',
            'report_to'=>'required',
            'date'=>'required',
            'desc'=>'required',
            'title'=>'required'
        ]);
        $activity=new SaleActivity();
        $activity->title=$request->title;
        $activity->customer_id=$request->customer_id;
        $activity->type=$request->type;
        $activity->activity_type=$request->activity_type;
        $activity->description=$request->desc;
        $activity->report_to=$request->report_to;
        $activity->date=$request->date;
        $activity->emp_id=Auth::guard('employee')->user()->id;
        if ($request->hasfile('attachment')) {
            foreach ($request->file('attachment') as $attach) {
                $name = $attach->getClientOriginalName();
                $attach->move(public_path() . '/attach_file/', $name,);
                $data[]=$name;

            }
//            dd($data);
            $activity->attachment = json_encode($data);
        }
//        dd('hello');
       $activity->save();
        if(isset($request->follower)){
            foreach ($request->follower as $follower_id){
                $this->addFollower($follower_id,$activity->id);
            }
        }
        $report_to=Employee::where('id',$request->report_to)->first();
       if(isset($request->follower)){
           foreach ($request->follower as $follower){
               $follower_emp=Employee::where('id',$follower)->first();
               $details = array(
                   'email' => $report_to->email,
                   'subject' => 'Add activity Notification',
                   'emp_name' => $report_to->name,
                   'cc'=>$follower_emp->email,
                   'addby'=>Auth::guard('employee')->user()->name,
                   'title'=>$request->title,
                   'activity_id'=>$activity->id,
               );
               Mail::send('activity.email', $details, function ($message) use ($details) {
                   $message->from('cincin.com@gmail.com', 'Cloudark');
                   $message->to($details['email']);
                   $message->subject($details['subject']);
                   if ($details['cc'] != null) {
                       $message->cc($details['cc']);
                   }

               });
           }
       }else{
           $details = array(
               'email' => $report_to->email,
               'subject' => 'Add activity Notification',
               'emp_name' => $report_to->name,
               'addby'=>Auth::guard('employee')->user()->name,
               'activity_id'=>$activity->id,
               'title'=>$request->title,
           );
           Mail::send('activity.email', $details, function ($message) use ($details) {
               $message->from('cincin.com@gmail.com', 'Cloudark');
               $message->to($details['email']);
               $message->subject($details['subject']);

           });
       }
       return redirect(route('activity.index'))->with('success','Add New Activity');
    }
    public function follower(Request $request){
        foreach ($request->follower as $follower){
            $this->addFollower($follower,$request->activity_id);
        }
        return redirect()->back();
    }
    public function unfollower(Request $request){
        foreach ($request->follower as $follower){
            $unfollow_emp=SaleActivityFollower::where('emp_id',$follower)->where('activity_id',$request->activity_id)->first();
            $unfollow_emp->delete();
        }
        return redirect()->back();
    }
    public function addFollower($emp_id,$activity_id){
        $addfollow=new SaleActivityFollower();
        $addfollow->emp_id=$emp_id;
        $addfollow->activity_id=$activity_id;
        $addfollow->save();
    }
    public function show($id){
        $activity=SaleActivity::with('report','employee','customer')->where('id',$id)->firstOrFail();
        $followers=SaleActivityFollower::with('employee')->where('activity_id',$id)->get();
        $comments=SaleActivityComment::with('user')->where('saleactivity_id',$id)->get();
        $creater_comments=[];
        $reportto_cmts=[];
        $folloer_cmt=[];
        $files=json_decode($activity->attachment);
        foreach ($comments as $cmt){
            if($cmt->emp_id==$activity->emp_id && $cmt->read==0){
                array_push($creater_comments,$cmt);
            }else if($cmt->emp_id==$activity->report_to && $cmt->read==0){
                array_push($reportto_cmts,$cmt);
            }else if($cmt->read==0){
                array_push($folloer_cmt,$cmt);
            }
        }
        $emps=Employee::all();
        $activities=SaleActivity::with('employee')->get();
        $unreach_activity=[];
        foreach ($activities as $activity) {
            if (Auth::guard('employee')->user()->id == $activity->report_to && $activity->status==0) {
                array_push($unreach_activity,$activity);
            }
        }
        $unfollowed_emps=[];
        foreach ($emps as $emp){
            $is_followed=SaleActivityFollower::where('emp_id',$emp->id)->where('activity_id',$id)->first();
            if($is_followed==null){
                array_push($unfollowed_emps,$emp);
            }
        }
//        dd($creater_comments);
        return view('activity.show',compact('activity','followers','comments','unfollowed_emps','unreach_activity','reportto_cmts','creater_comments','folloer_cmt','files'));
    }
    public function post_comment(Request $request){
        $comment=new SaleActivityComment();
        $comment->comment=$request->comment;
        $comment->saleactivity_id=$request->activity_id;
        $comment->emp_id=Auth::guard('employee')->user()->id;
        $comment->save();
        return redirect()->back();
    }
    public function read($id){
        $activity=SaleActivity::where('id',$id)->first();
        $activity->status=1;
        $activity->update();
        return redirect(route('activity.show',$id));
    }
}
