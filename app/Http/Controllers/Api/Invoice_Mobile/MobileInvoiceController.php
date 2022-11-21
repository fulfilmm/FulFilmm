<?php

namespace App\Http\Controllers\Api\Invoice_Mobile;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\DeliveryOrder;
use App\Models\DeliveryPay;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\InvoiceHistory;
use App\Models\OfficeBranch;
use App\Models\OrderItem;
use App\Models\products_tax;
use App\Models\ProductVariations;
use App\Models\Revenue;
use App\Models\Stock;
use App\Models\Transaction;
use App\Models\TransactionCategory;
use App\Traits\NotifyTrait;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;

use App\Models\MainCompany;
use App\Models\AmountDiscount;
use App\Models\Customer;
use App\Models\Company;
use App\Models\Region;
use App\Models\Warehouse;
use App\Models\SaleZone;
use App\Models\product_price;
use App\Models\SellingUnit;
use App\Models\Freeofchare;
use App\Models\DiscountPromotion;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Psy\Util\Str;


class MobileInvoiceController extends Controller
{
    use NotifyTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public  $status=['Paid','Unpaid','Pending','Cancel'];
    protected  $payment_method=['Cash',"Mobile Banking",'Bank'];
    public function index()
    {

        $zone=SaleZone::all();// sale zone နဲ့ filter လုပ်ဖို့ထုတ်ထားတာ
        $region=Region::all()->pluck('name','id')->all();//Region နဲ့ filter လုပ်ဖို့ထုတ်ထားတာ
        $branch=OfficeBranch::all()->pluck('name','id')->all(); //Branch နဲ့ filter လုပ်ဖို့ထုတ်ထားတာ
        if(Auth::guard('api')->user()->role->name=='Super Admin'|| Auth::guard('api')->user()->role->name=='CEO'||Auth::guard('api')->user()->role->name=='Sale Manager'){
            $allinv=Invoice::with('customer','employee','branch','zone','region')->orderBy('id', 'desc')->get();//Super Admin နဲ့ CEO က invoice အားလုံးကြည့်လို့ရတအောင်အကုန်ထုတ်ပေးတယ်
        }elseif (Auth::guard('api')->user()->role->name=='Sale Manager'||Auth::guard('api')->user()->role->name=='Accountant'||Auth::guard('api')->user()->role->name=='Cashier'){
            $allinv=Invoice::with('customer','employee','branch','zone','region')->orderBy('id', 'desc')->where('branch_id',Auth::guard('api')->user()->office_branch_id)->get();
        }else{
            $allinv=Invoice::with('customer','employee','branch','zone','region')->orderBy('id', 'desc')->where('emp_id',Auth::guard('api')->user()->id)->get();//ရိုးရိုးsale man တေက သူဖွင့်ထားတဲ့ invoice ကိုဘဲကြည့်လို့ရမယ်
        }
        $invoices=[];
        foreach($allinv as $item){
            $customer=Customer::where('id',$item->customer_id)->get();
                $item['inv_customer']=$customer;
                array_push($invoices,$item);
        }


        $status=$this->status;
//        dd($allinv);
//        return \response()->json(['lajsldfjs']);
        return response()->json(['result'=>$invoices,'status'=>$status,'zone'=>$zone,'branch'=>$branch,'region'=>$region,'con'=>true]);

    }

