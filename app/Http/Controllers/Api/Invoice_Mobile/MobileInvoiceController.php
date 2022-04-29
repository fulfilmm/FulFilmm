<?php

namespace App\Http\Controllers\Api\Invoice_Mobile;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Stock;
use Illuminate\Http\Request;

use App\Models\MainCompany;
use App\Models\AmountDiscount;
use App\Models\Customer;
use App\Models\Company;
use App\Models\Region;
use App\Models\Warehouse;
use App\Models\ProductVariant;
use App\Models\SaleZone;
use App\Models\product_price;
use App\Models\SellingUnit;
use App\Models\Freeofchare;
use App\Models\DiscountPromotion;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


use Illuminate\Support\Facades\Auth;


class MobileInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = Company::all();
        $Auth = Auth::guard('api')->user();
//        dd($Auth);
        $customer = Customer::where('region_id', $Auth->region_id)->where('branch_id', $Auth->office_branch_id)->get();
        $warehouse = Warehouse::where('branch_id', $Auth->office_branch_id)
            ->get();

        $product = Stock::with('varient')
            ->where('warehouse_id', $Auth->warehouse_id)
        ->where('available', '>', 0)
            ->get();

        $foc = Freeofchare::where('branch_id',$Auth->office_branch_id)
            ->get();

        $discount = DiscountPromotion::where('region_id',$Auth->region_id)->get();

        $dis_amt = AmountDiscount::where('region_id',$Auth->region_id)->get();

        $region = Region::where('id', $Auth->region_id)
            ->get();

        $zone = SaleZone::where('region_id',$Auth->region_id)->get();

        $selling_unit = SellingUnit::all();

        $selling_price = product_price::where('region_id',$Auth->region_id)->get();


        return response()->json(['company' => $company, 'customer' => $customer, 'warehouse' => $warehouse,
            'foc' => $foc, 'discount' => $discount, 'dis_amt' => $dis_amt, 'region' => $region,
            'zone' => $zone, 'selling_unit' => $selling_unit, 'selling_price' => $selling_price]);

    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'client_id' => 'required',
            'inv_date' => 'required',
            'due_date' => 'required',
            'client_address' => 'required',
            'bill_address' => 'required',
            'payment_method' => 'required',

            //for orderItems
            'variant_id' => 'required',
            'quantity' => 'required',
            'unit_price' => 'required',
            'total' => 'required',
            'creation_id' => 'required',
            'state' => 'required',
        ]);

        if ($validator->passes()) {
            $prefix = MainCompany::where('ismaincompany', true)->pluck('invoice_prefix', 'id')->first();
            $last_invoice = Invoice::orderBy('id', 'desc')->first();

            if ($last_invoice != null) {
                // Sum 1 + last id
                if ($prefix != null) {
                    $ischange = $last_invoice->invoice_id;
                    $ischange = explode("-", $ischange);
                    if ($ischange[0] == $prefix) {
                        $last_invoice->invoice_id++;
                        $invoice_id = $last_invoice->invoice_id;
                    } else {
                        $arr = [$prefix, $ischange[1]];
                        $pre = implode('-', $arr);

                        $pre++;
                        $invoice_id = $pre;
                    }
                } else {
                    $last_invoice->invoice_id++;
                    $invoice_id = $last_invoice->invoice_id;
                }
            } else {
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
            $newInvoice->status = "Done";
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
            $newInvoice->region_id = $request->region_id;
            $newInvoice->zone_id = $request->zone_id;
            $newInvoice->include_delivery_fee = $request->deli_fee_include == 'on' ? 1 : 0;
            $newInvoice->emp_id = Auth::guard('api')->user()->id;
            $newInvoice->branch_id = Auth::guard('api')->user()->office_branch_id;

            $order_item = json_decode($request->order_items);
            $foc_item = json_decode($request->foc_items);

            if (count($order_item) != 0) {
                $newInvoice->save();
                $customer = Customer::where('id', $request->client_id)->first();
                $customer->main_customer = 1;
                $customer->current_credit += $request->inv_grand_total;
                $customer->update();
                foreach ($order_item as $item) {
                    if ($item->foc) {
                        $unit = SellingUnit::where('id', $item->sell_unit)->first();
                        $stock = Freeofchare::where('variant_id', $item->variant_id)->first();
                        $item->inv_id = $newInvoice->id;
                        $item->update();
                        $stock->qty = $stock->qty - ($item->quantity * $unit->unit_convert_rate);
                        $stock->update();
                    } else {
                        $unit = SellingUnit::where('id', $item->sell_unit)->first();
                        $stock = Stock::where('variant_id', $item->variant_id)->where('warehouse_id', $request->warehouse_id)->first();
                        $item->inv_id = $newInvoice->id;
                        $item->cos_total = $item->quantity * $stock->cos;
                        $item->update();
                        $stock->available = $stock->available - ($item->quantity * $unit->unit_convert_rate);

                        $stock->update();
                    }
                }

                //order items 

                $variant = ProductVariation::where('id', $request->variant_id)
                    ->first();

                if ($request->type == 'invoice') {
                    foreach ($foc_item as $item) {

                        if (isset($request->foc)) {
                            $items = new OrderItem();
                            $items->description = 'This is FOC item';
                            $items->quantity = $item->quantity;
                            $items->variant_id = $request->variant_id;
                            $items->unit_price = 0;
                            $items->total = 0;
                            $items->inv_id = $invoice_id;
                            $items->creation_id = $request->invoice_id;
                            $items->order_id = $request->order_id ?? null;
                            $items->state = 1;
                            $items->foc = true;
                            $items->save();
                        } else {
                            $sale_unit = SellingUnit::where('product_id', $variant->product_id)->where('unit_convert_rate', 1)->first();
                            $price = product_price::where('sale_type', $request->inv_type)->where('product_id', $request->variant_id)->where('multi_price', $variant->pricing_type)->first();

                            if ($price != null) {
                                $items = new OrderItem();
                                $items->description = $variant->description;
                                $items->quantity = $item->quantity;
                                $items->variant_id = $request->variant_id;
                                $items->sell_unit = $sale_unit->id;
                                $items->unit_price = $price->price ?? 0;
                                $items->total = $item->total;
                                $items->inv_id = $invoice_id;
                                $items->sell_unit = $sale_unit->id ?? null;
                                $items->creation_id = $request->invoice_id;
                                $items->order_id = $request->order_id ?? null;
                                $items->state = 1;
                                $items->save();

                            }
                        }

                    }
                }


                //should I need to add these ???
                //
                // $inv_item= DB::table("order_items")
                //     ->select(DB::raw("SUM(cos_total) as total"))
                //     ->where('inv_id',$newInvoice->id)
                //     ->get();
                // $newInvoice->invoice_cos=$inv_item[0]->total;
                // $newInvoice->update();


                // if (isset($request->order_id)) {
                //     $order_item = OrderItem::where('order_id', $request->order_id)->get();
                //     $grand_total = 0;
                //     for ($i = 0; $i < count($order_item); $i++) {
                //         $grand_total = $grand_total + $order_item[$i]->total;
                //     }
                //     $order = Order::where('id', $request->order_id)->first();
                //     $order->grand_total = $grand_total;
                //     $order->update();
                // }

                //end

                //$this->add_history($newInvoice->id, 'Daft', 'Add' . $invoice_id);
                if (isset($request->save_type)) {
                    $this->sending_form($newInvoice->id);
                    return response()->json([
                        'url' => url('invoice/sendmail/' . $newInvoice->id)
                    ]);
                } else {
                    return response()->json([
                        'url' => url('invoices/' . $newInvoice->id)
                    ]);
                }
            } else {
                return response()->json([
                    'orderempty' => 'Empty Item',
                ]);
            }


        } else {
            return response()->json(['error' => $validator->errors()]);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
