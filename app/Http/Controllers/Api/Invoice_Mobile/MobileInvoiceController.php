<?php

namespace App\Http\Controllers\Api\Invoice_Mobile;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\OfficeBranch;
use App\Models\OrderItem;
use App\Models\products_tax;
use App\Models\ProductVariations;
use App\Models\Stock;
use Carbon\Carbon;
use http\Env\Response;
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
    public  $status=['Paid','Unpaid','Pending','Cancel'];
    public function index()
    {

        $zone=SaleZone::all();// sale zone နဲ့ filter လုပ်ဖို့ထုတ်ထားတာ
        $region=Region::all()->pluck('name','id')->all();//Region နဲ့ filter လုပ်ဖို့ထုတ်ထားတာ
        $branch=OfficeBranch::all()->pluck('name','id')->all(); //Branch နဲ့ filter လုပ်ဖို့ထုတ်ထားတာ
        if(Auth::guard('api')->user()->role->name=='Super Admin'|| Auth::guard('api')->user()->role->name=='CEO'||Auth::guard('api')->user()->role->name=='Sale Manager'){
            $allinv=Invoice::with('customer','employee','branch','zone','region')->get();//Super Admin နဲ့ CEO က invoice အားလုံးကြည့်လို့ရတအောင်အကုန်ထုတ်ပေးတယ်
        }elseif (Auth::guard('api')->user()->role->name=='Sale Manager'||Auth::guard('api')->user()->role->name=='Accountant'||Auth::guard('api')->user()->role->name=='Cashier'){
            $allinv=Invoice::with('customer','employee','branch','zone','region')->where('branch_id',Auth::guard('api')->user()->office_branch_id)->get();
        }else{
            $allinv=Invoice::with('customer','employee','branch','zone','region')->where('emp_id',Auth::guard('api')->user()->id)->get();//ရိုးရိုးsale man တေက သူဖွင့်ထားတဲ့ invoice ကိုဘဲကြည့်လို့ရမယ်
        }

        $status=$this->status;
//        dd($allinv);
//        return \response()->json(['lajsldfjs']);
        return response()->json(['allinv'=>$allinv,'status'=>$status,'zone'=>$zone,'branch'=>$branch,'region'=>$region]);

    }

    public function create()
    {
        $Auth=Auth::guard('api')->user();
        if($Auth->office_branch_id!=null && $Auth->region_id!=null){
            $allcustomers = Customer::where('branch_id',$Auth->office_branch_id)->where('region_id',$Auth->region_id)->get();
            $taxes = products_tax::all();
            $status = $this->status;
            $unit=SellingUnit::where('active',1)->get();
            $prices =product_price::where('sale_type', 'Whole Sale')->where('active',1)->where('region_id',$Auth->region_id)->get();
            //dd($prices);
            $dis_promo = DiscountPromotion::where('sale_type', 'Whole Sale')
                ->where('region_id',$Auth->region_id)
                ->get();
            $focs = Freeofchare::with('variant')->where('region_id',$Auth->region_id)->get();
            $type = 'Whole Sale';

            if(Auth::guard('api')->user()->mobile_seller==1){
                $warehouse =Warehouse::where('branch_id', $Auth->office_branch_id)
                    ->where('mobile_warehouse',1)->where('id',$Auth->warehouse_id)
                    ->first();
            }else{
                $warehouse =Warehouse::where('branch_id', $Auth->office_branch_id)
                    ->where('mobile_warehouse',0)->where('id',$Auth->warehouse_id)
                    ->first();
            }
            $aval_product =[];
            $in_stock=Stock::with('variant','unit')->where('available', '>', 0)->where('warehouse_id',$Auth->warehouse_id)->get();
            foreach ($in_stock as $inhand){
                if($inhand->variant->enable==1){
                    array_push($aval_product,$inhand);
                }
            }

            $amount_discount=AmountDiscount::whereDate('start_date','<=',date('Y-m-d'))
                ->whereDate('end_date','>=',date('Y-m-d'))
                ->where('sale_type','Whole Sale')
                ->where('region_id',$Auth->regioin_id)
                ->get();
            $due_default=Carbon::today()->addDay(1);
            $companies=Company::all()->pluck('name','id')->all();
            $zone=SaleZone::where('region_id',$Auth->region_id)->get();
            $region=Region::where('branch_id',$Auth->office_branch_id)->get();
            return response()->json(['zone'=>$zone,'warehouse'=>$warehouse, 'type'=>$type, 'allcustomers'=>$allcustomers, 'status'=>$status,'aval_product'=>$aval_product, 'taxes'=>$taxes, 'unit'=>$unit, 'dis_promo'=>$dis_promo, 'focs'=>$focs,'prices'=>$prices,'amount_discount'=>$amount_discount,'due_default'=>$due_default,'companies'=>$companies,'region'=>$region]);
        }else{
            return response()->json(['error'=>'Firstly,Fixed your Branch Office and Sale Region']);
        }
    }
    public function retail(){
        $Auth=Auth::guard('api')->user();
        if($Auth->office_branch_id!=null && $Auth->region_id!=null){
            $allcustomers = Customer::where('branch_id',$Auth->office_branch_id)->where('region_id',$Auth->region_id)->get();
            $aval_product =[];
            $in_stock=Stock::with('variant','unit')->where('available', '>', 0)->where('warehouse_id',$Auth->warehouse_id)->get();
            foreach ($in_stock as $inhand){
                if($inhand->variant->enable==1){
                    array_push($aval_product,$inhand);
                }
            }
//        foreach ($pd as $product){
//
//            if($pd!=null){
//                $stock=Stock::where('variant_id',$product->id)->where('available','>',0)->first();
//                if($stock!=null){
//                    array_push($variants,$product);
//                }
//            }
//        }
            $taxes=products_tax::all();
            $status=$this->status;
            $unit=SellingUnit::where('active',1)->get();
            $prices=product_price::where('sale_type','Retail Sale')->where('active',1)->where('region_id',$Auth->region_id)->get();
            $dis_promo=DiscountPromotion::where('sale_type','Retail Sale')
                ->where('region_id',$Auth->region_id)
                ->get();
            $focs=Freeofchare::with('variant')->where('region_id',$Auth->region_id)->get();
            $type='Retail Sale';
            $Auth=Auth::guard('api')->user();
            if(Auth::guard('api')->user()->mobile_seller==1){
                $warehouse =Warehouse::where('mobile_warehouse',1)->where('id',$Auth->warehouse_id)->first();
            }else{
                $warehouse =Warehouse::where('mobile_warehouse',0)->where('id',$Auth->warehouse_id)->first();

            }

            $amount_discount=AmountDiscount::whereDate('start_date','<=',date('Y-m-d'))
                ->whereDate('end_date','>=',date('Y-m-d'))
                ->where('sale_type','Retail Sale')
                ->where('region_id',$Auth->region_id)
                ->get();
            $due_default=Carbon::today()->addDay(1);
            $companies=Company::all()->pluck('name','id')->all();
            $zone=SaleZone::where('region_id',$Auth->region_id)->get();
            $region=Region::where('branch_id',$Auth->office_branch_id)->get();
            return response()->json(['zone'=>$zone,'warehouse'=>$warehouse, 'type'=>$type, 'allcustomers'=>$allcustomers, 'status'=>$status,'aval_product'=>$aval_product, 'taxes'=>$taxes, 'unit'=>$unit, 'dis_promo'=>$dis_promo, 'focs'=>$focs,'prices'=>$prices,'amount_discount'=>$amount_discount,'due_default'=>$due_default,'companies'=>$companies,'region'=>$region]);
        }else{
            return response()->json(['error'=>'Firstly,Fixed your Branch Office and Sale Region']);
        }
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request -> all(), [
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

        if($validator->passes()) {
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
            $newInvoice->region_id=$request->region_id;
            $newInvoice->zone_id=$request->zone_id;
            $newInvoice->include_delivery_fee=$request->deli_fee_include=='on'?1:0;
            $newInvoice->emp_id = Auth::guard('api')->user()->id;
            $newInvoice->branch_id=Auth::guard('api')->user()->office_branch_id;
           
            $order_item = json_decode($request -> order_items);
            $foc_item = json_decode($request -> foc_items);

            if (count($order_item) != 0) {
                $newInvoice->save();
                $customer=Customer::where('id',$request->client_id)->first();
                $customer->main_customer=1;
                $customer->current_credit+=$request->inv_grand_total;
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
                        $unit = SellingUnit::where('id',$item->sell_unit)->first();
                        $stock = Stock::where('variant_id', $item->variant_id)->where('warehouse_id', $request->warehouse_id)->first();
                        $item->inv_id = $newInvoice->id;
                        $item->cos_total=($item->quantity*$unit->unit_convert_rate)*$stock->cos;
                        $item->update();
                        $stock->available = $stock->available - ($item->quantity * $unit->unit_convert_rate);

                        $stock->update();
                    }
                }

                //order items

                $variant =ProductVariations::where( 'id', $request -> variant_id)
                                            ->first();

                if ($request->type == 'invoice') {
                    foreach($foc_item as $item){

                        if (isset($request->foc)) {
                                $items = new OrderItem();
                                $items->description = 'This is FOC item';
                                $items->quantity = $item -> quantity;
                                $items->variant_id = $request->variant_id;
                                $items->unit_price = 0;
                                $items->total = 0;
                                $items->inv_id = $newInvoice->id;
                                $items->creation_id = $invoice_id;
                                $items->order_id = $request->order_id ?? null;
                                $items->state = 1;
                                $items->foc=true;
                                $items->save();
                                }
                                else{
                                    $sale_unit = SellingUnit::where('product_id', $variant->product_id)->where('unit_convert_rate', 1)->first();
                                    $price = product_price::where('sale_type',$request->inv_type)->where('product_id', $request->variant_id)->where('multi_price',$variant->pricing_type)->first();

                                    if($price != null){
                                        $items = new OrderItem();
                                        $items->description =$variant->description;
                                        $items->quantity = $item->quantity;
                                        $items->variant_id = $request->variant_id;
                                        $items->sell_unit = $sale_unit->id;
                                        $items->unit_price =$price->price ?? 0;
                                        $items->total = $item -> total;
                                        $items->inv_id = $newInvoice->id;
                                        $items->sell_unit = $sale_unit->id??null;
                                        $items->creation_id = $invoice_id;
                                        $items->order_id = $request->order_id ?? null;
                                        $items->state = 1;
                                        $items->save();

                                        }
                                    }

                                }
                            }




                //should I need to add these ???
                //
                 $inv_item= DB::table("order_items")
                     ->select(DB::raw("SUM(cos_total) as total"))
                     ->where('inv_id',$newInvoice->id)
                     ->get();
                 $newInvoice->invoice_cos=$inv_item[0]->total;
                 $newInvoice->update();



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





        }else{
            return response()->json(['error'=>$validator->errors()]);
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
