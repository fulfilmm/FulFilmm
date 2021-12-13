<?php

namespace App\Http\Controllers;

use App\Models\ProductReceive;
use App\Models\ProductReceiveItem;
use App\Models\RequestForQuotation;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rfqprocess=ProductReceive::where('inprogress',1)->count();
        return view('Inventory.inventory',compact('rfqprocess'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $receipt=ProductReceive::with('vendor','rfq')->where('id',$id)->first();
        $receipt_item=ProductReceiveItem::with('product')->where('receipt_id',$receipt->id)->get();
        return view('Inventory.receivedproduct',compact('receipt','receipt_item'));
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
    public function recipt_proceslist(){
        $process = ProductReceive::with('rfq', 'vendor')->where('inprogress',1)->get();
        return view('Inventory.list', compact('process'));
    }
}
