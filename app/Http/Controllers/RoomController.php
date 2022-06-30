<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms=Room::all();

        return view('room.index',compact('rooms'));
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
        Room::create($request->all());
        return redirect()->back()->with('success','New Room Add Successful');
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
//        $select_room=Room::where('id',$id)->first();
//        dd($select_room);
        return view('room.edit',compact('select_room'));
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
        $room=Room::where('id',$id)->first();
        $room->update($request->all());
        return redirect()->back()->with('success','Room Updated!');
    }
    public function booking(){
        $room=Room::all()->pluck('room_no','id')->all();
        $booked_room=RoomBooking::with('bookroom','booking_emp')->where('start_time','>=',Carbon::now())->get();
        $all_booked=RoomBooking::with('bookroom','booking_emp')->get();
        $emp_id=Auth::guard('employee')->user()->id;
        $data=['room'=>$room,'bookedroom'=>$booked_room,'emp_id'=>$emp_id,'allbooked'=>$all_booked];
        return view('room.booking',compact('data'));
    }
    public function booking_save(Request $request){
        $this->validate($request,[
           'date'=>'required',
           'start_time'=>'required',
           'endtime'=>'required',
           'room_id'=>'required',
           'subject'=>'nullable'
        ]);
        $start_time=Carbon::parse( $request->date . ' ' . $request->start_time);
        $end_time=Carbon::parse($request->date . ' ' . $request->endtime);

        $booked_rooms=RoomBooking::where('room_id',$request->room_id)->whereBetween('start_time',[$start_time,$end_time])->get();

     if(count($booked_rooms)==0){
        try{
            $book=new RoomBooking();
            $book->start_time=Carbon::parse($start_time);
            $book->endtime=Carbon::parse($end_time);
            $book->date=$request->date;
            $book->room_id=$request->room_id;
            $book->created_emp=Auth::guard('employee')->user()->id;
            $book->subject=$request->subject;
            $book->save();
            return redirect()->back()->with('success','Your room booking successful');
        }catch (\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
     }else{
         return redirect()->back()->with('error','This room has been booked in your selected time! Please select another time');
     }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $room=Room::where('id',$id)->firstOrFail();
        $room->delete();
        return redirect()->back()->with('success','Room Deleted!');
    }

    /**
     * @param $id
     */
    public function bookigCancel($id){
        $booking=RoomBooking::where('id',$id)->first();
        if($booking->created_emp==Auth::guard('employee')->user()->id){
            $booking->delete();
            return redirect()->back()->with('delete','Booking Canceled');
        }else{
            return redirect()->back()->with('error','You can not cancel this booking. Only the booker can cancel');
        }
    }
}
