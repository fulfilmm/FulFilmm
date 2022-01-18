<?php

namespace App\Http\Controllers;

use App\Models\ProductVariations;
use App\Models\SellingUnit;
use Illuminate\Http\Request;

class SellingUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sellingunits=SellingUnit::with('variant')->get();
        return view('sale.sellingunit.index',compact('sellingunits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products=ProductVariations::all();
        return view('sale.sellingunit.create',compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        SellingUnit::create($request->all());
        return redirect(route('sellingunits.index'));
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
        $unit=SellingUnit::where('id',$id)->firstOrFail();
        $products=ProductVariations::all();
        return view('sale.sellingunit.edit',compact('unit','products'));
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
        $unit=SellingUnit::where('id',$id)->first();
        $unit->unit=$request->unit;
        $unit->price=$request->price;
        $unit->sale_type=$request->sale_type;
        $unit->variant_id=$request->variant_id;
        $unit->update();
        return redirect(route('sellingunits.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $unit=SellingUnit::where('id',$id)->firstOrFail();
        $unit->delete();
        return redirect(route('sellingunits.index'));
    }
}
