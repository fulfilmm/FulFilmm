<?php

namespace App\Http\Controllers;

use App\Jobs\RFQsMail;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\MainCompany;
use App\Models\product;
use App\Models\ProductReceive;
use App\Models\ProductReceiveItem;
use App\Models\PurchaseItem;
use App\Models\PurchaseRequest;
use App\Models\RequestForQuotation;
use App\Models\rfq_follower;
use App\Models\RFQItems;
//use Barryvdh\DomPDF\PDF;
use App\Traits\NotifyTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use PDF;

class RFQController extends Controller
{
    use NotifyTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rfqs = RequestForQuotation::with('source', 'vendor')->get();
        $confirm=RequestForQuotation::where('status','Confirm Order')->count();
        $tosend=RequestForQuotation::where('status','Daft')->count();
        $waiting=RequestForQuotation::where('status','RFQ Sent')->count();
        $overdue=RequestForQuotation::whereDate('deadline','<',Carbon::now())->where('status','!=','Confirm Order')->count();

//        dd($overdue);
        return view('Purchase.RFQs.index', compact('rfqs','confirm','tosend','waiting','overdue'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Customer::where('customer_type', 'Supplier')->get();
        $session_value = \Illuminate\Support\Str::random(10);
        $Auth = "rfq-" . Auth::guard('employee')->user()->id;
        if (!Session::has($Auth)) {
            Session::push("$Auth", $session_value);
            $creation_id = Session::get($Auth);
        } else {
            $creation_id = Session::get($Auth);
        }
        $items = RFQItems::where('creation_id', $creation_id)->get();
        $total = DB::table("r_f_q_items")
            ->select(DB::raw("SUM(total) as total"))
            ->where('creation_id', $creation_id)
            ->get();
        $grand_total = $total[0]->total;
        $product = product::all()->pluck('name', 'id')->all();
        $session_key = 'rfqdata-' . Auth::guard('employee')->user()->id;
        $data = Session::get($session_key) ?? [];
        $rfq_data = Session::get('rfqformdata-' . Auth::guard('employee')->user()->id);
        $pr = PurchaseRequest::all()->pluck('pr_id', 'id')->all();
        $emps=Employee::all()->pluck('name','id')->all();
        return view('Purchase.RFQs.create', compact('items', 'product', 'grand_total', 'creation_id', 'suppliers', 'data', 'rfq_data', 'pr','emps'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $last_rfq = RequestForQuotation::orderBy('id', 'desc')->first();

        if ($last_rfq != null) {
            $last_rfq->purchase_id++;
            $purchase_id = $last_rfq->purchase_id;
        } else {
            $purchase_id = "RFQ-00001";
        }
        $rfq = new  RequestForQuotation();
        $rfq->purchase_id = $purchase_id;
        $rfq->vendor_id = $request->vendor_id;
        $rfq->pr_id = $request->source;
        $rfq->receipt_date = $request->receive_date;
        $rfq->deadline = $request->deadline;
        $rfq->description = $request->description;
        $rfq->total_cost = $request->total_cost ?? 0;
        $rfq->status = 'Daft';
        $rfq->creator_id = Auth::guard('employee')->user()->id;
        $rfq->vendor_reference = $request->vendor_reference;
        $rfq->type = $request->type;
        if(isset($request->attach)){
            foreach ($request->file('attach') as $attach) {
                $name = $attach->getClientOriginalName();
                $attach->move(public_path() . '/attach_file/', $name);
                $data[] = $name;
            }
            $rfq->attach = json_encode($data);
        }
        $rfq->save();
        if($request->tag!=null){
            foreach ($request->tag as $emp){
                $this->addtag($emp,$rfq->id);
                $this->addnotify($emp,'warning',' Added as a follower of '.$purchase_id,'rfqs/'.$rfq->id,Auth::guard('employee')->user()->id);
            }
        }
        $Auth = "rfq-" . Auth::guard('employee')->user()->id;
        $creation_id = Session::get($Auth);
        $rfq_items = RFQItems::where('creation_id', $creation_id)->get();
        foreach ($rfq_items as $item) {
            $item->rfq_id = $rfq->id;
            $item->update();
        }
        Session::forget($Auth);
        Session::forget('rfqformdata-' . Auth::guard('employee')->user()->id);
        return redirect(route('rfqs.show', $rfq->id));
    }
    public function addtag($emp_id,$rfq_id){
        $data['rfq_id']=$rfq_id;
        $data['emp_id']=$emp_id;
        rfq_follower::create($data);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rfq = RequestForQuotation::with('source', 'vendor')->where('id', $id)->firstOrFail();
        $rfq_items = RFQItems::with('product')->where('rfq_id', $id)->get();
        $company=MainCompany::where('ismaincompany',true)->first();
        $followers=rfq_follower::with('emp')->where('rfq_id',$id)->get();
        $attach=json_decode($rfq->attach)??[];
        return view('Purchase.RFQs.show', compact('rfq', 'rfq_items','company','followers','attach'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rfq=RequestForQuotation::where('id',$id)->first();
        $suppliers = Customer::where('customer_type', 'Supplier')->get();
        $session_value = \Illuminate\Support\Str::random(10);
        $Auth = "rfq-" . Auth::guard('employee')->user()->id;
        if (!Session::has($Auth)) {
            Session::push("$Auth", $session_value);
            $creation_id = Session::get($Auth);
        } else {
            $creation_id = Session::get($Auth);
        }
        $items = RFQItems::where('rfq_id',$rfq->id)->get();
        $total = DB::table("r_f_q_items")
            ->select(DB::raw("SUM(total) as total"))
            ->where('creation_id', $creation_id)
            ->get();
        $grand_total = $total[0]->total;
        $product = product::all()->pluck('name', 'id')->all();
        $pr = PurchaseRequest::all()->pluck('pr_id', 'id')->all();
        return view('Purchase.RFQs.edit', compact('items', 'product', 'grand_total', 'suppliers', 'pr','rfq'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rfq = RequestForQuotation::where('id',$id)->first();
        $rfq->vendor_id = $request->vendor_id;
        $rfq->pr_id = $request->source;
        $rfq->receipt_date = $request->receive_date;
        $rfq->deadline = $request->deadline;
        $rfq->description = $request->description;
        $rfq->total_cost = $request->total_cost ?? 0;
        $rfq->vendor_reference = $request->vendor_reference;
        $rfq->type = $request->type;
        $rfq->update();
        return redirect('rfqs');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rfq=RequestForQuotation::where('id',$id)->firstOrFail();
        $rfq->delete();
        return redirect()->back();
    }

    public function prepare_rfq($id)
    {
        $pr = PurchaseRequest::where('id', $id)->first();
        if ($pr->status == "Approved") {
            $suppliers = Customer::where('customer_type', 'Supplier')->get();
            $session_value = \Illuminate\Support\Str::random(10);
            $Auth = "rfq-" . Auth::guard('employee')->user()->id;
            if (!Session::has($Auth)) {
                Session::push("$Auth", $session_value);
                $creation_id = Session::get($Auth);
            } else {
                $creation_id = Session::get($Auth);
            }
            $pr_items = PurchaseItem::where('pr_id', $id)->get();
            if ($pr->is_prepared == 0) {
                foreach ($pr_items as $item) {
                    $rfq_items = new RFQItems();
                    $rfq_items->creation_id = $creation_id[0];
                    $rfq_items->product_id = $item->product_id;
                    $rfq_items->qty = $item->qty;
                    $rfq_items->price = $item->price;
                    $rfq_items->description = $item->description;
                    $rfq_items->total = $item->total;
                    $rfq_items->save();
                }
                $pr->is_prepared = 1;
                $pr->update();
            }
            $items = RFQItems::with('product')->where('creation_id', $creation_id)->get();
            $total = DB::table("r_f_q_items")
                ->select(DB::raw("SUM(total) as total"))
                ->where('creation_id', $creation_id)
                ->get();
            $grand_total = $total[0]->total;

            $product = product::all()->pluck('name', 'id')->all();
            $session_key = 'rfqdata-' . Auth::guard('employee')->user()->id;
            Session::forget($session_key);
            $data = Session::get($session_key) ?? [];
            $rfq_data = Session::get('rfqformdata-' . Auth::guard('employee')->user()->id);
            $pr = PurchaseRequest::all()->pluck('pr_id', 'id')->all();
            return view('Purchase.RFQs.create', compact('grand_total', 'product', 'items', 'creation_id', 'suppliers', 'data', 'rfq_data', 'pr'));
        } else {
            return redirect()->back()->with('error', 'This purchase request does not already approve!');
        }
    }

    public function prepareemail($id)
    {
        $rfq = RequestForQuotation::with('vendor')->where('id', $id)->first();
        return view('Purchase.RFQs.mailprepare', compact('rfq'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function sendmail(Request $request)
    {

        if ($request->attach != null) {
            $file = $request->attach;
            $file_name = $file->getClientOriginalName();
            $request->attach->move(public_path() . '/attach_file/', $file_name);
        }
        $rfq= RequestForQuotation::with('vendor')->where('id', $request->rfq_id)->first();

        $details = array(
            'email' => $request->email,
            'title' => "Request For Quotation",
            'body' => $request->body,
            'rfq' =>$rfq,
            'items' => RFQItems::with('product')->where('rfq_id', $request->rfq_id)->get(),
            'attach' => $request->attach != null ? public_path() . '/attach_file/' . $file_name : '',

        );
        Mail::send('Purchase.RFQs.sendmail', $details, function($message)use($details) {
            $message->to($details["email"], $details["email"])
                ->subject($details["title"]);
            if ($details['attach'] != '') {
                $message->attach($details['attach']);
            }
        });
        $rfq->status='RFQ Sent';
        $rfq->update();
        return redirect(route('rfqs.show',$rfq->id));
    }
    public function statuschange($id,$status){
        $rfq=RequestForQuotation::where('id',$id)->first();
        $rfq->status=$status;
        $rfq->confirm_date=Carbon::now();
        $rfq->update();

            return redirect(route('rfqs.show',$id));

    }

    public function productReceive($id){
        $last_rfq =ProductReceive::orderBy('id', 'desc')->first();

        if ($last_rfq != null) {
            $last_rfq->purchase_id++;
            $received_id = $last_rfq->received_id;
        } else {
            $received_id = "WH/IN/"."00001";
        }
        $rfq=RequestForQuotation::with('vendor')->where('id',$id)->first();
        $rfq_items = RFQItems::with('product')->where('rfq_id', $id)->get();
        $rfq->status='Receipt Product';
        $rfq->update();

        return view('Purchase.RFQs.receivedproduct',compact('received_id','rfq','rfq_items'));
    }
}
