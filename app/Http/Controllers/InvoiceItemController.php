<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class InvoiceItemController extends Controller
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
//        dd($request->all());
        $items=new OrderItem();
        $items->product_id=$request->product_id;
        $items->description=$request->description;
        $items->quantity=$request->quantity;
        $items->tax_id=$request->tax_id;
        $items->discount=$request->discount;
        $items->discount_type=$request->discount_type;
        $items->unit_price=$request->unit_price;
        $items->currency_unit=$request->currency_unit;
        $items->total=$request->total;
        $items->creation_id=$request->invoice_id;
        $items->state=1;
        $items->save();
        return response()->json([
            'Message'=>'Success'
        ]);
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
//        dd($request->all());
        $items=OrderItem::where('id',$id)->first();
        $items->product_id=$request->product_id;
        $items->description=$request->description;
        $items->quantity=$request->quantity;
        $items->tax_id=$request->tax_id;
        $items->unit_price=$request->unit_price;
        $items->currency_unit=$request->currency_unit;
        $items->total=$request->total;
        $items->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice_item=OrderItem::where('id',$id)->first();
        $invoice_item->delete();
        return redirect()->back()->with('success','Item remove success');
    }
}
