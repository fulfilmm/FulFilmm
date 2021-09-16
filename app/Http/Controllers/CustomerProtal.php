<?php

namespace App\Http\Controllers;

use App\Models\assign_ticket;
use App\Models\Customer;
use App\Models\deal;
use App\Models\Invoice;
use App\Models\leadModel;
use App\Models\Quotation;
use App\Models\ticket;
use App\Models\ticket_sender;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerProtal extends Controller
{
    public function home(){

        return view('customerprotal.home');
    }
    public function quotation(){

        $all_quotation= $all_quotation=Quotation::with("customer","sale_person")->where('customer_name',Auth::guard('customer')->user()->id)->get();
        return view('customerprotal.quotation',compact('all_quotation'));
    }
    public function dashboard(){
        $id=Auth::guard('customer')->user()->id;
        $assign_ticket = assign_ticket::with('agent', 'dept')->get();
        $ticket_history=ticket_sender::where('customer_id',$id)->first();

        if($ticket_history==null){
            $customer_ticket=[];
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
}
