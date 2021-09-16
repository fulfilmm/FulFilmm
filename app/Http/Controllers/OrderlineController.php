<?php

namespace App\Http\Controllers;

use App\Models\QuotationItem;
use Illuminate\Http\Request;

class OrderlineController extends Controller
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
        $order_line=new QuotationItem();
        $order_line->product_id=$request-> product_id;
        $order_line->description=$request->description;
        $order_line->quantity=$request->quantity;
        $order_line->price=$request->price;
        $order_line->tax=$request->tax;
        $order_line->total_amount=$request->total;
        $order_line->quotation_id=$request->quotation_id;
        $order_line->save();
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
        $order_line=QuotationItem::where("id",$id)->first();
        $order_line->product_id=$request-> product_id;
        $order_line->description=$request->description;
        $order_line->quantity=$request->quantity;
        $order_line->price=$request->price;
        $order_line->tax=$request->tax;
        $order_line->total_amount=$request->total;
        $order_line->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $orderline=QuotationItem::where("id",$id)->first();
        $orderline->delete();
        return redirect()->back()->with('success','Order Item remove success');
    }
}
