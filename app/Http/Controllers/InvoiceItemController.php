<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\product;
use App\Models\ProductVariations;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class InvoiceItemController extends Controller
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
//        $stock=Stock::where('variant_id',$request->variant_id)->first();
//       if($stock->available > 0 ) {
           $Auth = Auth::guard('employee')->user()->id;
           if ($request->type == 'invoice') {
               if (!Session::has("data-" . $Auth)) {
                   Session::push("data-" . $Auth, $request->all());
               }
//            dd('invoice');
           } else if ($request->type == 'order') {
               if (Auth::guard('customer')->check()) {
//                dd('customer');
                   $customer = Auth::guard('customer')->user()->id;
                   if (!Session::has("order-" . $customer)) {
                       Session::push("order-" . $customer, $request->all());
                   }
               } else {
//                dd('employee');
                   if (!Session::has("order-" . $Auth)) {
                       Session::push("order-" . $Auth, $request->all());
                   }
               }
           }

           $variant = ProductVariations::where('id', $request->variant_id)->first();
           $items = new OrderItem();
           $items->product_id = $request->variant_id;
           $items->description = $variant->description;
           $items->quantity = 1;
           $items->unit_price = $variant->price ?? 0;
           $items->variant_id = $request->variant_id;
           $items->total = $variant->price ?? 0;
           $items->creation_id = $request->invoice_id;
           $items->order_id = $request->order_id ?? null;
           $items->state = 1;
           $items->save();
//        if($request->order_id!=null){
//            $order=Order::where('id',$request->order_id)->first();
//            $order->total_amount=$request->grand_total+$product->sale_price;
//            $order->update();
//        }
           return response()->json([
               'Message' => 'Success'
           ]);
//       }else{
//           return response()->json(['Error' => 'This product is Out of Stock']);
//       }
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
        $items=OrderItem::where('id',$id)->first();
        $items->product_id=$request->product_id;
        $items->quantity=$request->quantity;
        $items->unit_price=$request->unit_price;
        $items->total=$request->total;
        $items->update();
//        if($items->order_id!=null){
//            $order=Order::where('id',$items->order_id)->first();
//            $order->total_amount=$request->grand_total+$request->total;
//            $order->update();
//        }
        return response()->json([
            'Message'=>'Success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $invoice_item=OrderItem::where('id',$id)->first();
        $invoice_item->delete();
        return response()->json(['Delete'=>"Delete Success"]);
    }
}
