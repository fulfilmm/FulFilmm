<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentCheckList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
           'description' =>'required'
        ]);
        $assignment=Assignment::where('id',$request->assignment_id)->first();
        if($request->emp_id==$assignment->emp_id||$request->emp_id==$assignment->assignee_id){
            AssignmentCheckList::create($request->all());
            return redirect('assignments/'.$request->assignment_id)->with('success','Add new checklist');
        }else{
            return redirect()->back();
        }
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
        $todo_checklist=AssignmentCheckList::where('id',$id)->firstOrFail();
        if(isset($request->remark)){
//            dd($request->remark);
            $todo_checklist->remark=$request->remark;
        }else{
            $todo_checklist->done=$request->done;
        }
        $todo_checklist->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check_list=AssignmentCheckList::where('id',$id)->first();
       if($check_list->emp_id==Auth::guard('employee')->user()->id){
           $check_list->delete();
           return redirect()->back();
       }else{
           return redirect()->back();
       }
    }
}
