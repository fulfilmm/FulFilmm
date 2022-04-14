<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\OfficeBranch;
use App\Models\SellingUnit;
use App\Models\Stock;
use App\Models\StockTransaction;
use App\Models\Warehouse;
use Carbon\Carbon;
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
        $office_branch=OfficeBranch::with('parent')->get();
        return view('OfficeBranch.index',compact('office_branch'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branches=OfficeBranch::all();
        return view('OfficeBranch.create',compact('branches'));
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
        $status=['Paid','Unpaid','Pending','Cancel','Draft','Sent'];
        $branch=OfficeBranch::where('id',$id)->first();
        $employees=Employee::all();
        $branch_employees=Employee::where('office_branch_id',$id)->get();
        $invoices=Invoice::with('customer','employee','branch')->where('branch_id',$id)->get();
        $warehouse=Warehouse::where('branch_id',$id)->get();
        return view('OfficeBranch.show',compact('branch','employees','invoices','branch_employees','warehouse','status'));
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
//        dd($request->all());
        $office=OfficeBranch::where('id',$id)->first();
        $office->update($request->all());
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $office=OfficeBranch::where('id',$id)->first();
        $office->delete();
        return redirect()->back();
    }
    public function add_emp(Request $request){
        foreach ($request->emp_id as $emp_id){
            $employee=Employee::where('id',$emp_id)->first();
            $employee->office_branch_id=$request->branch_id;
            $employee->update();
        }
        return redirect(route('employees.index'))->with('success','Add office branch success');
    }
    public function report(Request $request,$id){
        $status=['Paid','Unpaid','Pending','Cancel','Draft','Sent'];
        $branch=OfficeBranch::where('id',$id)->first();
        $units = SellingUnit::all();
        $warehouse = Warehouse::where('branch_id', $id)->first();
        $stocks = Stock::where('warehouse_id', $warehouse->id)->get();
        if($request->start) {
            $start = Carbon::parse($request->start)->startOfDay();
            $end = Carbon::parse($request->end)->endOfDay();
            $invoices = Invoice::with('customer', 'employee', 'branch')->where('branch_id', $id)->whereBetween('created_at',[$start,$end])->get();
            $stock_transactions = StockTransaction::with('stockin', 'stockout', 'variant', 'customer', 'employee', 'stockreturn')
                ->where('warehouse_id', $warehouse->id)
                ->whereBetween('created_at',[$start,$end])
                ->get();
        }else{
            $start=Carbon::today()->startOfDay();
            $end=Carbon::today()->endOfDay();
            $invoices = Invoice::with('customer', 'employee', 'branch')->where('branch_id', $id)
                ->whereBetween('created_at',[$start,$end])
                ->get();
            $stock_transactions = StockTransaction::with('stockin', 'stockout', 'variant', 'customer', 'employee', 'stockreturn')
                ->where('warehouse_id', $warehouse->id)
                ->whereBetween('created_at',[$start,$end])
                ->get();
        }
        return view('Report.branchreport',compact('stocks','invoices','stock_transactions','start','end','status','units','branch'));

    }
}
