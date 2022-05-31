<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AdvancePayment;
use App\Models\AmountDiscount;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Department;
use App\Models\DiscountPromotion;
use App\Models\Employee;
use App\Models\Freeofchare;
use App\Models\Group;
use App\Models\MainCompany;
use App\Models\OfficeBranch;
use App\Models\Order;
use App\Models\order_assign;
use App\Models\order_comments;
use App\Models\OrderCc;
use App\Models\OrderItem;
use App\Models\product;
use App\Models\product_price;
use App\Models\products_tax;
use App\Models\ProductVariations;
use App\Models\Quotation;
use App\Models\Region;
use App\Models\SaleZone;
use App\Models\SellingUnit;
use App\Models\Stock;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Auth\GenericUser;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use function PHPUnit\Framework\isEmpty;

class SaleOrderController extends Controller
{
    public  $status=['Paid','Unpaid','Pending','Cancel'];
    public function index(){
        if(Auth::guard('customer')->check()){
            $orders=Order::with("customer")->where('customer_id',Auth::guard('customer')->user()->id)->paginate(10);
        }else{
            $orders=Order::with("customer")->paginate(10);
        }
//        dd($orders);
        $data=['orders'=>$orders];
        return view('saleorder.index',compact('data'));
    }
    public function create(){
        $Auth=Auth::guard('employee')->user();
        $unit_price=SellingUnit::all();
        $prices =product_price::where('sale_type', 'Whole Sale')->where('active',1)->where('region_id',$Auth->region_id)->get();
        $variants=ProductVariations::with('product')->get();
        $taxes=products_tax::all();
        $allcustomers=Customer::all();
        $session_value=\Illuminate\Support\Str::random(10);
        if(Auth::guard('employee')->check()){
//            dd('emp');
            $Auth="order-".Auth::guard('employee')->user()->name;
        }elseif(Auth::guard('customer')->check()){

            $Auth="order-".Auth::guard('customer')->user()->name;
        }
        if(!Session::has($Auth)){
            Session::push("$Auth",$session_value);
            $request_id=Session::get($Auth);
        }else{
            $request_id=Session::get($Auth);
        }
//        $generate_id=Str::uuid();
        $items=OrderItem::with('variant')->where('creation_id',$request_id)->get();
//        dd($orderline);
        $grand_total=0;
        for ($i=0;$i<count($items);$i++){
            $grand_total=$grand_total+$items[$i]->total;
        }
        $products=product::all();
        if(Auth::guard('customer')->check()){
            $quotations=Quotation::where('is_confirm',1)->where('customer_name',Auth::guard('customer')->user()->id)->get();
          $quotation=[];
            foreach ($quotations as $quo){
                $is_exist=Order::where('quotation_id',$quo->id)->first();
                if($is_exist==null){
                    array_push($quotation,$quo);
                }
            }
        }else{
            $quotations=Quotation::where('is_confirm',1)->get();
            $quotation=[];
            foreach ($quotations as $quo){
                $is_exist=Order::where('quotation_id',$quo->id)->first();
                if($is_exist==null){
                    array_push($quotation,$quo);
                }
            }
        }
       if(Auth::guard('customer')->check()){
           $session_data=Session::get("order-".Auth::guard('customer')->user()->id);
       }else{
           $session_data=Session::get("order-".Auth::guard('employee')->user()->id);
       }
        $dis_promo=DiscountPromotion::where('sale_type','Whole Sale')->get();
//          dd($session_data);
        $data=['customer'=>$allcustomers,'items'=>$items,'grand_total'=>$grand_total,'id'=>$request_id,'products'=>$products,'quotation'=>$quotation, 'variants'=>$variants,'taxes'=>$taxes];
        $emps=Employee::where('office_branch_id',Auth::guard('employee')->user()->office_branch_id)->pluck('name','id')->all();
        return view('saleorder.create',compact('data','session_data','unit_price','dis_promo','prices','emps'));
    }
    public function store(Request $request){
//dd($request->all());
//        dd($request->cc);
        $validator=Validator::make($request->all(),[
            'customer_id'=>'required',
            'grand_total'=>'required',
            'phone'=>'required',
            'email'=>'required',
            'address'=>'required',
            'payment_method'=>'required',
            'payment_term'=>'required',
            'order_date'=>'required',
            'billing_address'=>'required',
        ]);
        $last_order=Order::orderBy('id', 'desc')->first();

        if ($last_order!=null) {
            // Sum 1 + last id
            $last_order->order_id++;
                $order_id = $last_order->order_id;
        } else {
            $order_id='ORD'."-0001";
        }
        if($validator->passes()) {
            $order = new Order();
            $order->order_id = $order_id;
            $order->customer_id = $request->customer_id;
            $order->grand_total = $request->grand_total;
            $order->comment = $request->comment;
            $order->phone = $request->phone;
            $order->email = $request->email;
            $order->address = $request->address;
            $order->payment_method = $request->payment_method;
            $order->payment_term = $request->payment_term;
            $order->billing_address=$request->billing_address;
            $order->quotation_id=$request->quotation_id;
            $order->shipping_type=$request->shipping_type;
            $order->shipping_address=$request->shipping_address;
            $order->billing_address=$request->billing_address;
            $order->tax_id=$request->tax_id;
            $order->expected_arrival_date=$request->arrival_date;
            $order->approver_id=$request->approver_id;
            $order->tax_amount=$request->tax_amount??0;
            $order->total=$request->total??0;
            $order->discount=$request->discount??0;
            $order->status="New";
            $order->emp_id=Auth::guard('employee')->user()->id;
            $order->order_date = Carbon::create($request->order_date);

            $Auth="order-".Auth::guard('employee')->user()->name;
            $request_id=Session::get($Auth);
            $confirm_order_item=OrderItem::where("creation_id",$request_id)->get();
            if($confirm_order_item->isEmpty()){
                return response()->json(['orderempty'=>'Order Item Empty']);
            }else{
                $order->save();
            }
            foreach ($confirm_order_item as $item){
                $item->order_id=$order->id;
                $item->update();
            }
            Session::forget($Auth);
//            dd($request->cc );
            foreach ($request->cc as $key=>$val){
                $exists_cc=OrderCc::where('order_id',$order->id)->where('emp_id',$val)->first();
                if($exists_cc==null){
                    $employee=Employee::where('id',$val)->first();
                    $cc=new OrderCc();
                    $cc->order_id=$order->id;
                    $cc->emp_id=$val;
                    $cc->emp_name=$employee->name;
                    $cc->save();
                }
            }
            return response()->json(['Success' => 'Order Create Success']);
        }else{
            return response()->json(['error'=>$validator->errors()]);
        }
    }
    public function edit($id){
        $edit_order=Order::where('id',$id)->first();
        $prices =product_price::where('sale_type', 'Whole Sale')->where('active',1)->get();
        $variants=ProductVariations::with('product')->get();
        $taxes=products_tax::all();
        $allcustomers=Customer::all();

//        $generate_id=Str::uuid();
        $items=OrderItem::with('variant','unit')->where('order_id',$id)->get();
        $grand_total=0;
        for ($i=0;$i<count($items);$i++){
            $grand_total=$grand_total+$items[$i]->total;
        }
        $products=product::all();
        if(Auth::guard('customer')->check()){
            $quotations=Quotation::where('is_confirm',1)->where('customer_name',Auth::guard('customer')->user()->id)->get();
            $quotation=[];
            foreach ($quotations as $quo){
                $is_exist=Order::where('quotation_id',$quo->id)->first();
                if($is_exist==null){
                    array_push($quotation,$quo);
                }
            }
        }else{
            $quotations=Quotation::where('is_confirm',1)->get();
            $quotation=[];
            foreach ($quotations as $quo){
                $is_exist=Order::where('quotation_id',$quo->id)->first();
                if($is_exist==null){
                    array_push($quotation,$quo);
                }
            }
        }
        if(Auth::guard('customer')->check()){
            $session_data=Session::get("order-".Auth::guard('customer')->user()->id);
        }else{
            $session_data=Session::forget("order-".Auth::guard('employee')->user()->id);
        }
        $unit_price=product_price::where('sale_type','Whole Sale')->get();
        $dis_promo=DiscountPromotion::where('sale_type','Whole Sale')->get();

//          dd($session_data);
        $data=['customer'=>$allcustomers,'items'=>$items,'grand_total'=>$grand_total,'id'=>$items[0]->creation_id,'products'=>$products,'quotation'=>$quotation, 'variants'=>$variants,'taxes'=>$taxes];
        return view('saleorder.edit',compact('data','session_data','edit_order','unit_price','dis_promo','prices'));
    }
    public function update(Request $request,$id){
        $order =Order::where('id',$id)->first();
        $order->customer_id = $request->customer_id;
        $order->grand_total = $request->grand_total;
        $order->comment = $request->comment;
        $order->phone = $request->phone;
        $order->email = $request->email;
        $order->address = $request->address;
        $order->payment_method = $request->payment_method;
        $order->payment_term = $request->payment_term;
        $order->billing_address=$request->billing_address;
        $order->quotation_id=$request->quotation_id;
        $order->shipping_type=$request->shipping_type;
        $order->shipping_address=$request->shipping_address;
        $order->billing_address=$request->billing_address;
        $order->tax_id=$request->tax_id;
        $order->tax_amount=$request->tax_amount;
        $order->total=$request->total;
        $order->discount=$request->discount;
        $order->status="New";
        $order->order_date = Carbon::create($request->order_date);
        $order->update();

    }
    public function show($id){
        $Order=Order::with('customer','quotation','tax','follower')->where('id',$id)->firstOrFail();
        $items=OrderItem::with('invoice','variant','unit')->where('order_id',$id)->get();
//        dd($orderline);
//        dd($items);
        $grand_total=0;
        for ($i=0;$i<count($items);$i++){
            $grand_total=$grand_total+$items[$i]->total;
        }
        $comments=order_comments::with('employee')->where('order_id',$id)->get();
        $employees=Employee::all()->pluck('name','id')->all();
        $depts=Department::all()->pluck('name','id')->all();
        $groups=Group::all()->pluck('name','id')->all();
        $product=product::all();
        $assign_info=order_assign::with('employee','department','group')->where('order_id',$id)->first();
//        dd($assign_info);
        $account=Account::all();
        $advance_pay=AdvancePayment::where('order_id',$id)->first();

        $data=['advance_pay'=>$advance_pay,'account'=>$account,'grand_total'=>$grand_total,'product'=>$product,'Order'=>$Order,'items'=>$items,'comments'=>$comments,'emp'=>$employees,'dept'=>$depts,'group'=>$groups,'assign_info'=>$assign_info];
        return view('saleorder.show',compact('data'));
    }
    public function destroy($id){

    }

