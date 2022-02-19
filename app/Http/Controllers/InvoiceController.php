<?php

namespace App\Http\Controllers;
use App\Jobs\leadactivityschedulemail;
use App\Models\Account;
use App\Models\AdvancePayment;
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
use App\Models\Revenue;
use App\Models\SellingUnit;
use App\Models\Stock;
use App\Models\Transaction;
use App\Models\TransactionCategory;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public  $status=['Paid','Unpaid','Pending','Cancel','Draft','Sent'];
    public function index()
    {
        $allinv=Invoice::with('customer')->get();
        $status=$this->status;
        return view('invoice.index',compact('allinv','status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Auth=Auth::guard('employee')->user();
        if($Auth->office_branch_id!=null){
            $allcustomers = Customer::all();
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
            $unit_price = product_price::where('sale_type', 'Whole Sale')->where('active',1)->get();
            $dis_promo = DiscountPromotion::where('sale_type', 'Whole Sale')->get();
            $focs = Freeofchare::with('variant')->get();
            $type = 'Whole Sale';

            $warehouse = OfficeBranch::with('warehouse')->where('id', $Auth->office_branch_id)->get();
            $aval_product = Stock::with('variant')->where('available', '>', 0)->get();
            return view('invoice.create', compact('warehouse', 'type', 'request_id', 'allcustomers', 'orderline', 'grand_total', 'status', 'data', 'aval_product', 'taxes', 'unit_price', 'dis_promo', 'focs'));
        }else{
            return redirect()->back()->with('error','Firstly,Fixed your Branch of Office');
    }
    }
    public function retail_inv()
    {
        $Auth=Auth::guard('employee')->user();
        if($Auth->office_branch_id!=null){
        $allcustomers =Customer::all();
        $aval_product=Stock::with('variant')->where('available','>',0)->get();
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
        $unit_price=product_price::where('sale_type','Rental Sale')->get();
        $dis_promo=DiscountPromotion::where('sale_type','Rental Sale')->get();
        $focs=Freeofchare::with('variant')->get();
        $type='Retail Sale';
        $Auth=Auth::guard('employee')->user();

        $warehouse=OfficeBranch::with('warehouse')->where('id',$Auth->office_branch_id)->get();
        return view('invoice.create',compact('warehouse','request_id','allcustomers','orderline','grand_total','status','data','aval_product','taxes','unit_price','dis_promo','focs','type'));
        }else{
            return redirect()->back()->with('error','Firstly,Fixed your Branch of Office');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
//        dd($request->all());
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
            $newInvoice->emp_id = Auth::guard('employee')->user()->id;
            $Auth = Auth::guard('employee')->user()->name;
            $request_id = Session::get($Auth);
            $confirm_order_item = OrderItem::where("creation_id", $request_id)->get();
            if (count($confirm_order_item) != 0) {
                $newInvoice->save();
                foreach ($confirm_order_item as $item) {
                    if ($item->foc) {
                        $unit = SellingUnit::where('id', $item->sell_unit)->first();
                        $stock = Freeofchare::where('variant_id', $item->variant_id)->first();
                        $item->inv_id = $newInvoice->id;
                        $item->update();
                        $stock->qty = $stock->qty - ($item->quantity * $unit->unit_convert_rate);
                        $stock->update();
                    } else {
                        $unit = SellingUnit::where('id',1)->first();
                        $stock = Stock::where('variant_id', $item->variant_id)->where('warehouse_id', $request->warehouse_id)->first();
                        $item->inv_id = $newInvoice->id;
                        $item->update();
                        $stock->available = $stock->available - ($item->quantity * $unit->unit_convert_rate);
                        $stock->update();
                    }
                }
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
        $company=MainCompany::where('ismaincompany',true)->first();
        $detail_inv=Invoice::with('customer','employee','tax','order')->where('id',$id)->firstOrFail();
        $invoic_item=OrderItem::with('variant','unit')->where("inv_id",$detail_inv->id)->get();
        $account=Account::where('enabled',1)->get();
        $recurring=['No','Daily','Weekly','Monthly','Yearly'];
        $payment_method=['Cash','eBanking','WaveMoney','KBZ Pay'];
        $category=TransactionCategory::all();
        $revenue=Revenue::where('invoice_id',$id)->get();
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
        }elseif($detail_inv->due_amount!=0 && Carbon::now()>$detail_inv->due_date){
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
            $customer=Customer::all();
        $emps = Employee::all();
        $advan_pay=AdvancePayment::with('order')->where('order_id',$detail_inv->order_id)->first();
        $data=['transaction'=>$transaction,'customers'=>$customer,'account'=>$account,'recurring'=>$recurring,'payment_method'=>$payment_method,'category'=>$category];

        return view('invoice.show',compact('detail_inv','advan_pay','invoic_item','company','data','transaction_amount','history','emps'));
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
        $unit_price=product_price::where('sale_type',$invoice->inv_type)->get();
        $dis_promo=DiscountPromotion::where('sale_type',$invoice->inv_type)->get();
        $focs=Freeofchare::with('variant')->get();
        $warehouse=Warehouse::all();
       return view('invoice.edit',compact('warehouse','allcustomers','orderline','grand_total','status','aval_product','taxes','unit_price','dis_promo','focs','invoice'));
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
            $update_Invoice->emp_id=Auth::guard('employee')->user()->id;
            $update_Invoice->update();
        }
        return response()->json([
            'url'=>url('invoices/'.$update_Invoice->id)
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
}
