<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\Meetingmember;
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
        $meetings=Meeting::with('meeting_room')->where('meeting_creater',$curren_user->id)->get();
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
}
