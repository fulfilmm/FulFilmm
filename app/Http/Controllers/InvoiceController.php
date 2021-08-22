<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\invoice_item;
use App\Models\MainCompany;
use App\Models\product;
use App\Models\products_tax;
use Carbon\Carbon;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use function PHPUnit\Framework\isEmpty;

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

        $allcustomers = Customer::all();
        $products=product::with("category","taxes")->get();
        $Auth=Auth::guard('employee')->user()->name;

//        Session::forget($Auth);
        $session_value=\Illuminate\Support\Str::random(10);
        if(!Session::has($Auth)){
            Session::push("$Auth",$session_value);
            $request_id=Session::get($Auth);
        }else{
            $request_id=Session::get($Auth);
        }
//        $generate_id=Str::uuid();
        $orderline=invoice_item::with('product')->where('creation_id',$request_id)->get();
//        dd($orderline);
        $grand_total=0;
        for ($i=0;$i<count($orderline);$i++){
            $grand_total=$grand_total+$orderline[$i]->total;
        }
        $status=$this->status;
        return view('invoice.create',compact('request_id','allcustomers','products','orderline','grand_total','status'));
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
        $Auth=Auth::guard('employee')->user()->name;
        $request_id=Session::get($Auth);
        $confirm_order_item=invoice_item::where("creation_id",$request_id)->get();
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
        $invoice_item=invoice_item::with('product')->where("inv_id",$id)->get();
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
        $detail_inv=Invoice::with('customer')->where('id',$id)->first();
//        dd($detail_inv);
        $invoic_item=invoice_item::with('product')->where("inv_id",$detail_inv->id)->get();
        $grand_total=0;
        for ($i=0;$i<count($invoic_item);$i++){
            $grand_total=$grand_total+$invoic_item[$i]->total;
        }
        return view('invoice.show',compact('detail_inv','invoic_item','company','grand_total'));
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
        $invoic_item=invoice_item::with('product')->where("inv_id",$request->inv_id)->get();
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
            'invoice_item'=>$invoic_item,
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
    public function search(Request $request){
//        dd('hello');
        $start_date=Carbon::create($request->form_date);
        $end_date=Carbon::create($request->to_date);
        if($request->status=="Select Status" && $request->form_date!=null || $request->to_date!=null){
            $allinv=Invoice::with('customer')->whereBetween('created_at',[$start_date,$end_date])->get();
        }else{

        }

    }
}
