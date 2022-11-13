<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentFollower;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $auth = Auth::guard('api')->user();
        $todo_list = Assignment::with('owner', 'responsible_emp')
            ->where('emp_id', $auth->id)
            ->get();
        foreach ($todo_list as $td_list){
            $follower=AssignmentFollower::with('emp')->where('assignment_id',$td_list->id)->get();
            $td_list['followers']=$follower;
        }
        return response()->json(['con'=>true,'result'=>$todo_list]);

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
        $this->validate($request, [
            'title' => 'required',
            'emp_id' => 'required',
            'assignee_id' => 'required',
            'description' => 'nullable',
            'priority' => 'required',
            'status' => 'nullable',
            'end_date' => 'required',
            'attach' => 'nullable||mimes:pdf,xlsx,doc,docx,jpg,jpeg,ppt,pptx,bip,png|max:2048'
        ]);
        $task= Assignment::create($request->all());
        $emp=Employee::where('id',$request->emp_id)->first();
        $details = [
            'from'=>Auth::guard('api')->user()->email,
            'email' => $emp->email,
            'subject' => 'Task Assignment',
            'assignee_name' =>ucfirst(Auth::guard('api')->user()->name),
            'responsible_emp'=>$emp->name,
            'id'=>$task->id,
            'title'=>$request->title,
            'due_date'=>$request->end_date,
        ];
        Mail::send('Assignment.email', $details, function ($message) use ($details) {
            $message->from('sinyincinpu@gmail.com', 'Cloudark');
            $message->to($details['email']);
            $message->subject($details['subject']);
        });
        if(count($request->follower)!=0){
            foreach ($request->follower as $key=>$val){
                $follower=new AssignmentFollower();
                $follower->assignment_id=$task->id;
                $follower->emp_id=$val;
                $follower->save();
            }
        }
        return response()->json(['con'=>true,'msg'=>'Successful']);
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
        $todo = Assignment::where('id', $id)->first();
        $todo->progress = $request->progress;
        $todo->title = $request->title;
        $todo->description = $request->description;
        $todo->status = $request->status;
        $todo->priority = $request->priority;
        $todo->end_date = $request->end_date;
        $todo->emp_id = $request->emp_id;
        $todo->assignee_id = $request->assignee_id;
        $todo->update();
//        dd($request->all());
       return response()->json(['con'=>true,'msg'=>'Successful']);

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
    public function followedAssignment($id){
        $follower=AssignmentFollower::where('emp_id',$id)->get();
        $assignments=[];
        foreach ($follower as $fol){
            $todo_list = Assignment::with('owner', 'responsible_emp')
                ->where('id', $fol->assignment_id)
                ->get();
            if(count($todo_list)!=0){
                foreach ($todo_list as $td){
                    $follower=AssignmentFollower::with('emp')->where('assignment_id',$td->id)->get();
                    $td['followers']=$follower;
                    array_push($assignments,$td);
                }

            }

        }
        return response()->json(['con'=>true,'result'=>$assignments]);

    }
}
