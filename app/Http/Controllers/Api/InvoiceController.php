<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AmountDiscount;
use App\Models\Company;
use App\Models\Customer;
use App\Models\DiscountPromotion;
use App\Models\Freeofchare;
use App\Models\Invoice;
use App\Models\OfficeBranch;
use App\Models\orderItem;
use App\Models\MainCompany;
use App\Models\product;
use App\Models\product_price;
use App\Models\products_tax;
use App\Models\Region;
use App\Models\SaleZone;
use App\Models\SellingUnit;
use App\Models\Stock;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


class InvoiceController extends Controller
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
        return response()->json(['allinv'=>$allinv,'status'=>$status,'zone'=>$zone,'branch'=>$branch,'region'=>$region]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
                    ->where('mobile_warehouse',1)
                    ->get();
            }else{
                $warehouse =Warehouse::where('branch_id', $Auth->office_branch_id)
                    ->where('mobile_warehouse',0)
                    ->get();
            }
            $aval_product =[];
            $in_stock=Stock::with('variant')->where('available', '>', 0)->get();
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
            $in_stock=Stock::with('variant')->where('available', '>', 0)->get();
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
                $warehouse =Warehouse::where('branch_id', $Auth->office_branch_id)->where('mobile_warehouse',1)->get();
            }else{
                $warehouse =Warehouse::where('branch_id', $Auth->office_branch_id)->where('mobile_warehouse',0)->get();
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $prefix=MainCompany::where('ismaincompany',true)->pluck('invoice_prefix','id')->first();
        $last_invoice=Invoice::orderBy('id', 'desc')->first();
        if (isset($last_invoice)) {
            // Sum 1 + last id
            $ischange=$last_invoice->invoice_id;
            $ischange=explode("-", $ischange);
            if($ischange[0]==$prefix){
                $last_invoice->invoice_id++;
                $invoice_id = $last_invoice->invoice_id;
            }else{
                $arr=[$prefix,$ischange[1]];
                $pre=implode('-',$arr);
                $pre ++;
                $invoice_id=$pre;
            }
        } else {
            $invoice_id=($prefix ? :'INV')."-0001";
        }
        dd($invoice_id);
        $newInvoice=new Invoice();
        $newInvoice->title=$request->title;
        $newInvoice->invoice_id=$invoice_id;
        $newInvoice->customer_id=$request->client_id;
        $newInvoice->email=$request->client_email;
        $newInvoice->customer_address=$request->client_address;
        $newInvoice->billing_address=$request->bill_address;
        $newInvoice->invoice_date=Carbon::createFromFormat('d/m/Y',$request->inv_date);
        $newInvoice->due_date=Carbon::createFromFormat('d/m/Y',$request->due_date);
        $newInvoice->other_information=$request->more_info;
        $newInvoice->grand_total=$request->inv_grand_total;
        $newInvoice->status=$request->status;
        $newInvoice->payment_method=$request->payment_method;
        $newInvoice->save();
        $Auth=Auth::guard('api')->user()->name;
        $request_id=Session::get($Auth);
        $confirm_order_item=orderItem::where("creation_id",$request_id)->get();
        foreach ($confirm_order_item as $item){
            $item->inv_id=$newInvoice->id;
            $item->update();
        }
        Session::forget($Auth);
        if(isset($request->save_type)){
            $this->sending_form($newInvoice->id);
        }else{
            return redirect('invoices');
        }

    }
    public function sending_form($id){
        $company=MainCompany::where('ismaincompany',true)->first();
//        dd($company);
        $detail_inv=Invoice::with('customer')->where('id',$id)->first();
//        dd($detail_inv);
        $invoice_item=orderItem::with('product')->where("inv_id",$id)->get();
//        dd($orderItem);
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
        $detail_inv=Invoice::with('customer')->where('id',$id)->first();
//        dd($detail_inv);
        $invoic_item=orderItem::with('product')->where("inv_id",$detail_inv->id)->get();
        $grand_total=0;
        for ($i=0;$i<count($invoic_item);$i++){
            $grand_total=$grand_total+$invoic_item[$i]->total;
        }
        $data=['detail_inv'=>$detail_inv,'invoic_item'=>$invoic_item,'company'=>$company,'grand_total'=>$grand_total];
        return response()->json(['msg'=>'Success','data'=>$data]);
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
        $invoice=Invoice::where("id",$id)->first();
        $invoice->delete();
        return redirect()->back();
    }
    public function email(Request $request)
    {
//        dd(env('MAIL_PORT'));
//        dd($request->all());
        $invoice=Invoice::with('customer')->where("id",$request->inv_id)->first();
        $invoic_item=orderItem::with('product')->where("inv_id",$request->inv_id)->get();
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
            'orderItem'=>$invoic_item,
            'company'=>$company,
            'attach' =>$request->attach!=null?public_path() . '/attach_file/' . $file_name:null,
        );
        Mail::send('invoice.invoicemail', $details, function ($message) use ($details) {
            $message->from('cincin.com@gmail.com', 'Cloudark');
            $message->to($details['email']);
            $message->subject($details['subject']);
            if ($details['cc'] != null) {
                $message->cc($details['cc']);
            }
            if($details['attach']!=null){
                $message->attach($details['attach']);
            }

        });
        return redirect()->back()->with('success','Invoice Email Sending Successful');
    }
    public function status_change(Request $request,$id){
        $invoice=Invoice::where("id",$id)->first();
        $invoice->status=$request->status;
        $invoice->update();
        return redirect()->back();
    }

}