    public function create()
    {
        $Auth=Auth::guard('api')->user();
        if($Auth->office_branch_id!=null && $Auth->region_id!=null){
            $allcustomers = Customer::where('branch_id',$Auth->office_branch_id)->orderBy('id', 'desc')->where('region_id',$Auth->region_id)->get();
            $taxes = products_tax::all();
            $status = $this->status;
            $unit=SellingUnit::all();
            $prices =product_price::where('sale_type', 'Whole Sale')->where('active',1)->where('region_id',$Auth->region_id)->get();
            //dd($prices);
            $dis_promo = DiscountPromotion::where('sale_type', 'Whole Sale')
                ->where('start_date','<=',Carbon::today())->where('end_date','>=',Carbon::today())
                ->where('region_id',$Auth->region_id)
                ->get();
            $foc_item = Freeofchare::with('variant')->where('branch_id',$Auth->office_branch_id)->get();
            $focs=[];
            foreach ($foc_item as $item){
                $item->unit=SellingUnit::where('product_id',$item->variant->product_id)->get();
                array_push($focs,$item);
            }
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
                    $unit=SellingUnit::where('unit_convert_rate',1)->where('product_id',$inhand->variant->product_id)->first();
                    $price=product_price::where('product_id',$inhand->variant_id)->where('unit_id',$unit->id)->where('min',1)->where('sale_type',"Whole Sale")->first();
                    if(isset($price->price)){
                        $inhand->show_price=$price->price;
                        $inhand->image=$inhand->variant->image;
                        array_push($aval_product,$inhand);

                    }

                }
            }

