<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\ProductVariations;
use App\Models\QuotationItem;
use App\Models\SellingUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $form_data = [
            'product_id' => $request->product_id,
            'quotation_id' => $request->quotation_id,
            'customer' => $request->customer,
            'expiration' => $request->expiration,
            'payment_term' => $request->payment_term,
            'term_and_condition' => $request->term_and_condition,
            'deal_id' => $request->deal_id,
            'sale_type'=>$request->sale_type,
        ];
        $Auth=Auth::guard('employee')->user()->id;
        if(!Session::has($Auth)){
            Session::push("quotation-".$Auth,$form_data);
        }
        $variant=ProductVariations::with('product')->where('id',$request->variant_id)->first();
        $unit=SellingUnit::where('unit_convert_rate',1)->first();
        $order_line = new QuotationItem();
        $order_line->variant_id=$request->variant_id;
        $order_line->description = $variant->description;
        $order_line->quantity = 1;
        $order_line->price =0;
        $order_line->unit_id=$unit->id;
        $order_line->total_amount =0;
        $order_line->quotation_id = $request->quotation_id;
        $order_line->save();
        return response()->json(['message' => 'New Item Add Success']);
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
//        dd($request->all());
        $order_line = QuotationItem::where("id", $id)->first();
        $order_line->quantity = $request->quantity;
        $order_line->price = $request->unit_price;
        $order_line->unit_id=$request->unit_id;
        $order_line->total_amount = $request->total;
        $order_line->discount_id=$request->discount_pro==0?null:$request->discount_pro;
        $order_line->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $orderline = QuotationItem::where("id", $id)->first();
        $orderline->delete();
        return response()->json(['delete' => 'Success']);
    }
}
