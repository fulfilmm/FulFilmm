<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\SaleReturn;
use Illuminate\Http\Request;

class SaleReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sale_returns=SaleReturn::with('saleman','customer','branch','invoice','cashier')->get();
        $invoices=Invoice::with('customer','employee','branch')->where('cancel',1)->get();
        $account=Account::all();
        $employee=Employee::all();
        $category=['Item Does Not Fit','Defective Item','Damage Item','Late Delivery','Wrong Item Deliverred'];
        return view('sale.SaleReturn.index',compact('sale_returns','invoices','account','employee','category'));
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
        $this->validate($request,[
            'invoice_id'=>'required',
            'customer_id'=>'required',
            'sale_man_id'=>'required',
            'branch_id'=>'required',
            'amount'=>'required',

        ]);
        $customer=Customer::where('id',$request->customer_id)->first();
        $customer->current_credit-=$request->amount;
        $customer->update();
        $data=$request->all();
        if ($request->attachment != null) {
            $attachment = $request->file('attachment');
            $input['filename'] = \Illuminate\Support\Str::random(10) . time() . '.' . $attachment->extension();
            $request->attachment->move(public_path() . '/attach_file', $input['filename']);
            $data['attach']= $input['filename'];
        }
        SaleReturn::create($data);
        return redirect('sale_return')->with('success','Added new Sale Return');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SaleReturn  $saleReturnController
     * @return \Illuminate\Http\Response
     */
    public function show(SaleReturn $saleReturnController)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SaleReturn  $saleReturnController
     * @return \Illuminate\Http\Response
     */
    public function edit(SaleReturn $saleReturnController)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SaleReturn  $saleReturnController
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sale_return=SaleReturn::where('id',$id)->first();
        $data=$request->all();
        if ($request->attachment != null) {
            $attachment = $request->file('attachment');
            $input['filename'] = \Illuminate\Support\Str::random(10) . time() . '.' . $attachment->extension();
            $request->attachment->move(public_path() . '/attach_file', $input['filename']);
            $data['attach']= $input['filename'];
        }
        $sale_return->update($data);
        return redirect('sale_return')->with('success','Updated Success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SaleReturn  $saleReturnController
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleReturn $saleReturnController)
    {
        //
    }
}
