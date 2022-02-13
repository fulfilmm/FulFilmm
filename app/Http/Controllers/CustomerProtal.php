<?php

namespace App\Http\Controllers;

use App\Models\assign_ticket;
use App\Models\Customer;
use App\Models\deal;
use App\Models\DeliveryOrder;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\leadModel;
use App\Models\MainCompany;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\priority;
use App\Models\Quotation;
use App\Models\status;
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
        $auth_id=Auth::guard('customer')->user()->id;
        $delivery_finish=DeliveryOrder::where('receipt',1)->where('courier_id',Auth::guard('customer')->user()->id)->count();
        $delivery_unfinish=DeliveryOrder::where('receipt',0)->where('courier_id',Auth::guard('customer')->user()->id)->count();
        $total = DB::table("delivery_orders")
            ->select(DB::raw("SUM(delivery_fee) as total"))
           ->where('receipt',1)->where('courier_id',Auth::guard('customer')->user()->id)
            ->get();
            $deli_fee_total=$total[0]->total;
        $new_deli=DeliveryOrder::with('employee')->where('courier_id',Auth::guard('customer')->user()->id)->where('seen',0)->get();
            $ticket_count=ticket::where('customer_id',$auth_id)->count();
            $order_count=Order::where('customer_id',$auth_id)->count();
            $invoice_count=Invoice::where('customer_id',$auth_id)->count();
            $advance=DB::table("advance_payments")
                ->select(DB::raw("SUM(amount) as total"))
                ->where('customer_id',$auth_id)
                ->get();
        return view('customerprotal.home',compact('ticket_count','order_count','invoice_count','advance','delivery_finish','delivery_unfinish','deli_fee_total','new_deli'));
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
        $new_deli=DeliveryOrder::with('employee')->where('seen',0)->get();
        return view('customerprotal.dashboard',compact('data','new_deli'));
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
    public function invoice(){
        $customer_id=Auth::guard('customer')->user()->id;
        $allinv=Invoice::with('employee','order')->where('customer_id',$customer_id)->get();
        $status=['Paid','Unpaid','Pending','Cancel','Draft','Sent'];
        return view('invoice.index',compact('allinv','status'));
    }
    public function invoice_show($id){
        $detail_inv=Invoice::with('customer','employee','tax','order')->where('id',$id)->firstOrFail();
        $company=MainCompany::where('ismaincompany',true)->first();
        $invoic_item=OrderItem::with('variant','unit')->where("inv_id",$detail_inv->id)->get();
        return view('customerprotal.invoice',compact('detail_inv','invoic_item','company'));
    }
    public function ticket(){
        $statuses = status::all()->pluck('name', 'id')->all();
        $depts = Department::all()->pluck('name', 'id')->all();
        $priorities = priority::all()->pluck('priority', 'id')->all();
        $all_emp = Employee::all()->pluck('name', 'id')->all();
        $assign_ticket = assign_ticket::with('agent', 'dept')->get();
        $all_tickets = ticket::with('ticket_status', 'ticket_priority')->where("customer_id", Auth::guard('customer')->user()->id)->paginate(10);
        $status_color = ['New' => '#49d1b6', 'Open' => '#f2b611', 'Close' => '#4e5450', 'Pending' => '#145402', 'In Progress' => '#2333e8', 'Complete' => '#18b820', 'Overdue' => '#f02416'];
        return view('customerprotal.ticket', compact('status_color', 'all_tickets', 'assign_ticket', 'statuses', 'priorities', 'all_emp', 'depts'));
    }
}
