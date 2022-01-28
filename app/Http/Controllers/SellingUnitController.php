<?php

namespace App\Http\Controllers;

use App\Models\product_price;
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
        foreach ($request->variant_id as $p_id){
            $data['variant_id']=$p_id;
            $data['unit']=$request->unit;
            $data['unit_convert_rate']=$request->unit_convert_rate;
            SellingUnit::create($data);
        }
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
        $unit->unit_convert_rate=$request->unit_convert_rate;
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
    public function price_list(){
//        dd('je;p');
        $units=SellingUnit::all();
        $products=ProductVariations::all();
        $price_lists=product_price::with('unit','variant')->get();
        return view('sale.sellingunit.price',compact('units','products','price_lists'));
    }
    public function store_price(Request $request){
        $this->validate($request,[
           'product_id'=>'required',
           'unit_id'=>'required',
           'sale_type'=>'required',
            'price'=>'required'
        ]);
        $exist_price=product_price::where('product_id',$request->product_id)->where('unit_id',$request->unit_id)->where('active',1)->first();
        if($exist_price==null) {
            product_price::create($request->all());
        }else{
            $exist_price->active=0;
            $exist_price->update();
            product_price::create($request->all());
        }
        return redirect()->back();
    }
    public function price_active($status,$id){
        $price=product_price::where('id',$id)->firstOrFail();
     if($status=='active'){
         $price->active=1;
     }else{
         $price->active=0;
     }
        $price->update();
     return redirect()->back();
    }
}
