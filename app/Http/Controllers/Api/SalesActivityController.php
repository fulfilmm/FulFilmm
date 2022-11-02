<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\SaleActivity;
use App\Models\SaleActivityFollower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SalesActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=Auth::guard('api')->user();
        if($user->role->name=='Super Admin'||$user->role->name=='CEO'){
            $activities=SaleActivity::orderby('created_at','desc')->with('employee','customer','report','follower')->get();
        }else{
            $activities=SaleActivity::orderby('created_at','desc')->with('employee','customer','report','follower')->where('emp_id',$user->id)->orWhere('report_to',$user->id)->get();
        }
        foreach ($activities as $act){
            $follower=SaleActivityFollower::with('employee')->where('activity_id',$act->id)->get();
            $act['followers']=$follower;
        }
        return response()->json(['result'=>$activities,'con'=>true]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
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
        $activity->shop=$request->shop;
        $activity->amount=$request->amount;
        $activity->township=$request->township;
        $activity->emp_id=Auth::guard('api')->user()->id;
        if ($request->hasfile('attachment')) {
            foreach ($request->file('attachment') as $attach) {
                $input['filename'] =\Illuminate\Support\Str::random(10).time().'.'.$attach->extension();
                $attach->move(public_path().'/attach_file/', $input['filename']);
                $data[]=$input['filename'];

            }
//            dd($data);
            $activity->attachment = json_encode($data);
        }
//        dd('hello');
        $activity->save();
        $api_fol=json_decode($request->follower);
        if(isset($request->follower)){
            foreach ($api_fol as $follower_id){
                $this->addFollower($follower_id,$activity->id);
            }
        }
        $report_to=Employee::where('id',$request->report_to)->first();
        $this->addnotify($report_to->id,'success','Add new sale activity posted and reported you.','sale/activity/show/'.$activity->id,Auth::guard('api')->user()->id);
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
        return response()->json(['con'=>true,'message'=>'Successful']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
