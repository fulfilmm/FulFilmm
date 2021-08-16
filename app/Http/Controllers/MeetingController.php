<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Meeting;
use App\Models\Meetingmember;
use App\Models\Meetingminutes;
use App\Models\MinutesAssign;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use mysql_xdevapi\Exception;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $curren_user=Auth::guard('employee')->user();
        $meetings=Meeting::where('meeting_creater',$curren_user->id)->get();
        $invites_me=Meetingmember::with('meeting')->where('member_id',$curren_user->id)->get();
        $alert_meeting=[];
        foreach ($meetings as $item){
            if(\Carbon\Carbon::parse($item->date_time)<= (\Carbon\Carbon::now()->addMinutes(30)) && \Carbon\Carbon::parse($item->date_time)->hour(23)>= (\Carbon\Carbon::now()) )
            {
                array_push($alert_meeting,$item);
            }
            if($invites_me!=null){
            foreach ($invites_me as $invite){
                    if(Carbon::parse($invite->meeting->date_time)<= (Carbon::now()->addMinutes(30))){
                        array_push($alert_meeting,$invite->meeting);
                    }
                }

            }

        }
        return view('meeting.index',compact('meetings','invites_me','alert_meeting'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees=Employee::all()->pluck('name','id')->all();
        return view('meeting.create',compact('employees'));
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
            'title'=>'required',
            'due_date'=>'required',
            'meeting_type'=>'required',
            'agender'=>'required'
        ]);
//        dd($request->all());
        $meeting=new Meeting();
        $meeting->title=$request->title;
        $meeting->date_time=Carbon::create($request->due_date);
        $meeting->meeting_type=$request->meeting_type;
        if($request->meeting_type=='Real'){
            $meeting->address=$request->address;
            $meeting->room_no=$request->room_no;
        }else{
            $meeting->link_id=$request->link;
            $meeting->password=$request->password;
        }
        $agender=json_encode($request->agender);
       $meeting->agenda=$agender;
       $reciver_mail=[];
       if(!empty($request->guest_email[0])){
           $guests=json_encode($request->guest_email);
           $meeting->guest_member=$guests;
           foreach ($request->guest_email as $key=>$email){
               array_push($reciver_mail,$email);
           }
       }
       $meeting_member=[];
      foreach ($request->internal_members as $key=>$val){
          $emp=Employee::where('id',$val)->first();
          array_push($reciver_mail,$emp->email);
          array_push($meeting_member,$emp->name);
      }
       $meeting->meeting_creater=Auth::guard('employee')->user()->id;
       $meeting->save();
       $last_meeting=Meeting::with('emp')->where('id',$meeting->id)->first();
       $this->invitemail($last_meeting,$reciver_mail,$meeting_member);
       $this->invite_member($last_meeting->id,$request->internal_members);
       return redirect(route('meetings.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $meeting=Meeting::with('emp')->where('id',$id)->first();
        $members=$meeting->guest_member ? json_decode($meeting->guest_member) :null;
        $agenda=json_decode($meeting->agenda);
        $emp_members=Meetingmember::with('emp_member')->where('meeting_id',$id)->get();
        $minutes=Meetingminutes::where('meeting_id',$id)->get();
        $all_emp=Employee::all();
        $depts=Department::all();
        $assign_name=MinutesAssign::with('emp','dept')->get();
        return view('meeting.show',compact('meeting','members','emp_members','agenda','minutes','depts','all_emp','assign_name'));
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
        $meeting_member=Meetingmember::where('meeting_id',$id)->get();
        foreach ($meeting_member as $delete_member){
            $delete_member->delete();
        }
        $meeting=Meeting::where('id',$id)->first();
        $meeting->delete();
        return redirect()->back();
    }
    public function invitemail($meeting,$receiver_emails,$members_name){

        foreach ($receiver_emails as $key=>$item){
            $is_emp=Employee::where('email',$item)->first();

            $agender=json_decode($meeting->agenda);
            $details = [
                'email' =>$item,
                'subject' => 'Meeting Invitation Mail',
                'member_name' => $is_emp ?$is_emp->name :$item,
                'meeting_data'=>$meeting,
                'agenda'=>$agender,
                'our_emps'=>$members_name,
                'guest_email'=> json_decode($meeting->guest_member),
            ];
            Mail::send('meeting.invitemail', $details, function ($message) use ($details) {
                $message->from('cincin.com@gmail.com', 'Cloudark');
                $message->to($details['email']);
                $message->subject($details['subject']);
            });
        }

    }
    public function invite_member($meeting_id,$members_id){
        foreach ($members_id as $key=>$value){
            $meeting_member=new Meetingmember();
            $meeting_member->meeting_id=$meeting_id;
            $meeting_member->member_id=$value;
            $meeting_member->is_accept=0;
            $meeting_member->save();
        }

    }
}
