<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AdvancePayment;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\TransactionCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class AdvancePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       if(Auth::guard('employee')->check())
       {
           $auth=Auth::guard('employee')->user();

           if($auth->role->name=='Super Admin'||$auth->role->name=='CEO'){
               $history=AdvancePayment::with('approver','emp','customer')->get();
               $customer=Customer::all();
               $employee=Employee::all();
               $approver=[];
               foreach ($employee as $emp){
                   if($emp->role->name=='Cashier'){
                       array_push($approver,$emp);
                   }
               }
           }else{
               $history=AdvancePayment::with('approver','emp','customer')->get();
               $employee=Employee::where('office_branch_id',$auth->office_branch_id)->get();
               $customer=Customer::where('branch_id',$auth->office_branch_id)->get();
               foreach ($employee as $emp){
                   if($emp->role->name=='Cashier'){
                       array_push($approver,$emp);
                   }
               }
           }
       }else{
           $advancepayment=AdvancePayment::with('customer','emp','approver')->where('customer_id',Auth::guard('customer')->user()->id)->get();
       }
        return view('transaction.advancepayment',compact('advancepayment','history','customer','approver'));
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
//        dd($request->all());
        try {
            AdvancePayment::create($request->all());
            $customer=Customer::where('id',$request->customer_id)->first();
            $customer->advance_balance+=$request->amount;
            $customer->update();
        }catch (Exception $e){
            return $e->getMessage();
        }
        return redirect()->back()->with('success','Advance Payment create successful');

    }
    public function maketransaction($id){

        $advance=AdvancePayment::with('order')->where('id',$id)->first();
        $account=Account::where('enabled',1)->get();
        $recurring=['No','Daily','Weekly','Monthly','Yearly'];
        $payment_method=['Cash','eBanking','WaveMoney','KBZ Pay'];
        $category=TransactionCategory::all();
        $emps=Employee::all();
        $customer=Customer::where('id',$advance->customer_id)->get();
        $data=['emps'=>$emps,'customers'=>$customer,'account'=>$account,'recurring'=>$recurring,'payment_method'=>$payment_method,'category'=>$category];
        return view('transaction.Revenue.create',compact('data','advance'));
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
}