            $amount_discount=AmountDiscount::whereDate('start_date','<=',date('Y-m-d'))
                ->whereDate('end_date','>=',date('Y-m-d'))
                ->where('sale_type','Whole Sale')
//                ->where('region_id',$Auth->regioin_id)
                ->get();
            $due_default=Carbon::today()->addDay(1);
            $companies=Company::select('id','name')->get();
            $zone=SaleZone::where('region_id',$Auth->region_id)->get();
            $region=Region::where('branch_id',$Auth->office_branch_id)->get();
            return response()->json(['zone'=>$zone,'warehouse'=>$warehouse, 'type'=>$type, 'allcustomers'=>$allcustomers, 'status'=>$status,'aval_product'=>$aval_product, 'taxes'=>$taxes, 'unit'=>$unit, 'dis_promo'=>$dis_promo, 'focs'=>$focs,'prices'=>$prices,'amount_discount'=>$amount_discount,'due_default'=>$due_default,'companies'=>$companies,'region'=>$region,
            'payment_method'=>$this->payment_method]);
        }else{
            return response()->json(['error'=>'Firstly,Fixed your Branch Office and Sale Region']);
        }
    }
    public function retail(){
        $Auth=Auth::guard('api')->user();
        if($Auth->office_branch_id!=null && $Auth->region_id!=null){
            $allcustomers = Customer::where('branch_id',$Auth->office_branch_id)->orderBy('id', 'desc')->where('region_id',$Auth->region_id)->get();
            $aval_product =[];
            $in_stock=Stock::with('variant','unit')->where('available', '>', 0)->where('warehouse_id',$Auth->warehouse_id)->get();
            foreach ($in_stock as $inhand){
                if($inhand->variant->enable==1){
                    $unit=SellingUnit::where('unit_convert_rate',1)->where('product_id',$inhand->product_id)->first();
                    $price=product_price::where('product_id',$inhand->variant_id)->where('unit_id',$unit->id)->where('min',1)->where('sale_type',"Retail Sale")->first();
                    if(isset($price->price)){
                        $inhand->show_price=$price->price;
                        $inhand->image=$inhand->variant->image;
                        array_push($aval_product,$inhand);

                    }
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
            $unit=SellingUnit::all();
            $prices=product_price::where('sale_type','Retail Sale')->where('active',1)->where('region_id',$Auth->region_id)->get();
            $dis_promo=DiscountPromotion::where('sale_type','Retail Sale')
                ->where('start_date','<=',Carbon::today())->where('end_date','>=',Carbon::today())
                ->where('region_id',$Auth->region_id)
                ->get();
            $foc_item=Freeofchare::with('variant')->where('branch_id',$Auth->office_branch_id)->get();
            $focs=[];
            foreach ($foc_item as $item){
                $item->unit=SellingUnit::where('product_id',$item->variant->product_id)->get();
                array_push($focs,$item);
            }
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
//                ->where('region_id',$Auth->region_id)
                ->get();
            $due_default=Carbon::today()->addDay(1);
            $companies=Company::all()->pluck('name','id')->all();
            $zone=SaleZone::where('region_id',$Auth->region_id)->get();
            $region=Region::where('branch_id',$Auth->office_branch_id)->get();
            return response()->json(['zone'=>$zone,'warehouse'=>$warehouse, 'type'=>$type, 'allcustomers'=>$allcustomers, 'status'=>$status,'aval_product'=>$aval_product, 'taxes'=>$taxes, 'unit'=>$unit, 'dis_promo'=>$dis_promo, 'focs'=>$focs,'prices'=>$prices,'amount_discount'=>$amount_discount,'due_default'=>$due_default,'companies'=>$companies,'region'=>$region,'payment_method'=>$this->payment_method]);
        }else{
            return response()->json(['error'=>'Firstly,Fixed your Branch Office and Sale Region']);
        }
    }
    public function store(Request $request)
    {
//        return response(Auth::guard('api')->user());
        $validator = Validator::make($request -> all(), [
//            'title' => 'required',
            'client_id' => 'required',
            'inv_date' => 'required',
            'due_date' => 'required',
            'client_address' => 'required',
            'bill_address' => 'required',
            'payment_method' => 'required',

            //for orderItems
//            'variant_id' => 'required',
//            'quantity' => 'required',
//            'unit_price' => 'required',
//            'total' => 'required',
//            'creation_id' => 'required',
//            'state' => 'required',
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
            try{
                $tax_amount=($request->tax_rate/100)*$request->total;
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
                $newInvoice->status = "Draft";
                $newInvoice->order_id = $request->order_id;
                $newInvoice->send_email = isset($request->save_type) ? 1 : 0;
                $newInvoice->payment_method = $request->payment_method;
                $newInvoice->tax_id = $request->tax_id;
                $newInvoice->total = $request->total;
                $newInvoice->discount = $request->discount;
                $newInvoice->tax_amount =$tax_amount;
                $newInvoice->tax_rate=$request->tax_rate;
                $newInvoice->invoice_type = $request->invoice_type;
                $newInvoice->delivery_fee = $request->delivery_fee;
                $newInvoice->due_amount = $request->inv_grand_total;
                $newInvoice->warehouse_id = Auth::guard('api')->user()->warehouse_id;
                $newInvoice->inv_type = $request->sale_type.' Sale';
                $newInvoice->region_id=Auth::guard('api')->user()->region_id;
                $newInvoice->zone_id=$request->zone_id;
                $newInvoice->include_delivery_fee=$request->deli_fee_include=='on'?1:0;
                $newInvoice->emp_id = Auth::guard('api')->user()->id;
                $newInvoice->branch_id=Auth::guard('api')->user()->office_branch_id;
                $newInvoice->save();
                $order_item = $request->order_items;
                $foc=$request->foc_items??[];
//                return response(count($order_item));
                if(count($order_item)!=0){
                    foreach ($order_item as $item){

                        $item['invoice_id']=$newInvoice->id;
                        $item['type']='invoice';
                        $this->item_store($item);

                    }
                }
                if(count($foc)!=0){
                    foreach ($foc as $item){
                        $item->invoice_id=$newInvoice->id;
                        $item->type='invoice';
                        $this->foc_add($item);
                    }
                }

                $confirm_order_item = OrderItem::where("inv_id", $newInvoice->id)->get(); //invoice item တေကို ပြန် confirm ပီး invoice id နဲ့တွဲတာ
                if (count($confirm_order_item) != 0) {
                    foreach ($confirm_order_item as $item) {
//                        return response($item);
                        if ($item->foc!=0) {

                            $unit = SellingUnit::where('id', $item->sell_unit)->first();
                            $foc_stock = Freeofchare::where('variant_id', $item->variant_id)->first();
                            $item->inv_id = $newInvoice->id;
                            $item->update();
                            $foc_stock->qty = $foc_stock->qty - ($item->quantity * $unit->unit_convert_rate);
                            $item->cos_total=($item->quantity * $unit->unit_convert_rate)*$foc_stock->cos;
                            $foc_stock->update();
                        } else {
                            $unit = SellingUnit::where('id',$item->sell_unit)->first();
                            $stock = Stock::where('variant_id', $item->variant_id)->where('warehouse_id', Auth::guard('api')->user()->warehouse_id)->first();
                            $item->inv_id = $newInvoice->id;
                            $item->cos_total=($item->quantity * $unit->unit_convert_rate)*$stock->cos;
                            $item->update();
                            $stock->available = $stock->available - ($item->quantity * $unit->unit_convert_rate);
                            $stock->update();
                        }
                    }

                    $inv_item= DB::table("order_items")
                        ->select(DB::raw("SUM(cos_total) as total"))
                        ->where('inv_id',$newInvoice->id)
                        ->get();
                    $newInvoice->invoice_cos=$inv_item[0]->total;
                    $newInvoice->update();
                }
                return response()->json(['inv_id'=>$newInvoice->id,'con'=>true]);
            }catch (\Exception $e){
                return \response()->json(['con'=>false,'msg'=>$e->getMessage()]);
            }

        }else{
            return response()->json(['con'=>false,'error'=>$validator->errors()]);
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
        $emps = Employee::where('office_branch_id', Auth::guard('api')->user()->office_branch_id)->get();
        $category = TransactionCategory::where('type', 1)->get();
        $customer = Customer::orWhere('customer_type', 'Customer')->orWhere('customer_type', 'Lead')->orWhere('customer_type', 'Partner')->orWhere('customer_type', 'Inquery')->get();
        $company=MainCompany::where('ismaincompany',true)->first();
        $detail_inv=Invoice::with('customer','employee','tax','order')->where('id',$id)->firstOrFail();
        $items=OrderItem::with('variant','unit')->where("inv_id",$detail_inv->id)->get();
        $invoic_item=[];
        foreach ($items as $item){
            $item->all_unit=SellingUnit::where('product_id',$item->variant->product_id)->get();
            array_push($invoic_item,$item);
        }
        $account=Account::where('enabled',1)->get();
        $recurring=['No','Daily','Weekly','Monthly','Yearly'];
        $payment_method=['Cash','eBanking','WaveMoney','KBZ Pay'];
        $revenue=Revenue::where('invoice_id',$id)->get();
//        dd($revenue);
        $history=InvoiceHistory::where('invoice_id',$id)->get();
        $transaction=[];
        foreach ($revenue as $tran){
            $revenue_transaction=Transaction::with('revenue')->where('revenue_id',$tran->id)->first();
            if($revenue!=null){
                array_push($transaction,$revenue_transaction);
            }

        }
        if($detail_inv->grand_total > $detail_inv->due_amount && $detail_inv->due_amount!=0){

            $detail_inv->status='Partial';
            $detail_inv->update();
            $this->add_history($id,'Partial','Change Status '.$detail_inv->invoice_id);
        }elseif($detail_inv->due_amount!=0 && Carbon::now()>$detail_inv->due_date && $detail_inv->created_at!=$detail_inv->due_date){
            $detail_inv->status='Overdue';
            $detail_inv->update();
            $this->add_history($id,'Overdue','Change Status '.$detail_inv->invoice_id);
        }elseif($detail_inv->due_amount==0){

            $detail_inv->status='Paid';
            $detail_inv->update();
            $this->add_history($id,'Paid','Change Status '.$detail_inv->invoice_id);
        }else{

            $detail_inv->status='Draft';
            $detail_inv->update();
            $this->add_history($id,'Draft','Change Status '.$detail_inv->invoice_id);
        }
        $transaction_amount=0;
//        $customer=Customer::orWhere('customer_type','Customer')->orWhere('customer_type','Lead')->orWhere('customer_type','Partner')->orWhere('customer_type','Inquery')->get();
        return response()->json([
            'emps' => $emps, 'customers' => $customer, 'recurring' => $recurring, 'payment_method' => $payment_method, 'category' => $category,
            'transaction'=>$transaction,'account'=>$account,'invoice'=>$detail_inv,'invoice_item'=>$invoic_item,'company'=>$company,'transaction_amount'=>$transaction_amount,'history'=>$history
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $Auth=Auth::guard('api')->user();
        $company=MainCompany::where('ismaincompany',true)->first();
        $emps = Employee::where('office_branch_id', Auth::guard('api')->user()->office_branch_id)->get();
       $cashier=[];
        foreach ($emps as $emp){
            if($emp->role->name=='Cashier'){
                array_push($cashier,$emp);
            }
        }
        $category = TransactionCategory::where('type', 1)->get();
        $recurring=['No','Daily','Weekly','Monthly','Yearly'];
        $payment_method=['Cash','eBanking','WaveMoney','KBZ Pay'];
        $invoice=Invoice::with('customer','employee','tax','order')->where('id',$id)->firstOrFail();
        $allcustomers = Customer::where('branch_id',$Auth->office_branch_id)->where('region_id',$Auth->region_id)->get();
        $taxes = products_tax::all();

        $prices =product_price::where('sale_type',$invoice->inv_type)->where('active',1)->where('region_id',$Auth->region_id)->get();
        //dd($prices);
        $dis_promo = DiscountPromotion::where('sale_type',$invoice->inv_type)
            ->where('start_date','<=',Carbon::today())->where('end_date','>=',Carbon::today())
            ->where('region_id',$Auth->region_id)
            ->get();
        $focs = Freeofchare::with('variant')->where('branch_id',$Auth->office_branch_id)->get();
        $items=OrderItem::with('variant','unit')->where("inv_id",$invoice->id)->get();
        $invoice_item=[];
        foreach ($items as $item){
            $item->all_unit=SellingUnit::where('product_id',$item->variant->product_id)->get();
            array_push($invoice_item,$item);
        }
        $warehouse =Warehouse::where('branch_id', $Auth->office_branch_id)
            ->where('id',$invoice->warehouse_id)
            ->first();
        $amount_discount=AmountDiscount::whereDate('start_date','<=',date('Y-m-d'))
            ->whereDate('end_date','>=',date('Y-m-d'))
            ->where('sale_type',$invoice->inv_type)
//                ->where('region_id',$Auth->regioin_id)
            ->get();
        $companies=Company::select('id','name')->get();
        $zone=SaleZone::where('region_id',$Auth->region_id)->get();
        $region=Region::where('branch_id',$Auth->office_branch_id)->get();
        if($invoice->grand_total > $invoice->due_amount && $invoice->due_amount!=0){

            $invoice->status='Partial';
            $invoice->update();
            $this->add_history($id,'Partial','Change Status '.$invoice->invoice_id);
        }elseif($invoice->due_amount!=0 && Carbon::now()>$invoice->due_date && $invoice->created_at!=$invoice->due_date){
            $invoice->status='Overdue';
            $invoice->update();
            $this->add_history($id,'Overdue','Change Status '.$invoice->invoice_id);
        }elseif($invoice->due_amount==0){

            $invoice->status='Paid';
            $invoice->update();
            $this->add_history($id,'Paid','Change Status '.$invoice->invoice_id);
        }else{

            $invoice->status='Draft';
            $invoice->update();
            $this->add_history($id,'Draft','Change Status '.$invoice->invoice_id);
        }

        return response()->json([
            'invoice'=>$invoice,
            'invoice_item'=>$invoice_item,
            'warehouse'=>$warehouse,
            'customers'=>$allcustomers,
            'tax'=>$taxes,
            'price'=>$prices,
            'discount'=>$dis_promo,
            'foc'=>$focs,
            'amount_discount'=>$amount_discount,
            'companies'=>$companies,
            'zones'=>$zone,
            'region'=>$region,
            'cashier'=>$cashier,
            'payment_category'=>$category,
            'payment_method'=>$payment_method,
            'base_company'=>$company

        ]);
    }

    public function update(Request $request, $id)
    {
        if(isset($request->mark_sent)){
            $update_Invoice=Invoice::where('id',$id)->first();
            $update_Invoice->mark_sent=$request->mark_sent;
            $update_Invoice->update();
            return response()->json(['message' => 'Success','invoice'=>$id]);

        }else {
            try {
                $tax_amount = ($request->tax_rate / 100) * $request->total;
                $update_inv = Invoice::where('id', $id)->first();
                $update_inv->title = $request->title;
                $update_inv->customer_id = $request->client_id;
                $update_inv->email = $request->client_email;
                $update_inv->customer_address = $request->client_address;
                $update_inv->billing_address = $request->bill_address;
                $update_inv->invoice_date = Carbon::create($request->inv_date);
                $update_inv->due_date = Carbon::create($request->due_date);
                $update_inv->other_information = $request->more_info;
                $update_inv->grand_total = $request->inv_grand_total;
                $update_inv->status = "Paid";
                $update_inv->order_id = $request->order_id;
                $update_inv->send_email = isset($request->save_type) ? 1 : 0;
                $update_inv->payment_method = $request->payment_method;
                $update_inv->tax_id = $request->tax_id;
                $update_inv->total = $request->total;
                $update_inv->discount = $request->discount;
                $update_inv->tax_amount = $tax_amount;
                $update_inv->tax_rate = $request->tax_rate;
                $update_inv->invoice_type = $request->invoice_type;
                $update_inv->delivery_fee = $request->delivery_fee;
                $update_inv->due_amount = $request->inv_grand_total;
                $update_inv->warehouse_id = $request->warehouse_id;
                $update_inv->inv_type = $request->sale_type;
                $update_inv->region_id = Auth::guard('api')->user()->region_id;
                $update_inv->zone_id = $request->zone_id;
                $update_inv->include_delivery_fee = $request->deli_fee_include == 'on' ? 1 : 0;
                $update_inv->emp_id = Auth::guard('api')->user()->id;
                $update_inv->branch_id = Auth::guard('api')->user()->office_branch_id;
                $update_inv->update();


                $order_item = json_decode($request->order_items);

                if (count($order_item) != 0) {

                    foreach ($order_item as $item) {
                        $item->invoice_id = $update_inv->id;
                        $item->type = 'invoice';
                        $this->item_update($item);

                    }
                }
                if($update_inv->grand_total > $update_inv->due_amount && $update_inv->due_amount!=0){

                    $update_inv->status='Partial';
                    $update_inv->update();
                    $this->add_history($id,'Partial','Change Status '.$update_inv->invoice_id);
                }elseif($update_inv->due_amount!=0 && Carbon::now()>$update_inv->due_date && $update_inv->created_at!=$update_inv->due_date){
                    $update_inv->status='Overdue';
                    $update_inv->update();
                    $this->add_history($id,'Overdue','Change Status '.$update_inv->invoice_id);
                }elseif($update_inv->due_amount==0){

                    $update_inv->status='Paid';
                    $update_inv->update();
                    $this->add_history($id,'Paid','Change Status '.$update_inv->invoice_id);
                }else{

                    $update_inv->status='Draft';
                    $update_inv->update();
                    $this->add_history($id,'Draft','Change Status '.$update_inv->invoice_id);
                }
                return response()->json(['message' => 'Success']);
            } catch (\Exception $e) {
                return response()->json(['message' => $e->getMessage()]);
            }
        }
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
    public function item_store($request)
    {
//        return response($request);
        $variant = ProductVariations::where('id', $request['variant_id'])->first();
//        return response($variant);
        if ($request['type'] == 'invoice') {
            $sub_total=$request['qty']*$request['price'];
            $discount=($request['discount']/100)*$sub_total;
            $total=$sub_total-$discount;
            $items = new OrderItem();
            $items->description =$variant->description;
            $items->quantity =$request['qty'];
            $items->variant_id = $request['variant_id'];
            $items->sell_unit = $request['unit_id'];
            $items->unit_price =$request['price'] ?? 0;
            $items->total =$total ?? 0;
            $items->discount_promotion=$request['discount'];
            $items->creation_id =\Illuminate\Support\Str::random(10);
            $items->inv_id = $request['invoice_id'];
            $items->order_id = $request['order_id'] ?? null;
            $items->state = 1;
            $items->save();
        }

    }
    public function item_update($request){
        $variant = ProductVariations::where('id', $request->variant_id)->first();
        if ($request->type == 'invoice') {
            $sub_total=$request->quantity*$request->unit_price;
            $discount=($request->discount_promotion/100)*$sub_total;
            $total=$sub_total-$discount;
            $items = OrderItem::where('id',$request->id)->first();
            $items->description =$variant->description;
            $items->quantity =$request->quantity;
            $items->variant_id = $request->variant_id;
            $items->sell_unit = $request->sell_unit;
            $items->unit_price =$request->unit_price ?? 0;
            $items->total =$total ?? 0;
            $items->discount_promotion=$discount;
            $items->creation_id =\Illuminate\Support\Str::random(10);
            $items->inv_id = $request->invoice_id;
            $items->order_id = $request->order_id ?? null;
            $items->state = 1;
            $items->update();
        }
    }
    public function foc_add($request){
        $variant = ProductVariations::where('id', $request->variant_id)->first();
        $items = new OrderItem();
        $items->description = 'This is FOC item';
        $items->quantity = 1;
        $items->variant_id = $variant->id;
        $items->unit_price = 0;
        $items->sell_unit = $request->unit_id;
        $items->total = 0;
        $items->creation_id =\Illuminate\Support\Str::random(10);
        $items->inv_id = $request->invoice_id;
        $items->order_id = $request->order_id ?? null;
        $items->state = 1;
        $items->foc=true;
        $items->save();
    }
    public function add_history($id,$status,$desc){
        $old_state=InvoiceHistory::where('invoice_id',$id)->where('status',$status)->first();
        if($old_state==null){
            $history=new InvoiceHistory();
            $history->invoice_id=$id;
            $history->status=$status;
            $history->description=$desc;
            $history->save();
        }

    }
    public function cancel($id){
        $invoice=Invoice::where('id',$id)->first();
        $invoice->cancel=1;
        $invoice->update();
        return response()->json(['msg'=>'Canceled this invoice','invoice_id'=>$id,'con'=>true]);
    }
    public function taxes(){
        $taxes=products_tax::all();
        return response()->json(['result'=>$taxes,'con'=>true]);
    }
    public function transactionCategory(){
        $catories=TransactionCategory::all();
        return response()->json(['con'=>true,'result'=>$catories]);
    }
    public function makePayment(Request $request)
    {
//        dd($request->all());
        $this->validate($request, [
            'transaction_date' => 'required',
            'amount' => 'required',
            'customer_id' => 'required',
            'category' => 'required',
            'payment_method' => 'required',
            'approver_id'=>'required',
            'attachment' => 'mimes:pdf,xlsx,doc,docx,jpg,jpeg,ppt,bip',
//                'coa_account'=>'required'
        ]);

        try {
            $branch_acc=Account::where('branch_id',Auth::guard('api')->user()->office_branch_id)->first();
            $emps=Employee::where('head_office',Auth::guard('api')->user()->head_office)->get();
            $financeManger=[];
            foreach ($emps as $emp){
                if($emp->role->name=='Finance Manager'){
                    array_push($financeManger,$emp);
                }
            }
//            dd($branch_acc);
            $new_revenue = new Revenue();
            $new_revenue->title = $request->title;
            $new_revenue->customer_id = $request->customer_id;
            $new_revenue->amount = $request->amount;
            $new_revenue->invoice_id = $request->invoice_id ?? null;
            $new_revenue->reference = $request->reference;
            $new_revenue->recurring = $request->recurring;
            $new_revenue->payment_method = $request->payment_method;
            $new_revenue->description = $request->description;
            $new_revenue->category = $request->category;
            $new_revenue->cashier = $request->approver_id;
            $new_revenue->advance_pay_id = $request->advance_id ?? null;
            $employee = Employee::where('head_office', Auth::guard('api')->user()->head_office)->get();
            foreach ($employee as $emp) {
                if ($emp->role->name =='Finance Manager') {
                    $new_revenue->head_account = Account::where('enabled', 1)->where('head_office',Auth::guard('api')->user()->head_office)->where('head_account',1)->first()->id;
                    $new_revenue->finance_manager =$financeManger[0]->id;
                };
            }
            $new_revenue->cashier_account = $branch_acc->id;
            $new_revenue->transaction_date = $request->transaction_date;
            $new_revenue->emp_id = Auth::guard('api')->user()->id;
            $new_revenue->branch_id = Auth::guard('api')->user()->office_branch_id;
            $new_revenue->currency = $request->currency;
            if ($request->payment_method != "Cash") {
                $new_revenue->is_cashintransit = 1;
            }
            if (isset($request->attachment)) {
                if ($request->attachment != null) {
                    $attach = $request->file('attachment');
                    $input['filename'] = \Illuminate\Support\Str::random(10) . time() . '.' . $attach->extension();
                    $request->attachment->move(public_path() . '/attach_file', $input['filename']);

                }
                $new_revenue->attachment = $input['filename'];
            }
            if ($request->payment_method == 'Advance Payment') {
                $new_revenue->approve = 1;
            }
            $new_revenue->save();
            if($request->advance=='on'){
                $customer=Customer::where('id',$request->customer_id)->first();
                $customer->advance_balance-=$request->amount;
                $customer->update();
            }
            if (isset($request->invoice_id)) {
                $inv = Invoice::where('id', $request->invoice_id)->first();
                $employee = Employee::where('id', $inv->emp_id)->first();
                $employee->amount_in_hand += $request->amount;
                $employee->update();
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        if (isset($request->invoice_id)) {
            $delivery = DeliveryOrder::where('invoice_id', $request->invoice_id)->first();
            if ($delivery != null) {
                $deli_pay = DeliveryPay::where('delivery_id', $delivery->id)->first();
                $deli_pay->receiver_invoice_amount = 1;
                $deli_pay->update();
            }
        }
        $this->transaction_add($branch_acc->id, $request->type, null, $new_revenue->id);
        $this->addnotify($request->approver_id, 'noti', 'Add new revenue', 'revenue', Auth::guard('api')->user()->id);
        if ($new_revenue->is_cashintransit) {
            $this->addnotify($new_revenue->finance_manager, 'noti', 'Add new revenue', 'revenue', Auth::guard('api')->user()->id);

        }
        if (isset($request->invoice_id)) {
            $inv = Invoice::where('id', $request->invoice_id)->first();
            $inv->due_amount = $inv->due_amount - $request->amount;
            $inv->update();
            return response()->json(['con'=>true,'msg'=>'Successful']);
        }

    }
    public function transaction_add($account_id, $type, $expense_id, $revenue_id)
    {
        $transaction = new Transaction();
        $transaction->type = $type;
        $transaction->account_id = $account_id;
        $transaction->expense_id = $expense_id;
        $transaction->revenue_id = $revenue_id;
        $transaction->save();
    }

}