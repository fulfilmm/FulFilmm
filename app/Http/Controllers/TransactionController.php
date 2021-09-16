<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Revenue;
use App\Models\Transaction;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TransactionController extends Controller
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function addrevenue()
    {   $account=['Cash','Banking','eBanking'];
        $recurring=['Dayly','Weekly','Monthly','Yearly'];
        $payment_method=['Cash','eBanking','WaveMoney','KBZ Pay'];
        $category=['Deposit'];
        $customer=Customer::all()->pluck('name','id')->all();
        $data=['customers'=>$customer,'account'=>$account,'recurring'=>$recurring,'payment_method'=>$payment_method,'category'=>$category];
        return view('transaction.create_revenue',compact('data'));
    }

    public function store_revenue(Request $request)
    {
        dd($request->all());
        $this->validate($request, [
            'transaction_date' => 'required',
            'amount' => 'required',
            'account' => 'required',
            'customer_id' => 'required',
            'category' => 'required',
            'payment_method' => 'required',
        ]);
        $new_revenue = new Revenue();
        $new_revenue->customer_id = $request->customer_id;
        $new_revenue->amount = $request->amount;
        $new_revenue->invoice_id = $request->invoice_id ?? null;
        $new_revenue->account = $request->account;
        $new_revenue->reference = $request->reference;
        $new_revenue->recurring = $request->recurring;
        $new_revenue->payment_method = $request->payment_method;
        $new_revenue->description = $request->description;
        $new_revenue->category = $request->category;
        $new_revenue->transaction_date = $request->transaction_date;
        $new_revenue->emp_id = Auth::guard('employee')->user()->id;
        $new_revenue->currency = $request->currency;
        $new_revenue->save();
    }
    public function transaction_add(){

    }
}
