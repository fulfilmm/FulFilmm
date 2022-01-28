<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AdvancePayment;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\TransactionCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        $advancepayment=AdvancePayment::with('customer','emp','order','account')->get();
        return view('transaction.advancepayment',compact('advancepayment'));
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
        try {
            AdvancePayment::create($request->all());
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
        $customer=Customer::orWhere('customer_type','Customer')->orWhere('customer_type','Lead')->orWhere('customer_type','Partner')->orWhere('customer_type','Inquery')->get();
        $data=['emps'=>$emps,'customers'=>$customer,'account'=>$account,'recurring'=>$recurring,'payment_method'=>$payment_method,'category'=>$category];
        return view('transaction.revenue',compact('data','advance'));
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
