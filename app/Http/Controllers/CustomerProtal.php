<?php

namespace App\Http\Controllers;

use App\Models\assign_ticket;
use App\Models\Customer;
use App\Models\deal;
use App\Models\DeliveryOrder;
use App\Models\Invoice;
use App\Models\leadModel;
use App\Models\Quotation;
use App\Models\ticket;
use App\Models\ticket_sender;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Claims\Custom;

class CustomerProtal extends Controller
{
    public function home(){
        $delivery_finish=DeliveryOrder::where('receipt',1)->where('courier_id',Auth::guard('customer')->user()->id)->count();
        $delivery_unfinish=DeliveryOrder::where('receipt',0)->where('courier_id',Auth::guard('customer')->user()->id)->count();
        $total = DB::table("delivery_orders")
            ->select(DB::raw("SUM(delivery_fee) as total"))
           ->where('receipt',1)->where('courier_id',Auth::guard('customer')->user()->id)
            ->get();
            $deli_fee_total=$total[0]->total;
        return view('customerprotal.home',compact('delivery_finish','delivery_unfinish','deli_fee_total'));
    }
    public function quotation(){

        $all_quotation= $all_quotation=Quotation::with("customer","sale_person")->where('customer_name',Auth::guard('customer')->user()->id)->get();
        return view('customerprotal.quotation',compact('all_quotation'));
    }
    public function dashboard(){
        $id=Auth::guard('customer')->user()->id;
//        $assign_ticket = assign_ticket::with('agent', 'dept')->get();
        $ticket_history=ticket_sender::where('customer_id',$id)->first();

        if($ticket_history==null){
            $customer_ticket=null;
        }else{
            $customer_ticket= ticket::where("customer_id",$ticket_history->customer_id)->count();
        }
        $customer_invoice=Invoice::where('customer_id',$id)->get();

        $paid_total=0;
        $overdue=0;
        $open_unpaid=0;
        foreach ($customer_invoice as $invoice){
            if($invoice->status=='Paid'){
                $paid_total=$paid_total+$invoice->grand_total;
            }elseif ($invoice->status=='Unpaid'&& Carbon::parse($invoice->due_date) > Carbon::now()){
                $overdue=$overdue+$invoice->grand_total;
            }elseif($invoice->status=='Unpaid'){
                $open_unpaid=$open_unpaid+$invoice->grand_total;
            }
        }
        $data=[
            'invoice'=>$customer_invoice,
            'tickets'=>$customer_ticket,
            'paid_total'=>$paid_total,
            'overdue'=>$overdue,
            'open'=>$open_unpaid
        ];
        return view('customerprotal.dashboard',compact('data'));
    }
    public function change_password(){
        return view('customerprotal.changepassword');
    }
    public function password_update($id,Request $request){
        $customer=Customer::where('id',$id)->first();
        if(password_verify($request->current_pass,$customer->password)){
           $customer->password=Hash::make($request->password);
           $customer->update();
        }
        return redirect('customer/home');
    }
}
