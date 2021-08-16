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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Validator as ValidatorAlias;
use function GuzzleHttp\Promise\all;

class MinutesController extends Controller
{
    public function store(Request $request){
//        dd($request->all());
        $minutes=new Meetingminutes();
        $minutes->meeting_id=$request->meeting_id;
        $minutes->minutes_no=$request->record_no;
        $minutes->is_complete=0;
        $minutes->minutes_text=$request->minutes;
        if ($request->hasfile('attach_file')) {
            foreach ($request->file('attach_file') as $attach) {
                $name = $attach->getClientOriginalName();
                $attach->move(public_path() . '/minutes_attach/', $name,);
                $data[] = $name;
            }
            $attach_names=json_encode($data);
            $minutes->attach_file=$attach_names;
        }

        $minutes->save();
        return redirect()->back();
    }
    public function assign_minutes(Request $request){
        $validator=Validator::make($request->all(),[
            'assing_type'=>'in:emp,dept,group',
            'assign_to'=>'required',
            'due_date'=>'required'
        ]);
        if($validator->passes()){
//        dd($request->all());
            $minutes=Meetingminutes::where('id',$request->minute_id)->first();
            if(!$minutes->is_assign && $request->assing_type!="item0") {
                $minutes->is_assign = 1;
                $minutes->update();
                $assign_minutes = new MinutesAssign();
                $assign_minutes->assign_type = $request->assing_type;
                $assign_minutes->minutes_id = $request->minute_id;
                $assign_minutes->due_date = Carbon::create($request->due_date);
                if ($request->assing_type == "dept") {
                    $assign_minutes->dept_id = $request->assign_to;
                } elseif ($request->assing_type == 'emp') {
                    $assign_minutes->emp_id = $request->assign_to;
                } elseif ($request->assing_type == 'group') {
                    $assign_minutes->group_id = $request->assign_to;
                }
                $assign_minutes->save();
            }
            return response()->json(['Success' => 'Minutes Assign Success']);
        }else{
            return response()->json(['error'=>$validator->errors()]);
        }
    }
    public function complete(Request $request){
       $minutes=Meetingminutes::where('id',$request->minute_id)->first();
       if($minutes->is_assign){
           $minutes->is_complete=1;
           $minutes->update();
           return response()->json([
               'success'=>'completed',
           ]);
       }else{
           return response()->json([
               'error_msg'=>'You Must to assign this minute first!',
           ]);
       }

    }
    public function filter(Request $request,$id){
        $minutes=[];
           $meeting_search=Meetingminutes::orWhere('minutes_no','LIKE','%'.$request->search)->orWhere('minutes_text','LIKE','%'.$request->search)->get();
           foreach ($meeting_search as $filter){
               if($filter->meeting_id==$id){
                   array_push($minutes,$filter);
               }
           }
        $meeting=Meeting::with('emp')->where('id',$id)->first();
        $members=$meeting->guest_member ? json_decode($meeting->guest_member) :null;
        $agenda=json_decode($meeting->agenda);
        $emp_members=Meetingmember::with('emp_member')->where('meeting_id',$id)->get();
        $all_emp=Employee::all();
        $depts=Department::all();
        $assign_name=MinutesAssign::with('emp','dept')->get();
        return view('meeting.show',compact('meeting','members','emp_members','agenda','minutes','depts','all_emp','assign_name'));

    }

}
