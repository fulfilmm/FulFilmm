<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\MainCompany;
use App\Models\Orderline;
use App\Models\product;
use App\Models\Quotation;
use App\Repositories\Contracts\CompanyContract;
use App\Repositories\Contracts\CustomerContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use mysql_xdevapi\Exception;
use Psy\Util\Str;
use Throwable;

class QuotationController extends Controller
{
    private $customerContract, $companyContract;
    public function __construct(CustomerContract $customerContract, CompanyContract $companyContract)
    {
        $this->customerContract = $customerContract;
        $this->companyContract = $companyContract;
    }
    public function index(){
        $all_quotation=Quotation::with("customer","sale_person")->get();
        return view("quotation.index",compact("all_quotation"));
    }
    public function create(){

            $allcustomers = Customer::all();
            $products=product::with("category","taxes")->get();
            $companies=Company::all();
        $Auth=Auth::guard('employee')->user()->name;
//        Session::forget($Auth);
        $session_value=\Illuminate\Support\Str::random(10);
        if(!Session::has($Auth)){
            Session::push("$Auth",$session_value);
            $request_id=Session::get($Auth);
        }else{
            $request_id=Session::get($Auth);
        }
            $orderline=Orderline::with('product')->where("quotation_id",$request_id)->get();
            $grand_total=0;
            for ($i=0;$i<count($orderline);$i++){
                $grand_total=$grand_total+$orderline[$i]->total_amount;
        }
        return view("quotation.create",compact("allcustomers","request_id","orderline",'grand_total',"companies","products"));
    }
    public function store(Request $request)
    {

        $this->validate($request,[
            'customer' => 'required',
            'expiration' => 'required',
            'term_and_condition' => 'required',
            'payment_term' => 'required',
        ]);
        $prefix=MainCompany::where('ismaincompany',true)->pluck('quotation_prefix','id')->first();
        $last_quotation=Quotation::orderBy('id', 'desc')->first();
        if (isset($last_quotation)) {
            // Sum 1 + last id
            $ischange=$last_quotation->quotation_id;
            $ischange=explode("-", $ischange);
            if($ischange[0]==$prefix){
                $last_quotation->quotation_id++;
                $quotation_id = $last_quotation->quotation_id;
            }else{
                $arr=[$prefix,$ischange[1]];
                $pre=implode('-',$arr);
                $pre ++;
                $quotation_id=$pre;
            }
        } else {
            $quotation_id=$prefix?'':"Quotation"."-0001";
        }
                $quotation = new Quotation();
                $quotation->customer_name = $request->customer;
                $quotation->quotation_id = $quotation_id;
                $quotation->exp_date = $request->expiration;
                $quotation->sale_person_id = Auth::guard('employee')->user()->id;
                $quotation->terms_conditions = $request->term_and_condition;
                $quotation->grand_total = $request->grand_total;
                $quotation->payment_term = $request->payment_term;
                $quotation->is_confirm = 0;
                $quotation->save();
                $auth=Auth::guard('employee')->user()->name;
                $form_id=Session::get($auth);
                $orderlines=Orderline::where("quotation_id",$form_id)->get();
                foreach ($orderlines as $order){
                    $order->quotation_id=$quotation_id;
                    $order->update();
                }
                Session::forget($auth);
                return redirect("/quotations")->with("message", "Successful");

    }
    public function discard(Request $request){
        $orders=Orderline::where("quotation_id",$request->quotation_id)->get();
        foreach ($orders as $order){
            $order->delete();
        }
    }

    public function show($id){
        $quotation=Quotation::with("customer","sale_person")->where('id',$id)->first();
        $orderline=Orderline::with('product')->where("quotation_id",$quotation->quotation_id)->get();
        $grand_total=0;
        for ($i=0;$i<count($orderline);$i++){
            $grand_total=$grand_total+$orderline[$i]->total_amount;
        }
        $company=company::where("id",$quotation->company_id)->first();
        return view("quotation.show",compact("quotation","company","orderline",'grand_total'));
    }
    public function sendEmail($quotation_id){
        $quotation=Quotation::with("customer","sale_person")->where('quotation_id',$quotation_id)->first();
        $orderline=Orderline::with('product')->where("quotation_id",$quotation->quotation_id)->get();
        $grand_total=0;
        for ($i=0;$i<count($orderline);$i++){
            $grand_total=$grand_total+$orderline[$i]->total_amount;
        }
        $company=Company::userCompanyName() ?? null;
        return view("quotation.sendmail",compact("quotation","company","orderline",'grand_total'));
    }
    public function email(Request $request){
//        dd(env('MAIL_PORT'));
//        dd($request->all());
      if($request->attch!=null){
          $file = $request->attch;
          $file_name = $file->getClientOriginalName();
          $request->attch->move(public_path() . '/attach_file/', $file_name);
      }

        $orderline=Orderline::with('product')->where("quotation_id",$request->id)->get();

        $details=[
            'email'=>$request->email,
            'subject'=>$request->subject,
            'clientname'=>$request->client_name,
            'id'=>$request->id,
            'total'=>$request->grand_total,
            'payterm'=>$request->pay_term,
            'exp'=>$request->exp,
            'term_and_con'=>$request->term_condition,
            'company'=>$request->company,
            'cc'=>$request->email_cc,
            'orders'=>$orderline,
            'attach'=>$request->attach!=null?public_path().'/attach_file/'.$file_name:'',
        ];
        Mail::send('quotation.mail', $details, function ($message) use ($details) {
            $message->from('siyincin@gmail.com', 'Cloudark');
            $message->to($details['email']);
            $message->subject($details['subject']);
            if ($details['cc']!=null) {
                $message->cc($details['cc']);
            }
            if($details['attach']!=''){
                $message->attach($details['attach']);
            }

        });

        return redirect("quotations")->with("message","Email has been sent");
    }
    public function edit($id){
        $companies = $this->companyContract->all()->pluck('name', 'id')->all();
        $quotation=Quotation::with("customer","sale_person")->where("id",$id)->first();
        $products=product::all();
        $allcustomers=Customer::all();
        $payterm=["Immediate Payment","15 Days","15 Days","30 Days","45 Days","2 Months",
            "End Of Following Month","30% Now,Balance 60 Days"];
        return view("quotation.edit",compact("allcustomers",'payterm',"companies","products","quotation"));
    }
    public function update(Request $request,$id){
//        dd($request->all());
        $quotation=Quotation::where("id",$id)->first();
        $quotation->customer_name=$request->customer;
        $quotation->quotation_id=$request->quotation_id;
        $quotation->exp_date=$request->expiration;
        $quotation->terms_conditions=$request->term_and_condition;
        $quotation->grand_total=$request->grand_total;
        $quotation->payment_term=$request->payment_term;
        $quotation->update();
        return response()->json([
            'tags' => "success",
        ]);
    }
    public function destroy($id){
        $quotation=Quotation::where("id",$id)->first();
        $quotation->delete();
        return redirect('/quotations')->with("message","Delete Successful");
    }
}
