<?php

namespace App\Http\Controllers;

use App\Jobs\RFQsMail;
use App\Models\Customer;
use App\Models\product;
use App\Models\ProductReceive;
use App\Models\ProductReceiveItem;
use App\Models\PurchaseItem;
use App\Models\PurchaseRequest;
use App\Models\RequestForQuotation;
use App\Models\RFQItems;
//use Barryvdh\DomPDF\PDF;
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rfqs = RequestForQuotation::with('source', 'vendor')->get();
        return view('Purchase.RFQs.index', compact('rfqs'));
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
        return view('Purchase.RFQs.create', compact('items', 'product', 'grand_total', 'creation_id', 'suppliers', 'data', 'rfq_data', 'pr'));
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
            $purchase_id = "P-00001";
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
        $rfq->save();
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
        $product_receive=ProductReceive::where('rfq_id',$id)->first();
        return view('Purchase.RFQs.show', compact('rfq', 'rfq_items','product_receive'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
        $rfq= RequestForQuotation::with('vendor')->where('id', $request->rfq_id)->first();
        $details = array(
            'email' => $request->email,
            'title' => "Request For Quotation",
            'body' => $request->body,
            'rfq' =>$rfq,
            'items' => RFQItems::with('product')->where('rfq_id', $request->rfq_id)->get(),
        );
        Mail::send('Purchase.RFQs.sendmail', $details, function($message)use($details) {
            $message->to($details["email"], $details["email"])
                ->subject($details["title"]);
        });
        $rfq->status='RFQ Sent';
        $rfq->update();
        return redirect(route('rfqs.show',$rfq->id));
    }
    public function statuschange($id,$status){
        $rfq=RequestForQuotation::where('id',$id)->first();
        $rfq->status=$status;
        if($status=='Confirm Order'){
        $rfq->confirm_date=Carbon::now();
        $rfq->update();
            $last_rfq =ProductReceive::orderBy('id', 'desc')->first();

            if ($last_rfq != null) {
                $last_rfq->purchase_id++;
                $received_id = $last_rfq->received_id;
            } else {
                $received_id = "WH/IN/"."00001";
            }
            $rfq=RequestForQuotation::with('vendor')->where('id',$id)->first();
            $rfq_items = RFQItems::with('product')->where('rfq_id', $id)->get();
            $product_receive=new ProductReceive();
            $product_receive->received_id=$received_id;
            $product_receive->schedule_date=$rfq->receipt_date;
            $product_receive->deadline=$rfq->deadline;
            $product_receive->rfq_id=$rfq->id;
            $product_receive->vendor_id=$rfq->vendor_id;
            $product_receive->save();
            foreach ($rfq_items as $item){
                $rece_item=new ProductReceiveItem();
                $rece_item->product_id=$item->product_id;
                $rece_item->demand=$item->qty;
                $rece_item->qty=$item->qty;
                $rece_item->rfq_id=$rfq->id;
                $rece_item->receipt_id=$product_receive->id;
                $rece_item->save();
            }
            return redirect(route('receipt.show',$product_receive->id));

        }else{
            $rfq->update();
            return redirect(route('rfqs.index'));
        }

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

        return view('Purchase.RFQs.receivedproduct',compact('received_id','rfq','rfq_items'));
    }
}
