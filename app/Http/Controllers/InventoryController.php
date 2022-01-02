<?php

namespace App\Http\Controllers;

use App\Models\DeliveryOrder;
use App\Models\MainCompany;
use App\Models\product;
use App\Models\ProductReceive;
use App\Models\ProductReceiveItem;
use App\Models\ProductVariations;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\RequestForQuotation;
use App\Models\Warehouse;
use App\Traits\StockTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use StockTrait;
    public function index()
    {
       $to_receipt=ProductReceive::where('inprogress',1)->count();
       $deli_order=DeliveryOrder::where('state','!=','Done')->count();
        $allreceipt =ProductReceive::with('vendor','purchaseorder','employee')->where('inprogress',0)->get();
        return view('Inventory.inventory',compact('to_receipt','allreceipt','deli_order'));
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
        $receipt=ProductReceive::with('purchaseorder','vendor')->where('id',$id)->firstOrFail();
//        dd($receipt);
        $receipt_item=ProductReceiveItem::with('product','warehouse')->get();
        $product=product::all()->pluck('name','id')->all();
        $warehouse=Warehouse::all()->pluck('name','id')->all();
        return view('Inventory.receivedproduct',compact('receipt','receipt_item','product','warehouse'));
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
        $processes =ProductReceive::with('vendor','purchaseorder','employee')->where('inprogress',1)->get();

        return view('Inventory.list', compact('processes'));
    }
    public function product_validate(Request $request,$id){
      $receipt=ProductReceive::where('id',$id)->first();
//      dd($receipt);
      $rec_item=ProductReceiveItem::where('receipt_id',$id)->get();
      for ($i=0;$i<count($rec_item);$i++){
          $rec_item[$i]->demand=$request->demand[$i];
          $rec_item[$i]->qty=$request->done[$i];
          $rec_item[$i]->warehouse_id=$request->warehouse_id[$i];
          $rec_item[$i]->update();
      }
      $receipt->is_validate=1;
      $receipt->update();
      return redirect(route('receipt.show',$id));
    }
    public function reedit($id){
        $receipt=ProductReceive::where('id',$id)->first();
        $receipt->is_validate=0;
        $receipt->update();
        return redirect(route('receipt.show',$id));
    }
    public function receipt($id){
        $receipt=ProductReceive::where('id',$id)->first();
        $rec_item=ProductReceiveItem::where('receipt_id',$id)->get();
        foreach ($rec_item as $item) {
            $data = ['qty' => $item->qty,
                'warehouse_id' => $item->warehouse_id,
                'supplier_id' => $receipt->vendor_id,
                'variantion_id' => $item->variant_id
            ];
            $variant=ProductVariations::where('id',$item->variant_id)->first();
            $variant->purchase_price=$item->price;
            $variant->update();
//        dd($data);
            $this->stockin($data);
        }
        $receipt->inprogress=0;
        $receipt->update();

        $po=PurchaseOrder::where('id',$receipt->po_id)->first();
        $po->is_receipt=1;
        $po->update();
        return redirect(route('stocks.index'));
    }
}