<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $groups = Group::with('employees')->get();
        // dd($groups);
        return view('groups.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $employees = Department::with('employees')->has('employees')->get();
        return view('groups.create', compact('employees'));

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

        $group =Group::create(['name' => $request->name,'type'=>$request->type,'created_by' => auth()->guard('employee')->id()]);
        foreach($request->employees as $employee){
            $group->employees()->attach($employee);
        }

        return redirect()->route('groups.index')->with('success', __('alert.create_success'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group=Group::with('employees')->where('id',$id)->first();
        return view('groups.show',compact('group'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group=Group::where('id',$id)->first();
        $members=DB::table('groups_employees')->where('group_id',$group->id)->get();
        $employees = Department::with('employees')->has('employees')->get();
        return view('groups.edit',compact('group','employees','members'));
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
        $group =Group::where('id',$id)->first();
        $group->name=$request->name;
        $group->type=$request->type;
        $group->update();
        foreach($request->employees as $employee){
            $members=DB::table('groups_employees')->where('group_id',$group->id)->where('employee_id',$employee)->first();
         if($members==null){

             $group->employees()->attach($employee);
         }

        }
        return redirect()->back()->with('success','Updated Successful');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Group::destroy($id);
        return redirect()->route('groups.index')->with('success', __('alert.delete_success'));
    }
}
