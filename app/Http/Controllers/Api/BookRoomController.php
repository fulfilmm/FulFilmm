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
        $room=Room::all()->pluck('room_no','id')->all();
        $booked_room=RoomBooking::with('bookroom','booking_emp')->where('start_time','>=',Carbon::now())->get();
        $all_booked=RoomBooking::with('bookroom','booking_emp')->get();
        $data=['room'=>$room,'bookedroom'=>$booked_room,'allbooked'=>$all_booked];
        return response()->json(['con'=>true,'result'=>$data]);
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
}
