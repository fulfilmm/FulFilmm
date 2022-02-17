<?php

namespace App\Http\Controllers;

use App\Models\BillItem;
use App\Models\DeliveryOrder;
use App\Models\ProductVariations;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BillItemController extends Controller
{
    public function store(Request $request)
    {
        $Auth = Auth::guard('employee')->user()->id;
            if (!Session::has("bill-" . $Auth)) {
                Session::push("bill-" . $Auth, $request->all());
            }

        $items = new BillItem();
        if($request->type=='Purchase'){
            $purchase_order=PurchaseOrder::where('id',$request->item_id)->first();
            $items->po_id=$request->item_id;
            $items->amount = $purchase_order->grand_total;
            $items->type='Purchase';
        }else{
            $deli=DeliveryOrder::where('id',$request->item_id)->first();
            $items->delivery_id=$request->item_id;
            $items->amount = $deli->delivery_fee;
            $items->type='Delivery';

        }

        $items->creation_id = $request->creation_id;
        $items->save();
//        if($request->order_id!=null){
//            $order=Order::where('id',$request->order_id)->first();
//            $order->total_amount=$request->grand_total+$product->sale_price;
//            $order->update();
//        }
        return response()->json([
            'Message' => 'Success'
        ]);
    }
    public function update(Request $request,$id)
    {
        $items = BillItem::where('id', $id)->first();
        $items->amount = $request->total;
        $items->description = $request->description;
        $items->update();
//        if($items->order_id!=null){
//            $order=Order::where('id',$items->order_id)->first();
//            $order->total_amount=$request->grand_total+$request->total;
//            $order->update();
//        }
        return response()->json([
            'Message' => 'Success'
        ]);
    }
    public function destroy($id){
        $item=BillItem::where('id',$id)->first();
        $item->delete();
        return redirect()->back();

    }
}
