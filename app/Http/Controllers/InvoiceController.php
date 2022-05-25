<?php

namespace App\Http\Controllers;
use App\Exports\InvoiceExport;
use App\Jobs\leadactivityschedulemail;
use App\Models\Account;
use App\Models\AdvancePayment;
use App\Models\AmountDiscount;
use App\Models\ChartOfAccount;
use App\Models\Company;
use App\Models\Customer;
use App\Models\DiscountPromotion;
use App\Models\Employee;
use App\Models\Freeofchare;
use App\Models\Invoice;
use App\Models\InvoiceHistory;
use App\Models\OfficeBranch;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MainCompany;
use App\Models\product;
use App\Models\product_price;
use App\Models\products_tax;
use App\Models\ProductVariations;
use App\Models\Region;
use App\Models\Revenue;
use App\Models\SaleZone;
use App\Models\SellingUnit;
use App\Models\Stock;
use App\Models\Transaction;
use App\Models\TransactionCategory;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use function PHPUnit\Framework\isEmpty;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public  $status=['Paid','Partial','Unpaid','Pending','Cancel','Draft'];
    public function index()
    {
        $zone=SaleZone::all();// sale zone နဲ့ filter လုပ်ဖို့ထုတ်ထားတာ
        $region=Region::all()->pluck('name','id')->all();//Region နဲ့ filter လုပ်ဖို့ထုတ်ထားတာ
        $branch=OfficeBranch::all()->pluck('name','id')->all(); //Branch နဲ့ filter လုပ်ဖို့ထုတ်ထားတာ
        if(Auth::guard('employee')->user()->role->name=='Super Admin'|| Auth::guard('employee')->user()->role->name=='CEO'||Auth::guard('employee')->user()->role->name=='Sale Manager'||Auth::guard('employee')->user()->role->name=='Cashier' ){
            $allinv=Invoice::with('customer','employee','branch','zone','region')->get();//Super Admin နဲ့ CEO က invoice အားလုံးကြည့်လို့ရတအောင်အကုန်ထုတ်ပေးတယ်
        }elseif (Auth::guard('employee')->user()->role->name=='Sale Manager'||Auth::guard('employee')->user()->role->name=='Accountant'||Auth::guard('employee')->user()->role->name=='Cashier'){
            $allinv=Invoice::with('customer','employee','branch','zone','region')->where('branch_id',Auth::guard('employee')->user()->office_branch_id)->get();
        }else{
            $allinv=Invoice::with('customer','employee','branch','zone','region')->where('emp_id',Auth::guard('employee')->user()->id)->get();//ရိုးရိုးsale man တေက သူဖွင့်ထားတဲ့ invoice ကိုဘဲကြည့်လို့ရမယ်
        }
        $status=$this->status;
//        dd($allinv);
        return view('invoice.index',compact('allinv','status','zone','branch','region'));
    }
    public function invoice_view($type){
        //type parameter က invoice ကိုအမျိုးကြည့်ဖို့အတွက် ထည့်ထားတာ
        $status=$this->status;
        $branch=OfficeBranch::all()->pluck('name','id')->all();
        $zone=SaleZone::all();
        $region=Region::all()->pluck('name','id')->all();
        if(Auth::guard('employee')->user()->role->name=='Super Admin'|| Auth::guard('employee')->user()->role->name=='CEO'||Auth::guard('employee')->user()->role->name=='Sale Manager'||Auth::guard('employee')->user()->role->name=='Cashier' ){
        if($type=='due'){
            $allinv=Invoice::with('customer','employee','branch','region','zone')->where('due_amount','!=',0)->get();
            return view('invoice.due_list',compact('allinv','status','branch','zone','region'));
        }elseif ($type=='whole'){
            $allinv=Invoice::with('customer','employee','branch','region','zone')->where('inv_type','Whole Sale')->get();
            return view('invoice.wholesale',compact('allinv','status','branch','zone','region'));

        }else{
            $allinv=Invoice::with('customer','employee','branch','region','zone')->where('inv_type','Retail Sale')->get();
            return view('invoice.retail',compact('allinv','status','zone','branch','zone','region'));

        }
        }elseif (Auth::guard('employee')->user()->role->name=='Sale Manager'||Auth::guard('employee')->user()->role->name=='Accountant'||Auth::guard('employee')->user()->role->name=='Cashier'){
            if($type=='due'){
                $allinv=Invoice::with('customer','employee','branch','region','zone')->where('due_amount','!=',0)->where('branch_id',Auth::guard('employee')->user()->office_branch_id)->get();
                return view('invoice.due_list',compact('allinv','status','branch','zone','region'));
            }elseif ($type=='whole'){
                $allinv=Invoice::with('customer','employee','branch','region','zone')->where('inv_type','Whole Sale')->where('branch_id',Auth::guard('employee')->user()->office_branch_id)->get();
                return view('invoice.wholesale',compact('allinv','status','branch','zone','region'));

            }else{
                $allinv=Invoice::with('customer','employee','branch','region','zone')->where('inv_type','Retail Sale')->where('branch_id',Auth::guard('employee')->user()->office_branch_id)->get();
                return view('invoice.retail',compact('allinv','status','zone','branch','zone','region'));

            }
        }
        else{
            if($type=='due'){
                $allinv=Invoice::with('customer','employee','branch','zone','region')->where('due_amount','!=',0)->where('emp_id',Auth::guard('employee')->user()->id)->get();
                return view('invoice.due_list',compact('allinv','status','branch','zone','region'));
            }elseif ($type=='whole'){
                $allinv=Invoice::with('customer','employee','branch','zone','region')->where('inv_type','Whole Sale')->where('emp_id',Auth::guard('employee')->user()->id)->get();
                return view('invoice.wholesale',compact('allinv','status','branch','zone','region'));

            }else{
                $allinv=Invoice::with('customer','employee','branch','zone','region')->where('inv_type','Retail Sale')->where('emp_id',Auth::guard('employee')->user()->id)->get();
                return view('invoice.retail',compact('allinv','status','zone','branch','region'));

            }
        }

    }
    /*
     * invoice method က invoice ကို whole sale,Retail sale,Due သပ်သပ်စီခွဲကြည့်ဖို့အတွက်လုပ်ထားတဲံ method
     */

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*
         * whole sale ရောင်းရင်saleman employee မှာ branch နဲ့ region သတ်မှတ်ပီးသားဖြစ်ဖို့လိုတယ်
         * ရောင်းမယ့် customer ဟာ saleman employee ရဲ့ branch customer ဖြစ်ရမယ် sale man ရဲ့region
         * customer လဲဖြစ်ထားရမယ်
         * warehouse က saleman အတွက်သတ်မှတ်ထားတဲ့ထားတဲ့ warehouse ဖြစ်ရမယ် stock လဲရှီရမယ်
         * discount and promotion လဲ branch အလိုက်ဘဲသွားမယ်
         * Ygn branch အတွက် discount က Mdy branch နဲ့မဆိုင်ဘူး
         */

        $Auth=Auth::guard('employee')->user();
        if($Auth->office_branch_id!=null && $Auth->region_id!=null){
            $allcustomers = Customer::where('branch_id',$Auth->office_branch_id)->where('region_id',$Auth->region_id)->get();
            $taxes = products_tax::all();
            $data = Session::get('data-' . Auth::guard('employee')->user()->id);
//        dd($data);
            $session_value = \Illuminate\Support\Str::random(10);
            if (!Session::has($Auth->name)) {
                Session::push("$Auth->name", $session_value);
                $request_id = Session::get($Auth->name);
            } else {
                $request_id = Session::get($Auth->name);
            }
            $orderline = OrderItem::with('variant')->where('creation_id', $request_id)->get();
//        dd($orderline);
            $grand_total = 0;
            for ($i = 0; $i < count($orderline); $i++) {
                $grand_total = $grand_total + $orderline[$i]->total;
            }
            $status = $this->status;
            $unit_price=SellingUnit::where('active',1)->get();
            $prices =product_price::where('sale_type', 'Whole Sale')->where('active',1)->where('region_id',$Auth->region_id)->get();
            //dd($prices);
            $dis_promo = DiscountPromotion::where('sale_type', 'Whole Sale')
                ->where('start_date','<=',Carbon::today())->where('end_date','>=',Carbon::today())
                ->where('region_id',$Auth->region_id)
                ->get();
            $focs = Freeofchare::with('variant')->where('branch_id',$Auth->office_branch_id)->get();
            $type = 'Whole Sale';

          if(Auth::guard('employee')->user()->mobile_seller==1){
              $warehouse =Warehouse::where('branch_id', $Auth->office_branch_id)
                  ->where('mobile_warehouse',1)
                  ->get();
          }else{
              $warehouse =Warehouse::where('branch_id', $Auth->office_branch_id)
                  ->where('mobile_warehouse',0)
                  ->get();
          }
            $aval_product =[];
            $in_stock=Stock::with('variant','unit')->where('available', '>', 0)->get();
            foreach ($in_stock as $inhand){
                if($inhand->variant->enable==1){
                    array_push($aval_product,$inhand);
                }
            }

            $amount_discount=AmountDiscount::whereDate('start_date','<=',date('Y-m-d'))
                ->whereDate('end_date','>=',date('Y-m-d'))
                ->where('sale_type','Whole Sale')
//                ->where('region_id',$Auth->regioin_id)
                ->get();
            $due_default=Carbon::today()->addDay(1);
            $companies=Company::all()->pluck('name','id')->all();
            $zone=SaleZone::where('region_id',$Auth->region_id)->get();
            $region=Region::where('branch_id',$Auth->office_branch_id)->get();
            return view('invoice.create', compact('zone','warehouse', 'type', 'request_id', 'allcustomers', 'orderline', 'grand_total', 'status', 'data', 'aval_product', 'taxes', 'unit_price', 'dis_promo', 'focs','prices','amount_discount','due_default','companies','region'));
        }else{
            return redirect()->back()->with('error','Firstly,Fixed your Branch Office and Sale Region');
    }
    }
    /*
     * whole sale invoice create form သွားမယ့် method
     */
    public function retail_inv()
    {
        $Auth=Auth::guard('employee')->user();
        if($Auth->office_branch_id!=null && $Auth->region_id!=null){
            $allcustomers = Customer::where('branch_id',$Auth->office_branch_id)->where('region_id',$Auth->region_id)->get();
            $aval_product =[];
            $in_stock=Stock::with('variant','unit')->where('available', '>', 0)->get();
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

//        Session::forget('data-'.Auth::guard('employee')->user()->id);
        $data=Session::get('data-'.Auth::guard('employee')->user()->id);
//        dd($data);
//        Session::forget($Auth);
        $session_value=\Illuminate\Support\Str::random(10);
        if(!Session::has($Auth->name)){
            Session::push("$Auth->name",$session_value);
            $request_id=Session::get($Auth->name);
        }else{
            $request_id=Session::get($Auth->name);
        }
//        $generate_id=Str::uuid();
        $orderline=OrderItem::with('variant')->where('creation_id',$request_id)->get();
//        dd($orderline);
        $grand_total=0;
        for ($i=0;$i<count($orderline);$i++){
            $grand_total=$grand_total+$orderline[$i]->total;
        }
        $status=$this->status;
        $unit_price=SellingUnit::where('active',1)->get();
        $prices=product_price::where('sale_type','Retail Sale')->where('active',1)->where('region_id',$Auth->region_id)->get();
        $dis_promo=DiscountPromotion::where('sale_type','Retail Sale')
            ->where('region_id',$Auth->region_id)
            ->get();
        $focs=Freeofchare::with('variant')->where('region_id',$Auth->region_id)->get();
        $type='Retail Sale';
        $Auth=Auth::guard('employee')->user();
            if(Auth::guard('employee')->user()->mobile_seller==1){
                $warehouse =Warehouse::where('branch_id', $Auth->office_branch_id)->where('mobile_warehouse',1)->get();
            }else{
                $warehouse =Warehouse::where('branch_id', $Auth->office_branch_id)->where('mobile_warehouse',0)->get();
            }
            $amount_discount=AmountDiscount::whereDate('start_date','<=',date('Y-m-d'))
            ->whereDate('end_date','>=',date('Y-m-d'))
            ->where('sale_type','Retail Sale')
//            ->where('region_id',$Auth->region_id)
            ->get();
            $due_default=Carbon::today()->addDay(1);
            $companies=Company::all()->pluck('name','id')->all();
            $zone=SaleZone::where('region_id',$Auth->region_id)->get();
            $region=Region::where('branch_id',$Auth->office_branch_id)->get();
        return view('invoice.create',compact('zone','warehouse','request_id','allcustomers','orderline','grand_total','status','data','aval_product','taxes','unit_price','dis_promo','focs','type','prices','amount_discount','due_default','companies','region'));
        }else{
            return redirect()->back()->with('error','Firstly,Fixed your Branch Office and region');
        }
    }
    /*
     * retail sale invoice create form သွားမယ့် method
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $validator=Validator::make($request->all(),[
           'title'=>'required',
            'client_id'=>'required',
            'client_email'=>'required',
            'inv_date'=>'required',
            'due_date'=>'required',
            'client_address'=>'required',
            'bill_address'=>'required',
            'payment_method'=>'required',

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
//dd($invoice_id);
            $tax=products_tax::where('id',$request->tax_id)->first();
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
            $newInvoice->tax_rate=$tax->rate;
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
            $newInvoice->emp_id = Auth::guard('employee')->user()->id;
            $newInvoice->branch_id=Auth::guard('employee')->user()->office_branch_id;
            $Auth = Auth::guard('employee')->user()->name;
            $request_id = Session::get($Auth);
            $confirm_order_item = OrderItem::where("creation_id", $request_id)->get(); //invoice item တေကို ပြန် confirm ပီး invoice id နဲ့တွဲတာ
            if (count($confirm_order_item) != 0) {
                $newInvoice->save();
                $customer=Customer::where('id',$request->client_id)->first();
                $customer->main_customer=1;
                $customer->current_credit+=$request->inv_grand_total;
                $customer->update();
                foreach ($confirm_order_item as $item) {
                    if ($item->foc) {
                        $unit = SellingUnit::where('id', $item->sell_unit)->first();
                        $stock = Freeofchare::where('variant_id', $item->variant_id)->first();
                        $item->inv_id = $newInvoice->id;
                        $item->update();
                        $stock->qty = $stock->qty - ($item->quantity * $unit->unit_convert_rate);
                        $item->cos_total=($item->quantity * $unit->unit_convert_rate)*$stock->cos;
                        $stock->update();
                    } else {
                        $unit = SellingUnit::where('id',$item->sell_unit)->first();
                        $stock = Stock::where('variant_id', $item->variant_id)->where('warehouse_id', $request->warehouse_id)->first();
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
                if (isset($request->order_id)) {
                    $order_item = OrderItem::where('order_id', $request->order_id)->get();
                    $grand_total = 0;
                    for ($i = 0; $i < count($order_item); $i++) {
                        $grand_total = $grand_total + $order_item[$i]->total;
                    }
                    $order = Order::where('id', $request->order_id)->first();
                    $order->grand_total = $grand_total;
                    $order->update();
                }
                Session::forget($Auth);
                Session::forget('data-' . Auth::guard('employee')->user()->id);
                $this->add_history($newInvoice->id, 'Daft', 'Add' . $invoice_id);
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
    public function sending_form($id){
        $company=MainCompany::where('ismaincompany',true)->first();
//        dd($company);
        $detail_inv=Invoice::with('customer')->where('id',$id)->first();
//        dd($detail_inv);
        $invoice_item=OrderItem::with('variant')->where("inv_id",$id)->get();
//        dd($invoice_item);
        $grand_total=0;
          for ($i=0;$i<count($invoice_item);$i++){
              $grand_total=$grand_total+$invoice_item[$i]->total;
      }
        return view('invoice.sendemail',compact('detail_inv','invoice_item','grand_total','company'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $emps = Employee::where('office_branch_id', Auth::guard('employee')->user()->office_branch_id)->get();
        $category = TransactionCategory::where('type', 1)->get();
        $customer = Customer::orWhere('customer_type', 'Customer')->orWhere('customer_type', 'Lead')->orWhere('customer_type', 'Partner')->orWhere('customer_type', 'Inquery')->get();
        $company=MainCompany::where('ismaincompany',true)->first();
        $detail_inv=Invoice::with('customer','employee','tax','order')->where('id',$id)->firstOrFail();
        $invoic_item=OrderItem::with('variant','unit')->where("inv_id",$detail_inv->id)->get();
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
        $data=[
//            'coas'=>$coas,
            'emps' => $emps, 'customers' => $customer, 'recurring' => $recurring, 'payment_method' => $payment_method, 'category' => $category,
            'transaction'=>$transaction,'account'=>$account];
        return view('invoice.show',compact('detail_inv','invoic_item','company','data','transaction_amount','history'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice=Invoice::with('customer','tax','employee','order','warehouse')->where('id',$id)->firstOrFail();
        $allcustomers =Customer::all();
        $aval_product=Stock::with('variant')->where('available','>',0)->get();
        $taxes=products_tax::all();
        $orderline=OrderItem::with('variant','unit')->where('inv_id',$id)->get();
        $grand_total=0;
        for ($i=0;$i<count($orderline);$i++){
            $grand_total=$grand_total+$orderline[$i]->total;
        }
        $status=$this->status;
        $unit_price=SellingUnit::where('active',1)->get();
        if($invoice->inv_type=='Retail Sale') {
            $prices = product_price::where('sale_type', 'Retail Sale')->where('active', 1)->where('region_id', Auth::guard('employee')->user()->region_id)->get();
            $amount_discount=AmountDiscount::whereDate('start_date','<=',date('Y-m-d'))->whereDate('end_date','>=',date('Y-m-d'))->where('sale_type','Retail Sale')->get();
        }else{
            $prices = product_price::where('sale_type', 'Whole Sale')->where('active', 1)->where('region_id', Auth::guard('employee')->user()->region_id)->get();
            $amount_discount=AmountDiscount::whereDate('start_date','<=',date('Y-m-d'))->whereDate('end_date','>=',date('Y-m-d'))->where('sale_type','Whole Sale')->get();
        }
        $dis_promo=DiscountPromotion::where('sale_type',$invoice->inv_type)->get();
        $focs=Freeofchare::with('variant')->get();
        $warehouse=Warehouse::all();
       return view('invoice.edit',compact('warehouse','allcustomers','orderline','grand_total','status','aval_product','taxes','unit_price','dis_promo','focs','invoice','prices','amount_discount'));
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
        if(isset($request->mark_sent)){
            $update_Invoice=Invoice::where('id',$id)->first();
            $update_Invoice->mark_sent=$request->mark_sent;
            $update_Invoice->update();
            return redirect(route('invoices.show',$id))->with('success','Invoice Marked');
        }else{
            $update_Invoice=Invoice::where('id',$id)->first();
            if($update_Invoice->status=='Draft'){

                $customer=Customer::where('id',$update_Invoice->customer_id)->first();
                $customer->current_credit-=$update_Invoice->amount;
                $customer->update();
                $update_Invoice->title=$request->title;
                $update_Invoice->customer_id=$request->client_id;
                $update_Invoice->email=$request->client_email;
                $update_Invoice->customer_address=$request->client_address;
                $update_Invoice->billing_address=$request->bill_address;
                $update_Invoice->invoice_date=Carbon::create($request->inv_date);
                $update_Invoice->due_date=Carbon::create($request->due_date);
                $update_Invoice->other_information=$request->more_info;
                $update_Invoice->grand_total=$request->inv_grand_total;
                $update_Invoice->status="Daft";
                $update_Invoice->order_id=$request->order_id;
                $update_Invoice->send_email=isset($request->save_type)?1:0;
                $update_Invoice->payment_method=$request->payment_method;
                $update_Invoice->tax_id=$request->tax_id;
                $update_Invoice->total=$request->total;
                $update_Invoice->discount=$request->discount;
                $update_Invoice->tax_amount=$request->tax_amount;
                $update_Invoice->invoice_type=$request->invoice_type;
                $update_Invoice->delivery_fee=$request->delivery_fee;
                $update_Invoice->due_amount=$request->inv_grand_total;
                $update_Invoice->warehouse_id=$request->warehouse_id;
                $update_Invoice->inv_type=$request->inv_type;
                $update_Invoice->update();
                $update_cus=Customer::where('id',$request->client_id)->first();
                $update_cus->current_credit+=$request->inv_grand_total;
                $update_cus->update();
                return response()->json([
                    'url'=>url('invoices/'.$update_Invoice->id)
                ]);
            }else{
                return response()->json([
                    'message'=>'Invoice can only editable in draft status',
                    'url'=>url('invoices/'.$update_Invoice->id)
                ]);
            }
        }
//        return response()->json([
//            'url'=>url('invoices/'.$update_Invoice->id)
//        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice=Invoice::where("id",$id)->first();
        $invoice->delete();
        return redirect(route('invoices.index'))->with('success','Delete Success');
    }
    public function email(Request $request)
    {
//        dd(env('MAIL_PORT'));
//        dd($request->all());
        $invoice=Invoice::with('customer','employee')->where("id",$request->inv_id)->first();
        $invoice_item=OrderItem::with('variant')->where("inv_id",$request->inv_id)->get();
        $company=MainCompany::where('ismaincompany',true)->first();
        if($request->attach!=null){
            $file = $request->attach;
            $file_name = $file->getClientOriginalName();
            $request->attach->move(public_path() . '/attach_file/', $file_name);
        }
        $cc=$request->cc_mail!=null?explode(',',$request->cc_mail):null;
        $details = array(
            'email' => $request->email,
            'subject' => 'Invoice Mail',
            'clientname' => $invoice->customer->name,
            'invoice'=>$invoice,
            'cc' => $cc,
            'orderItem'=>$invoice_item,
            'company'=>$company,
            'attach' =>$request->attach!=null?public_path() . '/attach_file/' . $file_name:null,
        );
        Mail::send('invoice.invoicemail', $details, function ($message) use ($details) {
            $message->from('siyincin@gmail.com', 'Cloudark');
            $message->to($details['email']);
            $message->subject($details['subject']);
            if ($details['cc'] != null) {
                $message->cc($details['cc']);
            }
            if ($details['attach'] != '') {
                $message->attach($details['attach']);
            }

        });
        $invoice->send_email=1;
        $invoice->update();
        $this->add_history($invoice->id,'Send Mail','Sending email to customer');
        return redirect(route('invoices.show',$invoice->id))->with('success','Invoice Email Sending Successful');
    }
    public function status_change(Request $request,$id){
        $invoice=Invoice::where("id",$id)->first();
        $invoice->status=$request->status;
        $invoice->update();
        return redirect()->back();
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
    public function export(Request $request,$type){
            return Excel::download(new InvoiceExport($request->start_date, $request->end_date,$type),ucfirst($type).' invoice.xlsx');
    }
    public function cancel($id){
        $invoice=Invoice::where('id',$id)->first();
        $invoice->cancel=1;
        $invoice->update();
        return redirect('invoices')->with('success',"This invoice is cancelled");
    }
}
