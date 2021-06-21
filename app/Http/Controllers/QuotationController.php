<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Orderline;
use App\Models\product;
use App\Models\Quotation;
use App\Repositories\Contracts\CompanyContract;
use App\Repositories\Contracts\CustomerContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
            $allemployees = Employee::all();
            $allcustomers = Customer::all();
            $products=product::with("category","taxes")->get();
            $lastcustomer=customer::orderBy('id', 'desc')->first();
            $last_quotation=Quotation::orderBy('id', 'desc')->first();
            $companies=Company::all();
        $lastcompany=Company::orderBy('id', 'desc')->first();
        if (isset($lastcompany)) {
            // Sum 1 + last id
            $lastcompany->company_id ++;
            $company_id = $lastcompany->company_id;
        } else {
            $company_id="Company"."-00001";
        }

        if (isset($lastcustomer)) {
            // Sum 1 + last id
            $lastcustomer->customer_id ++;
            $client_id = $lastcustomer->customer_id;
        } else {
            $client_id=" Client"."-00001";
        }
        if (isset($last_quotation)) {
            // Sum 1 + last id
            $last_quotation->quotation_id ++;
            $quotation_id = $last_quotation->quotation_id;
        } else {
            $quotation_id="Quotation"."-0001";
        }

        return view("quotation.create",compact("allcustomers","client_id","companies","products","quotation_id"));
    }
    public function store(Request $request){
//        dd($request->all());
        $quotation=new Quotation();
        $quotation->customer_name=$request->customer;
        $quotation->quotation_id=$request->quotation_id;
        $quotation->exp_date=$request->expiration;
        $quotation->sale_person_id=Auth::guard('employee')->user()->id;
        $quotation->terms_conditions=$request->term_and_condition;
        $quotation->grand_total=$request->grand_total;
        $quotation->payment_term=$request->payment_term;
        $quotation->is_confirm=0;
        $quotation->save();
        return redirect("/quotations")->with("message","Successful");
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
        $file = $request->attch;
        $file_name = $file->getClientOriginalName();
        $request->attch->move(public_path() . '/attach_file/', $file_name);
        ;
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
            'attach'=>public_path().'/attach_file/'.$file_name,
        ];
        Mail::send('quotation.testmail', $details, function ($message) use ($details) {
            $message->from('cincin.com@gmail.com', 'Cloudark');
            $message->to($details['email']);
            $message->subject($details['subject']);
            if ($details['cc']!=null) {
                $message->cc($details['cc']);
            }
            $message->attach($details['attach']);
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
    public function delete($id){
        $quotation=Quotation::where("id",$id)->first();
        $quotation->delete();
        return redirect('/quotations')->with("message","Delete Successful");
    }
}