    public function generate_invoice($id)
    {
        $Auth=Auth::guard('employee')->user();
        if($Auth->office_branch_id!=null && $Auth->region_id!=null) {
            if(Auth::guard('employee')->user()->mobile_seller==1){
                $warehouse =Warehouse::where('branch_id', $Auth->office_branch_id)
                    ->where('mobile_warehouse',1)
                    ->get();
            }else{
                $warehouse =Warehouse::where('branch_id', $Auth->office_branch_id)
                    ->where('mobile_warehouse',0)
                    ->get();
            }
            $order_data = Order::where('id', $id)->first();
            if ($order_data->status == 'Confirm') {
                $ordered_items = OrderItem::where('order_id', $id)->get();
                if (isset($ordered_items[0])) {
                    if ($ordered_items[0]->inv_id == null) {

//            dd($order_data);
                        $allcustomers = Customer::all();


//        Session::forget($Auth);
                        $session_value = \Illuminate\Support\Str::random(10);
                        if (!Session::has($Auth->name)) {
                            Session::push("$Auth->name", $session_value);
                            $request_id = Session::get($Auth->name);
                        } else {
                            $request_id = Session::get($Auth->name);
                        }
                        foreach ($ordered_items as $item) {
                            $item->creation_id = $request_id[0];
                            $item->update();
                        }
//        $generate_id=Str::uuid();
                        $orderline = OrderItem::with('variant')->where('order_id', $id)->get();
//        dd($orderline);
                        $taxes = products_tax::all();
                        $grand_total = 0;
                        for ($i = 0; $i < count($orderline); $i++) {
                            $grand_total = $grand_total + $orderline[$i]->total;
                        }
                        $aval_product = Stock::with('variant')->where('available', '>', 0)->get();
                        $unit_price=SellingUnit::where('active',1)->get();
                        $prices =product_price::where('sale_type', 'Whole Sale')->where('active',1)->where('region_id',$Auth->region_id)->get();
                        $dis_promo = DiscountPromotion::where('sale_type', 'Rental Sale')->get();
                        $focs = Freeofchare::with('variant')->get();
                        $amount_discount=AmountDiscount::whereDate('start_date','<=',date('Y-m-d'))
                            ->whereDate('end_date','>=',date('Y-m-d'))
                            ->where('sale_type','Whole Sale')
                            ->where('region_id',$Auth->regioin_id)
                            ->get();
                        $type = 'Whole Sale';
                        $due_default = Carbon::today()->addDay(1);
                        $zone = SaleZone::where('region_id', $Auth->region_id)->get();
                        $region = Region::where('branch_id', $Auth->office_branch_id)->get();
                        $companies=Company::all()->pluck('name','id')->all();
                        return view('invoice.create', compact('amount_discount','companies','focs', 'unit_price','prices', 'dis_promo', 'warehouse', 'aval_product', 'request_id', 'allcustomers', 'orderline', 'grand_total', 'order_data', 'taxes', 'type', 'due_default', 'zone', 'region'));

                    } else {
                        return redirect()->back()->with('error', 'This order has been generated invoice');
                    }
                } else {
                    return redirect()->back()->with('error', 'This order does not have any item!');
                }
            } else {
                return redirect()->back()->with('error', 'This order has not been confirmed!');
            }
        }else{

        return redirect()->back()->with('error','Firstly,Fixed your Branch Office and Sale Region');
        }



    }
    public function comment(Request $request){
        if($request->comment_text!=null){
            $order_comment=new order_comments();
            $order_comment->order_id=$request->order_id;
            $order_comment->emp_id=Auth::guard('employee')->user()->id;
            $order_comment->comment_text=$request->comment_text;
            $order_comment->save();
        }

        return redirect()->back();
    }
    public function comment_delete($id){
        $delete_cmt=order_comments::where('id',$id)->first();
        $delete_cmt->delete();
        return redirect()->back();
    }
    public function status_change($status,$id){
        $items=OrderItem::with('variant','invoice')->where('order_id',$id)->get();
//        dd($orderline);
        $grand_total=0;
        for ($i=0;$i<count($items);$i++){
            $grand_total=$grand_total+$items[$i]->total;
        }
        $status_change=Order::with('customer')->where('id',$id)->first();
        $status_change->status=$status;
        $status_change->grand_total=$grand_total;
        $status_change->update();
        $company = MainCompany::where('ismaincompany', 1)->first();
        $details = [

            'subject' => $company->name??''."Order Notification.",
            'email' =>$status_change->email,
            'name' =>$status_change->customer->name,
            'order_id' =>$status_change->order_id,
            'id'=>$status_change->id,
            'status'=>$status,
            'order_date'=>$status_change->order_date,
            'from' => Auth::guard('employee')->user()->email,
            'from_name' => Auth::guard('employee')->user()->name,
            'company' => $company->name??'',

        ];
        Mail::send('saleorder.order_email_noti', $details, function ($message) use ($details) {
            $message->from($details['from'], $details['company']);
                $message->to($details['email']);
            $message->subject($details['subject']);
        });
        return redirect()->back()->with('success','This Order is '.$status);
    }
    public function assign(Request $request,$id){
        $is_assigned=order_assign::where('order_id',$id)->first();
        if($is_assigned==null){
            $assign_order=new order_assign();
            $assign_order->order_id=$id;
            $assign_order->assign_type=$request->assignType;
            if($request->assignType=='emp'){
                $assign_order->emp_id=$request->assign_id;
            }elseif ($request->assignType=='dept'){
                $assign_order->dept_id=$request->assign_id;
            }elseif ($request->assignType=='group'){
                $assign_order->group_id=$request->assign_id;
            }
            $assign_order->save();
            return redirect()->back()->with('success','This Order Assign Successful');

        }else{
            return redirect()->back()->with('error','This order already assigned');
        }

    }
}
