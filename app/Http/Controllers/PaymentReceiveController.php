<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Customer;
use App\Models\PaymentReceive;
use App\Models\TransactionCategory;
use Illuminate\Http\Request;

class PaymentReceiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payment_recieved=PaymentReceive::with('customer','employee')->get();
        return view('CashReceive.index',compact('payment_recieved'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customer=Customer::all()->pluck('name','id')->all();
        return view('CashReceive.create',compact('customer'));
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
           'amount'=>'required',
           'customer_id'=>'required',
            'receive_date'=>'required'
        ]);
        PaymentReceive::create($request->all());
        return redirect(route('payment_receives.index'))->with('success','Created Successful');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $recurring=['No','Daily','Weekly','Monthly','Yearly'];
        $payment_method=['Cash','eBanking','WaveMoney','KBZ Pay'];
        $category=TransactionCategory::all();
        $account=Account::all()->pluck('name','id')->all();
        $customer=Customer::all()->pluck('name','id')->all();
        $payment=PaymentReceive::with('customer','employee')->where('id',$id)->first();
        $data=['customers'=>$customer,'account'=>$account,'recurring'=>$recurring,'payment_method'=>$payment_method,'category'=>$category];
        return view('CashReceive.show',compact('payment','data'));
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
        $payment_receive=PaymentReceive::where('id',$id)->first();
        $payment_receive->update($request->all());
        return redirect()->back()->with('success','Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment_receive=PaymentReceive::where('id',$id)->first();
        $payment_receive->delete();
        return redirect()->back()->with('success','Payment Received Deleted');
    }
}
