<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookRoomController extends Controller
{
    public function index(){
        $booked_room=RoomBooking::with('bookroom','booking_emp')->where('start_time','>=',Carbon::now())->get();
        return response()->json(['con'=>true,'result'=>$booked_room]);
    }
    public function store(Request $request){
        $this->validate($request,[
            'date'=>'required',
            'start_time'=>'required',
            'endtime'=>'required',
            'room_id'=>'required',
            'subject'=>'nullable'
        ]);
        $start_time=Carbon::parse( $request->date . ' ' . $request->start_time);
        $end_time=Carbon::parse($request->date . ' ' . $request->endtime);
//        dd($start_time);

        $booked_rooms=RoomBooking::where('room_id',$request->room_id)->whereBetween('start_time',[$start_time,$end_time])->get();

        if(count($booked_rooms)==0){
            try{
                $book=new RoomBooking();
                $book->start_time=Carbon::parse($start_time);
                $book->endtime=Carbon::parse($end_time);
                $book->date=$request->date;
                $book->room_id=$request->room_id;
                $book->created_emp=Auth::guard('api')->user()->id;
                $book->subject=$request->subject;
                $book->save();
                return response()->json(['con'=>'success','msg'=>'success']);
            }catch (\Exception $e){
                return response()->json(['con'=>'error','msg'=>$e->getMessage()]);
            }
        }else{
            return response()->json(['con'=>'invalid','msg'=>'This room has been booked in your selected time! Please select another time']);
        }


    }
    public function allBooked(){
        $all_booked=RoomBooking::with('bookroom','booking_emp')->get();
        return response()->json(['con'=>true,'result'=>$all_booked]);
    }
    public function getRoom(){
        $room=Room::all();
        return response()->json(['con'=>true,'result'=>$room]);
    }
}
