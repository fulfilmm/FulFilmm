<?php

namespace App\Http\Controllers\Api\Invoice;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\product;
use App\Models\product_price;
use App\Models\ProductVariations;
use App\Models\SellingUnit;
use App\Models\Stock;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
 
class InvoiceDataItemController extends Controller
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

   
    public function store(Request $request)
    {
        $variant = ProductVariations::where('id' , $request->variant_id)
                                        ->first();
        
        $Auth = Auth::guard('employee') ->user() ->id;

        if($request -> type == 'invoice'){
            if(!Session::has("data-" .  $Auth)){
                Session::push("data-" . $Auth, $request -> all());
            }

            if(isset($request -> foc)){
                $items = new OrderItem();
                $items-> description = 'This is FOC item';
                $item->quantity = 1;
                $item->variant_id = $request->variant_id;
                $item->unit_price =0;
                $items->total = 0;
                $items->creation_id = $request->invoice_id;
                $items->order_id = $request->order_id ?? null;
                $items->state = 1;
                $items->foc=true;
                $items->save();

                return response() -> json ([ 'Message' => 'success']);

            }

            else {
                $sale_unit = SellingUnit::where('product_id', $variant -> product_id)
                                            ->where('unit_convert_rate', 1) -> first();
                
                $price = product_price::where('sale_type' , $request -> inv_type)
                                        ->where('product_id', $request -> varient_id)
                                        ->where('multi_price', $variant -> pricing_type)
                                        ->first();
                
                if($price != null){
                    $items = new OrderItem();
                    $items->description =$variant->description;
                    $items->quantity = 1;
                    $items->variant_id = $request->variant_id;
                    $items->sell_unit = $sale_unit->id;
                    $items->unit_price =$price->price ?? 0;
                    $items->total = $price->price ?? 0;
                    $items->sell_unit = $sale_unit->id??null;
                    $items->creation_id = $request->invoice_id;
                    $items->order_id = $request->order_id ?? null;
                    $items->state = 1;
                    $items->save();

                    return response() -> json ([
                        'Message' => 'Success'
                    ]);

                }

                else {
                    return response() -> json(['Error' => 'This product is does not fixed price']);
                }

            }
        } 

        else if ($request -> type == 'order'){
            $sale_unit = SellingUnit::where('product_id' , $variant -> product_id)
                                        ->where('unit_convert_rate' , 1) 
                                        ->first();

            if( $sale_unit != null){
                $price = product_price::where('sale_type' , 'Whole Sale')
                                        ->where('unit_id' , $sale_unit ->id)
                                        ->where('active' , 1)
                                        ->where('multi_price' , $variant -> pricing_type)
                                        ->first();
            }
            else{
                $price = null;
            }

            if (Auth::guard('customer') -> check()) {
                $customer = Auth::guard('customer') -> user() -> id;
            

            if (! Session::has("order-" .$Auth)){
                Session::push("order-" .$Auth, $request -> all());
               }
            }

            else {
                //                dd($request->all());
                                if (!Session::has("order-" . $Auth)) {
                
                                    Session::push("order-" . $Auth, $request->all());
                                }

            $items = new OrderItem();
            $items->description =$variant->description;
            $items->quantity = 1;
            $items->variant_id = $request->variant_id;
            $items->unit_price =$price->price??0;
            $items->total =$price->price??0;
            $items->sell_unit = $sale_unit->id??null;
            $items->creation_id = $request->invoice_id;
            $items->order_id = $request->order_id ?? null; 
            $items->state = 0;

            $items->save();
        return response()->json([
            'Message' => 'Success'
            ]);
        }
        }
    }

  
    public function show($id)
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
        dd($request->all());
        $items = OrderItem::where('id', $id)->first();
        $items->quantity = $request->quantity;
        $items->unit_price = $request->unit_price;
        $items->total = $request->total;
        $items->sell_unit = $request->sell_unit;
        $items->discount_promotion = $request->discount_pro;
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice_item = OrderItem::where('id', $id)->first();
        $invoice_item->delete();
        return response()->json(['Delete' => "Delete Success"]);
    }
}
