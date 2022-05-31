<?php

namespace App\Http\Controllers;

use App\Models\DamagedProduct;
use App\Models\DeliveryOrder;
use App\Models\MainCompany;
use App\Models\OfficeBranch;
use App\Models\product;
use App\Models\ProductReceive;
use App\Models\ProductReceiveItem;
use App\Models\ProductVariations;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\RequestForQuotation;
use App\Models\SellingUnit;
use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\StockTransaction;
use App\Models\Warehouse;
use App\Traits\StockTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
       $deli_order=DeliveryOrder::where('receipt','!=',1)->count();
        $allreceipt =ProductReceive::with('vendor','purchaseorder','employee')->where('inprogress',0)->get();
        $stock_transactions=StockTransaction::with('warehouse','stockin', 'stockout','variant')->whereDate('created_at',Carbon::today())->get();
        $damage= DB::table("damaged_products")
            ->select(DB::raw("SUM(qty) as qty"))
            ->get();
        $damage_product=$damage[0]->qty??0;
        return view('Inventory.inventory',compact('damage_product','to_receipt','allreceipt','deli_order','stock_transactions'));
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
        $receipt_item=ProductReceiveItem::with('product','warehouse','product_unit')->where('id',$id)->get();
        $sell_unit=SellingUnit::where('unit_convert_rate',1)->get();
        $product=product::all()->pluck('name','id')->all();
        $warehouse=Warehouse::where('mobile_warehouse',0)->pluck('name','id')->all();
        $auth=Auth::guard('employee')->user();
        if($auth->role->name=='CEO'||$auth->role->name=='Super Admin'||$auth->role->name=='Stock Manager'){
            $branch=OfficeBranch::all();
        }else{
            $branch=OfficeBranch::where('id',$auth->office_branch_id)->get();
        }
        return view('Inventory.receivedproduct',compact('receipt','receipt_item','product','warehouse','sell_unit','branch'));
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
      $rec_item=ProductReceiveItem::with('product_unit')->where('receipt_id',$id)->get();
      for ($i=0;$i<count($rec_item);$i++){
          $rec_item[$i]->demand=$request->demand[$i];
          $rec_item[$i]->qty=$request->done[$i];
          $rec_item[$i]->update();
      }
      $receipt->is_validate=1;
      $receipt->update();
      $po=PurchaseOrder::where('id',$receipt->po_id)->first();
      $po->is_receipt=1;
      $po->update();
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
       if($receipt->inprogress==1) {
           $rec_item = ProductReceiveItem::where('receipt_id', $id)->get();
           foreach ($rec_item as $item) {
               $data = [
                   'qty' => $item->qty??0,
                   'warehouse_id' => $item->warehouse_id,
                   'supplier_id' => $receipt->vendor_id,
                   'variantion_id' => $item->variant_id
               ];
               $variant = ProductVariations::where('id', $item->variant_id)->first();
               $variant->purchase_price = $item->price;
               $variant->update();
//        dd($data);
               $this->stockin($data);
           }
           $receipt->inprogress = 0;
           $receipt->update();

           $po =PurchaseOrder::where('id', $receipt->po_id)->first();
           $po->is_receipt = 1;
           $po->update();

           return redirect(route('stocks.index'));
       }else{
           return redirect(route('stocks.index'))->with('warning','Have been stock in !');
       }
    }
}
