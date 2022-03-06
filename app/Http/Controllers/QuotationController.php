<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use App\Models\deal;
use App\Models\DiscountPromotion;
use App\Models\Employee;
use App\Models\Freeofchare;
use App\Models\MainCompany;
use App\Models\Orderline;
use App\Models\product;
use App\Models\product_price;
use App\Models\products_tax;
use App\Models\ProductVariations;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\SellingUnit;
use App\Models\Stock;
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

    public function index()
    {
        $all_quotation = Quotation::with("customer", "sale_person", 'deal')->get();
        return view("quotation.index", compact("all_quotation"));
    }

    public function create()
    {

        $allcustomers =Customer::all();
        $variants=ProductVariations::with('product')->get();
        $taxes=products_tax::all();
        $companies = Company::all()->pluck('name', 'id');
        $Auth = Auth::guard('employee')->user()->name;
//        Session::forget($Auth);
        $session_value = \Illuminate\Support\Str::random(10);
        if (!Session::has($Auth)) {
            Session::push("$Auth", $session_value);
            $request_id = Session::get($Auth);
        } else {
            $request_id = Session::get($Auth);
        }
        $data = Session::get("quotation-" . Auth::guard('employee')->user()->id);
        $orderline = QuotationItem::with('product','variant')->where("quotation_id", $request_id)->get();
        $grand_total = 0;
        for ($i = 0; $i < count($orderline); $i++) {
            $grand_total = $grand_total + $orderline[$i]->total_amount;
        }
        $deals = deal::where('sale_stage', 'Qualified')->get();
        $unit_price=SellingUnit::where('active',1)->get();
        $prices =product_price::where('sale_type', 'Whole Sale')->where('active',1)->get();
        $aval_product=Stock::with('variant')->where('available','>',0)->get();
        $dis_promo=DiscountPromotion::where('sale_type','Whole Sale')->get();
        $focs=Freeofchare::with('variant')->get();
        $type='Whole Sale';
        return view("quotation.create", compact('deals','dis_promo' ,'focs',"allcustomers", "request_id", "orderline", 'grand_total', "companies", "unit_price", 'data','variants','taxes','aval_product','type','prices'));
    }
    public function retailSale()
    {

        $allcustomers =Customer::all();
        $variants=ProductVariations::with('product')->get();
        $taxes=products_tax::all();
        $companies = Company::all()->pluck('name', 'id');
        $Auth = Auth::guard('employee')->user()->name;
//        Session::forget($Auth);
        $session_value = \Illuminate\Support\Str::random(10);
        if (!Session::has($Auth)) {
            Session::push("$Auth", $session_value);
            $request_id = Session::get($Auth);
        } else {
            $request_id = Session::get($Auth);
        }
        $data = Session::get("quotation-" . Auth::guard('employee')->user()->id);
        $orderline = QuotationItem::with('product','variant')->where("quotation_id", $request_id)->get();
        $grand_total = 0;
        for ($i = 0; $i < count($orderline); $i++) {
            $grand_total = $grand_total + $orderline[$i]->total_amount;
        }
        $deals = deal::where('sale_stage', 'Qualified')->get();
        $unit_price=product_price::where('sale_type','Retail Sale')->where('active',1)->get();
        $aval_product=Stock::with('variant')->where('available','>',0)->get();
        $dis_promo=DiscountPromotion::where('sale_type','Retail Sale')->get();
        $focs=Freeofchare::with('variant')->get();
        $type='Retail Sale';
        return view("quotation.create", compact('deals','dis_promo' ,'focs',"allcustomers", "request_id", "orderline", 'grand_total', "companies", "unit_price", 'data','variants','taxes','aval_product','type'));
    }

    public function store(Request $request)
    {
//        dd($request->all());
        $this->validate($request, [
            'customer' => 'required',
            'expiration' => 'required',
            'term_and_condition' => 'required',
            'payment_term' => 'required',
        ]);
        $prefix = MainCompany::where('ismaincompany', true)->pluck('quotation_prefix', 'id')->first();
        $last_quotation = Quotation::orderBy('id', 'desc')->first();
        if ($last_quotation != null) {
            // Sum 1 + last id
            if ($prefix != null) {
                $ischange = $last_quotation->quotation_id;
                $ischange = explode("-", $ischange);
                if ($ischange[0] == $prefix) {
                    $last_quotation->quotation_id++;
                    $quotation_id = $last_quotation->quotation_id;
                } else {
                    $arr = [$prefix, $ischange[1]];
                    $pre = implode('-', $arr);

                    $pre++;
                    $quotation_id = $pre;
                }
            } else {
                $last_quotation->quotation_id++;
                $quotation_id = $last_quotation->quotation_id;
            }
        } else {
            $quotation_id = ($prefix ?: 'Quo') . "-0001";
        }
//        dd($quotation_id);
        $quotation = new Quotation();
        $quotation->customer_name = $request->customer;
        $quotation->quotation_id = $quotation_id;
        $quotation->deal_id = $request->deal_id;
        $quotation->exp_date = $request->expiration;
        $quotation->sale_person_id= Auth::guard('employee')->user()->id;
        $quotation->terms_conditions = $request->term_and_condition;
        $quotation->grand_total = $request->grand_total;
        $quotation->payment_term = $request->payment_term;
        $quotation->is_confirm = isset($request->confirm) ? 1 : 0;
        $quotation->tax_id=$request->tax_id;
        $quotation->total=$request->total;
        $quotation->sale_type=$request->sale_type;
        $quotation->tax_amount=$request->tax_amount??0;
        $quotation->discount=$request->discount;
        $quotation->save();
        if (isset($request->deal_id)) {
            $deal = deal::where('id', $request->deal_id)->first();
            $deal->sale_stage = 'Quotation';
            $deal->update();
        }
        $auth = Auth::guard('employee')->user()->name;
        $form_id = Session::get($auth);

        $orderlines = QuotationItem::where("quotation_id", $form_id)->get();
        foreach ($orderlines as $order) {
            $order->quotation_id = $quotation->id;
            $order->update();
        }
        Session::forget($auth);
        Session::forget("quotation-" . Auth::guard('employee')->user()->id);
        if (isset($request->send_email)) {
            return response()->json(['url' => url("/quotations/sendemail/$quotation->quotation_id")]);
        } else {
            return redirect("/quotations")->with("message", "Successful");
        }


    }

    public function discard(Request $request)
    {
//        dd($request->all());
        Session::forget("quotation-" . Auth::guard('employee')->user()->id);
        $orders = QuotationItem::where("quotation_id", $request->quotation_id)->get();
        foreach ($orders as $order) {
            $order->delete();
        }
    }

    public function show($id)
    {
        $quotation = Quotation::with("customer", "sale_person",'tax')->where('id', $id)->firstOrFail();
        $orderline = QuotationItem::with('product')->where("quotation_id", $quotation->id)->get();
        $grand_total = 0;
        for ($i = 0; $i < count($orderline); $i++) {
            $grand_total = $grand_total + $orderline[$i]->total_amount;
        }
        $company = MainCompany::where('ismaincompany', true)->first();
        return view("quotation.show", compact("quotation", "company", "orderline", 'grand_total'));
    }

    public function sendEmail($quotation_id)
    {
        $quotation = Quotation::with("customer", "sale_person")->where('quotation_id', $quotation_id)->first();
        $orderline = QuotationItem::with('variant','unit','discount')->where("quotation_id", $quotation->id)->get();
        $grand_total = 0;
        for ($i = 0; $i < count($orderline); $i++) {
            $grand_total = $grand_total + $orderline[$i]->total_amount;
        }
        $company = MainCompany::where('ismaincompany', true)->first();
        return view("quotation.sendmail", compact("quotation", "company", "orderline", 'grand_total'));
    }

    public function email(Request $request)
    {
//        dd(env('MAIL_PORT'));
//        dd($request->all());
        if ($request->attch != null) {
            $file = $request->attch;
            $file_name = $file->getClientOriginalName();
            $request->attch->move(public_path() . '/attach_file/', $file_name);
        }

        $orderline = QuotationItem::with('product')->where("quotation_id", $request->id)->get();

        $details = [
            'email' => $request->email,
            'subject' => $request->subject,
            'clientname' => $request->client_name,
            'id' => $request->id,
            'total' => $request->grand_total,
            'payterm' => $request->pay_term,
            'exp' => $request->exp,
            'term_and_con' => $request->term_condition,
            'company' => $request->company,
            'cc' => $request->email_cc,
            'orders' => $orderline,
            'attach' => $request->attach != null ? public_path() . '/attach_file/' . $file_name : '',
        ];
        Mail::send('quotation.mail', $details, function ($message) use ($details) {
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

        return redirect("quotations")->with("message", "Email has been sent");
    }

    public function edit($id)
    {
        $companies = $this->companyContract->all()->pluck('name', 'id')->all();
        $quotation = Quotation::with("customer", "sale_person")->where("id", $id)->first();

        $products = product::all();
        $allcustomers = Customer::all();
        $orderline = QuotationItem::with('product')->where("quotation_id", $quotation->id)->get();
        $grand_total = 0;
        for ($i = 0; $i < count($orderline); $i++) {
            $grand_total = $grand_total + $orderline[$i]->total_amount;
        }
        $payterm = ["Immediate Payment", "15 Days", "15 Days", "30 Days", "45 Days", "2 Months",
            "End Of Following Month", "30% Now,Balance 60 Days"];
        $deals = deal::where('sale_stage', 'Qualified')->get();
        $taxes=products_tax::all();
        $unit_price=product_price::where('sale_type',$quotation->sale_type)->get();
        $aval_product=Stock::with('variant')->where('available','>',0)->get();
        $dis_promo=DiscountPromotion::where('sale_type',$quotation->sale_type)->get();
        $focs=Freeofchare::with('variant')->get();
        return view("quotation.edit", compact('grand_total', 'deals', "allcustomers", 'payterm', "companies", "products", "quotation", 'orderline','unit_price','taxes','aval_product','dis_promo','focs'));
    }

    public function update(Request $request, $id)
    {
//        dd($request->all());
        $quotation = Quotation::where("id", $id)->first();
        $quotation->customer_name = $request->customer;
        $quotation->deal_id = $request->deal_id;
        $quotation->exp_date = $request->expiration;
        $quotation->sale_person_id = Auth::guard('employee')->user()->id;
        $quotation->terms_conditions = $request->term_and_condition;
        $quotation->grand_total = $request->grand_total;
        $quotation->payment_term = $request->payment_term;
        $quotation->is_confirm = isset($request->confirm) ? 1 : 0;
        $quotation->tax_id=$request->tax_id;
        $quotation->discount=$request->discount;
        $quotation->total=$request->total;
        $quotation->tax_amount=$request->tax_amount;
        $quotation->update();
        return response()->json([
            'tags' => "success",
        ]);
    }

    public function destroy($id)
    {
        $quotation = Quotation::where("id", $id)->first();
        $quotation->delete();
        return redirect('/quotations')->with("message", "Delete Successful");
    }

    public function confirm($id)
    {
        $quotaion = Quotation::where("id", $id)->first();
        $quotaion->is_confirm = 1;
        $quotaion->update();
        return redirect()->back()->with('success', 'This Quotation is confirmed');
    }
}
