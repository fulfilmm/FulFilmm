<?php

namespace App\Http\Controllers;

use App\Models\EmpExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpensesRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::guard('employee')->user()->role->name=='Super Admin' || Auth::guard('employee')->user()->role->name=='CEO'){
            $emp_expeneses=EmpExpense::all();
        }else{
            $emp_expeneses=EmpExpense::where('emp_id',Auth::guard('employee')->user()->id)->get();
        }
        return view('employee.ExpenseRecord.index',compact('emp_expeneses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $this->validate($request,[
            'title'=>'required',
            'amount'=>'required'
        ]);
        $data=$request->all();
        $data['emp_id']=Auth::guard('employee')->user()->id;
        if ($request->attachment != null) {
            $attachment = $request->file('attachment');
            $input['filename'] = \Illuminate\Support\Str::random(10) . time() . '.' . $attachment->extension();
            $request->attachment->move(public_path() . '/attach_file', $input['filename']);
            $data['attach']= $input['filename'];
        }
        EmpExpense::create($data);
        return redirect('expense_record')->with('success','Add new expenses');
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
        $exp_record=EmpExpense::where('id',$id)->first();
        $exp_record->update($request->all());
        return redirect('expense_record')->with('success','Expense Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exp_record=EmpExpense::where('id',$id)->first();
        $exp_record->delete();
        return redirect('expense_record')->with('success','Expense record deleted');
    }
}
