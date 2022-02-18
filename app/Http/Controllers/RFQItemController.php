<?php

namespace App\Http\Controllers;

use App\Models\RFQItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RFQItemController extends Controller
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
        $Auth=Auth::guard('employee')->user()->id;
        if(!Session::has("rfqformdata-".$Auth)){
            Session::push("rfqformdata-".$Auth,$request->all());
        }
        RFQItems::create($request->all());
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
        $rfq_item=RFQItems::where('id',$id)->first();
        $rfq_item->product_id=$request->product_id;
        $rfq_item->qty=$request->qty;
        $rfq_item->price=$request->price;
        $rfq_item->total=$request->total;
        $rfq_item->unit=$request->unit;
        $rfq_item->description=$request->description;
        $rfq_item->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $rfq_item=RFQItems::where('id',$request->item_id)->first();
        $rfq_item->delete();
    }
}
