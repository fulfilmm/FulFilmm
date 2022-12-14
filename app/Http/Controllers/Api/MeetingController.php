<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\ExternalMeetingMember;
use App\Models\Meeting;
use App\Models\Meetingmember;
use App\Models\Meetingminutes;
use App\Traits\NotifyTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MeetingController extends Controller
{
    use NotifyTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $curren_user=Auth::guard('api')->user();
        $mymeeting=Meeting::with('meeting_room','emp')->where('meeting_creater',$curren_user->id)->get();
        return response()->json(['con'=>true,'result'=>$mymeeting]);
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
            'title'=>'required',
            'meeting_type'=>'required',
        ]);
        $date=Carbon::parse( $request->date . ' ' . $request->start_time);
//        dd($request->all());
        $meeting=new Meeting();
        $meeting->title=$request->title;
        $meeting->date_time=$date;
        $meeting->meeting_type=$request->meeting_type;
        $meeting->letter=$request->letter;
        if($request->meeting_type=='Real'){
            $meeting->room_no=$request->room_no;
        }else{
            $meeting->link_id=$request->link;
            $meeting->password=$request->password;
        }
        $agender=json_encode($request->agender);
        $meeting->agenda=$agender;
        $reciver_mail=[];
        $meeting_member=[];
//       $meeting_member=[];
        foreach ($request->internal_members as $key=>$val){
            $emp=Employee::where('id',$val)->first();
            array_push($reciver_mail,$emp->email);
            array_push($meeting_member,$emp->name);
        }
        $meeting->meeting_creater=Auth::guard('api')->user()->id;
        $meeting->save();
        $last_meeting=Meeting::with('emp','meeting_room')->where('id',$meeting->id)->first();
        if(count($request->guest)!=0){
            for($i=0;$i<count($request->guest);$i++){
                $external=new ExternalMeetingMember();
                $external->email=$request->guest[$i]['email'];
                $external->name=$request->guest[$i]['name'];
                $external->save();
                array_push($meeting_member,$request->guest[$i]['name']);
                array_push($reciver_mail,$request->guest[$i]['email']);
                $this->invite_member($last_meeting->id,$external->id,'external');
            }


        }
        $this->invite_member($last_meeting->id,$request->internal_members,'internal');
        $this->invitemail($last_meeting,$reciver_mail,$meeting_member);

        return response()->json(['con'=>true,'msg'=>'success']);
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
    public function meeting_members($id){
        $meeting_member=Meetingmember::with('emp_member','external')->where('meeting_id',$id)->get();
        return response()->json(['con'=>true,'result'=>$meeting_member]);
    }
    public function minutes($id){
        $minutes=Meetingminutes::where('meeting_id',$id)->get();
        return response()->json(['con'=>true,'result'=>$minutes]);
    }
    public function invitemail($meeting,$receiver_emails,$members_name){

        foreach ($receiver_emails as $key=>$item){
            $is_emp=Employee::where('email',$item)->first();
            $externmember=ExternalMeetingMember::where('email',$item)->first();

            $agender=json_decode($meeting->agenda);
            $details = [
                'email' =>$item,
                'subject' => 'Meeting Invitation Mail',
                'member_name' => $is_emp ?$is_emp->name :$externmember->name,
                'meeting_data'=>$meeting,
                'agenda'=>$agender,
                'our_emps'=>$members_name,
            ];
            Mail::send('meeting.invitemail', $details, function ($message) use ($details) {
                $message->from('cincin.com@gmail.com', 'Cloudark');
                $message->to($details['email']);
                $message->subject($details['subject']);
            });
        }

    }
    public function invite_member($meeting_id,$members_id,$type){
        if($type=='external'){
            $meeting_member = new Meetingmember();
            $meeting_member->meeting_id = $meeting_id;
            $meeting_member->external_member_id = $members_id;
            $meeting_member->is_accept = 0;
            $meeting_member->is_external=1;
            $meeting_member->save();
        }else {
            foreach ($members_id as $key => $value) {
                $meeting_member = new Meetingmember();
                $meeting_member->meeting_id = $meeting_id;
                $meeting_member->member_id = $value;
                $meeting_member->is_accept = 0;
                $meeting_member->is_external=0;
                $meeting_member->save();
                $meeting=Meeting::where('id',$meeting_id)->first();
                $this->addnotify($value,'warning','You are invited to attend  '.$meeting->title.' meeting in '.Carbon::parse($meeting->date_time)->toFormattedDateString().' at'.date('h:i a', strtotime(Carbon::parse($meeting->date_time))),'meetings/'.$meeting->id,null);

            }
        }

    }
    public function inviteMeeting(){
        $curren_user=Auth::guard('api')->user();
        $member=Meetingmember::where('member_id',$curren_user->id)->get();
        $meeting=[];
        foreach ($member as $mb){
            $mymeeting=Meeting::with('meeting_room','emp')->where('id',$mb->id)->first();
            if($mymeeting!=null){
                array_push($meeting,$mymeeting);
            }
        }
        return response()->json(['con'=>true,'result'=>$mymeeting]);

    }
}
