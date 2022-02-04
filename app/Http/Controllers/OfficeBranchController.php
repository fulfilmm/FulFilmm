<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\Models\OfficeBranch;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class OfficeBranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $office_branch=OfficeBranch::with('warehouse')->get();
        return view('OfficeBranch.index',compact('office_branch'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $warehouse=Warehouse::all();
        return view('OfficeBranch.create',compact('warehouse'));
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
            'warehouse_id'=>'required',
            'name'=>'required',
            'address'=>'required',
        ]);
        try{
            OfficeBranch::create($request->all());
            return redirect(route('officebranch.index'))->with('success','Add new Office Branch');
        }catch (\Exception $e){
          return redirect()->back()->with('error', $e->getMessage());
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
        $branch=OfficeBranch::where('id',$id)->first();
        $employees=Employee::all();
        return view('OfficeBranch.show',compact('branch','employees'));
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
    public function addemp(Request $request){
        foreach ($request->emp_id as $emp_id){
            $employee=Employee::where('id',$emp_id)->first();
            $employee->office_branch_id=$request->branch_id;
            $employee->update();
        }
        return redirect(route('employees.index'))->with('success','Add office branch success');
    }
}
