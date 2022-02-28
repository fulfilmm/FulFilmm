<?php

namespace App\Http\Controllers;

use App\Models\ProductVariations;
use App\Models\PurchaseOrderItem;
use App\Models\SellingUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PurchaseOrderItemController extends Controller
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
      if(!isset($request->po_id)){
          $Auth=Auth::guard('employee')->user()->id;
          if(!Session::has("poformdata-".$Auth)){
              Session::push("poformdata-".$Auth,$request->all());
          }
      }
      $product_variant=ProductVariations::where('id',$request->variant_id)->first();
      $unit=SellingUnit::where('product_id',$product_variant->product_id)->where('unit_convert_rate',1)->first();
        if($unit!=null){
            PurchaseOrderItem::create(
                [   'po_id'=>$request->po_id,
                    'variant_id'=>$request->variant_id,
                    'description'=>$request->description,
                    'qty'=>1,
                    'total'=>$product_variant->purchase_price??0,
                    'price'=>$product_variant->purchase_price??0,
                    'creation_id'=>$request->creation_id,
                    'unit'=>$unit->id
                ]
            );
        }else{
            return response()->json(['error'=>'Dose not exists any unit']);
        }
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
        $po_item=PurchaseOrderItem::where('id',$id)->first();
        $po_item->qty=$request->qty;
        $po_item->price=$request->price;
        $po_item->total=$request->total;
        $po_item->description=$request->description;
        $po_item->unit=$request->unit;
        $po_item->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        PurchaseOrderItem::where('id',$request->item_id)->first()->delete();
    }
}
