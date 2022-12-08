<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\Meetingmember;
use App\Models\Meetingminutes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $curren_user=Auth::guard('api')->user();
        $mymeeting=Meeting::with('room')->where('meeting_creater',$curren_user->id)->get();
        $member=Meetingmember::where('member_id',$curren_user->id)->get();
        foreach ($member as $mb){
            $mt=Meeting::with('room')->where('id',$mb->meeting_id)->first();
            array_push($mymeeting,$mt);
        }
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
        //
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
}
