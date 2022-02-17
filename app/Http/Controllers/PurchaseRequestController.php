<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\pr_follower;
use App\Models\product;
use App\Models\PurchaseItem;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestComment;
use App\Traits\NotifyTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PurchaseRequestController extends Controller
{
    use NotifyTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchase_request=PurchaseRequest::orderBy('id', 'desc')->with('approver','vendor')
            ->orWhere('creator_id',Auth::guard('employee')->user()->id)
            ->orWhere('approver_id',Auth::guard('employee')->user()->id)
            ->get();
        $statuses=['New','Approved','Reject','Pending'];
        return view('Purchase.PurchaseRequest.index',compact('purchase_request','statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $approvers=Employee::all();
        $suppliers=Customer::where('customer_type','Supplier')->get();
        $session_value=\Illuminate\Support\Str::random(10);
        $Auth="pr-".Auth::guard('employee')->user()->id;
        if(!Session::has($Auth)){
            Session::push("$Auth",$session_value);
            $creation_id=Session::get($Auth);
        }else{
            $creation_id=Session::get($Auth);
        }
        $items=PurchaseItem::with('product')->where('creation_id',$creation_id)->get();
        $total=DB::table("purchase_items")
            ->select(DB::raw("SUM(total) as total"))
            ->where('creation_id',$creation_id)
            ->get();
        $grand_total=$total[0]->total;
        $product=product::all()->pluck('name','id')->all();
        $Auth=Auth::guard('employee')->user()->id;
//        Session::forget("prdata-".$Auth);
        $pr_data=Session::get("prdata-".$Auth);
        $emps=Employee::all()->pluck('name','id')->all();
        return view('Purchase.PurchaseRequest.create',compact('approvers','suppliers','items','product','grand_total','creation_id','pr_data','emps'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
           'approver_id'=>'required',
           'deadline'=>'required',
           'item'=>'required',
        ]);
//        dd($request->all());
        $last_pr=PurchaseRequest::orderBy('id', 'desc')->first();

        if ($last_pr!=null) {
                $last_pr->pr_id++;
                $pr_id = $last_pr->pr_id;
        } else {
            $pr_id="PR-0001";
        }
        $pr=new PurchaseRequest();
        $pr->vendor_id=$request->vendor_id;
        $pr->approver_id=$request->approver_id;
        $pr->deadline=$request->deadline;
        $pr->description=$request->description;
        $pr->total_cost=$request->total_cost??0;
        $pr->type=$request->type;
        $pr->pr_id=$pr_id;
        $pr->creator_id=Auth::guard('employee')->user()->id;
        $pr->status='New';
        if(isset($request->file)){
            foreach ($request->file('file') as $attach) {
                $name = $attach->getClientOriginalName();
                $attach->move(public_path() . '/attach_file/', $name);
                $data[] = $name;
            }
            $pr->attach = json_encode($data);
        }
        $pr->save();
        $Auth="pr-".Auth::guard('employee')->user()->id;
        $creation_id=Session::get($Auth);
        $items=PurchaseItem::where('creation_id',$creation_id)->get();
        foreach ($items as $item){
            $item->pr_id=$pr->id;
            $item->update();
        }
        Session::forget($Auth);
        Session::forget("prdata-".Auth::guard('employee')->user()->id);

       if($request->tag!=null){
           foreach ($request->tag as $emp){
               $this->addtag($emp,$pr->id);
               $this->addnotify($emp,'warning',' Added as a follower of '.$pr_id,'purchaserequest/'.$pr->id,Auth::guard('employee')->user()->id);
           }
       }
        $this->addnotify($request->approver_id,'general',' Requested purchase request id '.$pr_id.'to you','purchase_request/'.$pr->id,Auth::guard('employee')->user()->id);
        return redirect(route('purchase_request.index'));
    }
    public function addtag($emp_id,$pr_id){
        $data['pr_id']=$pr_id;
        $data['emp_id']=$emp_id;
        pr_follower::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $prs=PurchaseRequest::with('approver','vendor')->where('id',$id)->firstOrFail();
        $items=PurchaseItem::with('product')->where('pr_id',$id)->get();
        $statuses=['New','Approved','Reject','Pending'];
        $total=DB::table("purchase_items")
            ->select(DB::raw("SUM(total) as total"))
            ->where('pr_id',$id)
            ->get();
        $grand_total=$total[0]->total;
        $attach=json_decode($prs->attach)??[];
        $comments=PurchaseRequestComment::with('emp')->where('pr_id',$id)->get();
        $followers=pr_follower::with('emp')->where('pr_id',$id)->get();
        return view('Purchase.PurchaseRequest.show',compact('prs','items','statuses','grand_total','attach','comments','followers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $emps=Employee::all();
        $suppliers=Customer::where('customer_type','Supplier')->get();
        $prs=PurchaseRequest::with('approver','vendor')->where('id',$id)->firstOrFail();
        $items=PurchaseItem::with('product')->where('pr_id',$id)->get();
        $statuses=['New','Approved','Reject','Pending'];
        $total=DB::table("purchase_items")
            ->select(DB::raw("SUM(total) as total"))
            ->where('pr_id',$id)
            ->get();
        $grand_total=$total[0]->total;
        $attach=json_decode($prs->attach)??[];
        $product=product::all()->pluck('name','id')->all();
        $pr_followers=pr_follower::where('pr_id',$id)->get();
        return view('Purchase.PurchaseRequest.edit',compact('items','statuses','grand_total','attach','suppliers','emps','prs','product','pr_followers'));
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
        $pr=PurchaseRequest::where('id',$id)->first();
        $pr->vendor_id=$request->vendor_id;
        $pr->approver_id=$request->approver_id;
        $pr->deadline=$request->deadline;
        $pr->description=$request->description;
        $pr->total_cost=$request->total_cost??0;
        $pr->type=$request->type;
        if(isset($request->file)){
            foreach ($request->file('file') as $attach) {
                $name = $attach->getClientOriginalName();
                $attach->move(public_path() . '/attach_file/', $name);
                $data[] = $name;
            }
            $pr->attach = json_encode($data);
        }
        $pr->update();
        $pr_follower=pr_follower::where('pr_id',$id)->get();
        foreach ($pr_follower as $item){
            $item->delete();
        }
        if($request->tag!=null){
            foreach ($request->tag as $emp){
                    $this->addtag($emp,$pr->id);

            }
        }
        return redirect('purchase_request');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function status_change(Request $request,$id){
        $purchase_request=PurchaseRequest::where('id',$id)->firstorFail();
        $purchase_request->status=$request->status;
        $purchase_request->update();
        $this->addnotify($request->creator_id,'general',' Requested purchase request id '.$purchase_request->pr_id.'to you','purchase_request/'.$purchase_request->id,$purchase_request->approver_id);
    }
    public function comment(Request $request){
        $pr_cmt=new PurchaseRequestComment();
        if($request->comment!=null){
            $pr_cmt->comment=$request->comment;
            $pr_cmt->pr_id=$request->pr_id;
            $pr_cmt->emp_id=Auth::guard('employee')->user()->id;
            $pr_cmt->save();
        }
        return redirect()->back();
    }
    public function cmt_delete($id){
       $cmt=PurchaseRequestComment::where('id',$id)->first();
       $cmt->delete();
       return redirect()->back();
    }
}
