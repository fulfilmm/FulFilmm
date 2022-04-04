<?php

namespace App\Http\Controllers\Api\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\orderItem;
use App\Models\MainCompany; 
use App\Models\Stock;
use App\Models\product;
use App\Models\product_price;
use App\Models\products_tax;
use App\Models\ProductVariations;
use App\Models\Freeofchare;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class InvoiceDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $status = ['Paid' , 'Unpaid', 'Pending', 'Cancel'];
    public function index()
    {
            $all_inv = Invoice::with('customer') 
                        ->get();
            $customers = Customer::with('company')
                        ->get();
            $products = Stock::with('variant')->where('available', '>', 0)->get();

            $focs = Freeofchare::with('variant')->get();

            $status = $this -> status;

            return response() -> json(['all_inv' => $all_inv,'customers' => $customers,'status' => $status ,
                                         'products' => $products, 'focs' => $focs]);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make( $request -> all(), [
            'title' => 'required',
            'client_id' => 'required',
            'client_email' => 'required',
            'inv_date' => 'required',
            'due_date' => 'required',
            'client_address' => 'required',
            'bill_address' => 'required',
            'payment_method' => 'required',
        ]);

        if( $validator -> passes()){
            $prefix = MainCompany::where('ismaincompany' , true) 
                                    -> pluck('invoice_prefix', 'id') 
                                    -> first();
            $last_invoice = Invoice::orderBy('id' , 'desc')
                                    ->first();

            if ($last_invoice !=  null){
                if($prefix != null){
                    $ischange = $last_invoice -> invoice_id;
                    $ischange = explode("-" , $ischange);
                    if($ischange[0] == $prefix){
                        $last_invoice -> invoice_id ++;
                        $invoice_id = $last_invoice -> invoice_id;
                    }

                    else{
                        $arr = [$prefix, $ischange[1]];
                        $pre = implode('-', $arr);

                        $pre++ ;
                        $invoice_id = $pre;
                    }
                }
                else {
                    $last_invoice->invoice_id++ ;
                    $invoice_id = $last_invoice -> invoice_id;
                }
            }
            else {
                $invoice_id = ($prefix ?: 'INV') . "-0001";
            }

            $newInvoice = new Invoice();
            $newInvoice->title = $request->title;
            $newInvoice->invoice_id = $invoice_id;
            $newInvoice->customer_id = $request->client_id;
            $newInvoice->email = $request->client_email;
            $newInvoice->customer_address = $request->client_address;
            $newInvoice->billing_address = $request->bill_address;
            $newInvoice->invoice_date = Carbon::create($request->inv_date);
            $newInvoice->due_date = Carbon::create($request->due_date);
            $newInvoice->other_information = $request->more_info;
            $newInvoice->grand_total = $request->inv_grand_total;
            $newInvoice->status = "Daft";
            $newInvoice->order_id = $request->order_id;
            $newInvoice->send_email = isset($request->save_type) ? 1 : 0;
            $newInvoice->payment_method = $request->payment_method;
            $newInvoice->tax_id = $request->tax_id;
            $newInvoice->total = $request->total;
            $newInvoice->discount = $request->discount;
            $newInvoice->tax_amount = $request->tax_amount;
            $newInvoice->invoice_type = $request->invoice_type;
            $newInvoice->delivery_fee = $request->delivery_fee;
            $newInvoice->due_amount = $request->inv_grand_total;
            $newInvoice->warehouse_id = $request->warehouse_id;
            $newInvoice->inv_type = $request->inv_type;
            $newInvoice->include_delivery_fee=$request->deli_fee_include=='on'?1:0;
            $newInvoice->emp_id = Auth::guard('employee')->user()->id;
            
            $Auth = Auth::guard('employee') -> user()-> name;
            $request_id = Session::get($Auth);
            $confirm_order_item = OrderItem::where("creation_id", $request_id) -> get();
            if( count($confirm_order_item) != 0){
                $newInvoice -> save();
                $customer = Customer::where('id' , $request -> client_id) -> first();
                $customer -> main_customer = 1;
                $customer -> update();

                foreach( $confirm_order_item as $item) {
                    if($item -> foc){
                        $unit = SellingUnit::where('id' , $item -> sell_unit) -> first();
                        $stock = Freeofchare::where('variant_id', $item-> variant_id) -> first();
                        $item -> inv_id = $newInvoice -> id;
                        $item -> update();

                        $stock->qty = $stock->qty - ($item->quantity * $unit->unit_convert_rate);
                        $stock->update();
                    }
                     else {
                        $unit = SellingUnit::where('id',$item->sell_unit)->first();
                        $stock = Stock::where('variant_id', $item->variant_id)->where('warehouse_id', $request->warehouse_id)->first();
                        $item->inv_id = $newInvoice->id;
                        $item->update();
                        $stock->available = $stock->available - ($item->quantity * $unit->unit_convert_rate);
                        $stock->update();
                         }
                    } 

                    if( isset($request -> order_id)){
                        $order_item = OrderItem::where('order_id' , $request -> order_id)
                                                ->get();
                        $grand_total = 0;
                        for ( $i = 0 ; $i < count($order_item); $i++){
                            $grand_total = $grand_total + $order_item[$i] -> total;
                        }

                        $order = Order::where('id' , $request -> order_id) -> first();
                        $order -> grand_total = $grand_total;
                        $order -> update();
                    }

                    Session::forget($Auth);
                    Session::forget('data-' . Auth::guard('employee') -> user() -> id);

                    $this -> add_history($newInvoice -> id, 'Daft', 'Add' .$invoice_id);
                    if( isset($request -> save_type)){
                        $this->sending_form($newInvoice -> id);
                        return response() -> json([
                            'url' => url('invoice/sendmail/'. $newInvoice->id)
                        ]);
                    }

                    else{
                        return response() -> json([
                            'url' => url('invoices/' .$newInvoice->id)
                        ]);

                    }
                } 
                else{
                    return response() -> json([
                        'orderempty' => 'Empty Item',
                    ]);
                }
            }

                else{
                    return response() -> json(['error' => $validator -> errors()]);
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
}
