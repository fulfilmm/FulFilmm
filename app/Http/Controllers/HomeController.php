<?php

namespace App\Http\Controllers;


use App\Models\Account;
use App\Models\Approvalrequest;
use App\Models\assign_ticket;
use App\Models\countdown;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Group;
use App\Models\Meetingmember;
use App\Models\MinutesAssign;
use App\Models\SaleActivity;
use App\Models\status;
use App\Models\ticket;
use App\Models\ticket_follower;
use App\Models\Transaction;
use App\Notifications\AlertNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user=Auth::guard('employee')->user();
        $id=Auth::id();
        $month = ['Jan', 'Feb', 'March', 'April', 'May', 'June', "July", 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $monthly_expense=[];
        $monthly_income=[];
        $current_year_expense=[];
        $current_year_income=[];
        $first_6month_expense=[];
        $first_6month_income=[];
        $second_6month_expense=[];
        $second_6month_income=[];
        $total_emp=0;
        $profit=[];
        $meeting=Meetingmember::with('meeting')->where('member_id',$user->id)->count();
        $follow_ticket=ticket_follower::where('emp_id',$user->id)->count();
//          dd($meeting);
        $assignment=MinutesAssign::where('emp_id',$user->id)->count();
     //ticket Admin Dashboard
      if(Auth::guard('employee')->user()->role->name=='Ticket Admin'){
          $agents=[];
              $allemp=Employee::all();
//              dd($allemp);
              foreach ($allemp as $emp){
                  if($emp->role->name=='Agent'){
                      array_push($agents,$emp);
                  }
              }
              $assign_ticket=assign_ticket::with('ticket')->get();
              $status=status::where('name','Complete')->orWhere('name','CLose')->get();
              $status_report=$this->report_status();
              $report_percentage=$this->report_with_percentage();
              $count_down=countdown::all()->pluck('endtime','ticket_id')->all();
              $numberOfalltickets=ticket::all()->count();
              $depts=Department::all();
          $group=Group::whereHas('employees', function ($query) use ($id) {
              $query->where('employee_id', $id);
          })->count();
          return view('index', compact('numberOfalltickets','agents','depts','assign_ticket','status','status_report','report_percentage','count_down','group'));
      //End of Ticket admin Dashboard
      }elseif ($user->role->name=='Super Admin'||$user->role->name=='CEO'||$user->role->name=='Manager'){
          $total_emp=Employee::count();
          $contact=Customer::count();
          $start=date('Y').'-04-01';
          $mid=date('Y').'-09-30';
          $end=(date('Y')+1).'-03-31';
          $current_year_income = DB::table("revenues")
              ->select(DB::raw("SUM(amount) as total"))
              ->whereYear('transaction_date', date('Y'))
              ->get();
          $current_year_expense = DB::table("expenses")
              ->select(DB::raw("SUM(amount) as total"))
              ->whereYear('transaction_date', date('Y'))
              ->get();
          $current_month_income = DB::table("revenues")
              ->select(DB::raw("SUM(amount) as total"))
              ->whereMonth('transaction_date', date('m'))
              ->get();
          $current_month_expense = DB::table("expenses")
              ->select(DB::raw("SUM(amount) as total"))
              ->whereMonth('transaction_date', date('m'))
              ->get();
          $first_6month_income = DB::table("revenues")
              ->select(DB::raw("SUM(amount) as total"))
              ->whereBetween('transaction_date', [$start, $mid])
              ->get();
          $first_6month_expense = DB::table("expenses")
              ->select(DB::raw("SUM(amount) as total"))
              ->whereBetween('transaction_date', [$start, $mid])
              ->get();
          $second_6month_income = DB::table("revenues")
              ->select(DB::raw("SUM(amount) as total"))
              ->whereBetween('transaction_date', [$mid, $end])
              ->get();
          $second_6month_expense = DB::table("expenses")
              ->select(DB::raw("SUM(amount) as total"))
              ->whereBetween('transaction_date', [$mid, $end])
              ->get();


          foreach ($month as $key => $value) {
              $grand_total = DB::table("revenues")
                  ->select(DB::raw("SUM(amount) as total"))
                  ->whereMonth('transaction_date', $key + 1)->whereYear('transaction_date', date('Y'))
                  ->get();
              $monthly_income[$value] = $grand_total[0];
              $expense = DB::table("expenses")
                  ->select(DB::raw("SUM(amount) as total"))
                  ->whereMonth('transaction_date', $key+1)->whereYear('transaction_date', date('Y'))
                  ->get();
              $monthly_expense[$value] = $expense[0]??0;
              $profit[$value]=($grand_total[0]->total??0) - ($expense[0]->total??0);

          }
          $sale_activity=SaleActivity::where('report_to',Auth::guard('employee')->user()->id)->count();
          $numberOfalltickets=ticket::all()->count();
          $group=Group::count();
          $account=Account::count();
          $transaction=Transaction::count();
          $requestation=Approvalrequest::where('approved_id',Auth::guard('employee')->user()->id)
              ->orWhere('secondary_approved',Auth::guard('employee')->user()->id)
              ->count();
          $items = [
              'saleactivity'=>$sale_activity,
              'requestation'=>$requestation,
              'customer'=>$contact,
              'assignment'=>$assignment,
              'meeting'=>$meeting,
              'my_groups' =>$group,
              'all_ticket'=>$numberOfalltickets,
              'transaction'=>$transaction??0,
              'total_income'=>$current_year_income[0]->total??0,
              'total_expense'=>$current_year_expense[0]->total??0,
              'first_term_income'=>$first_6month_income[0]->total??0,
              'first_term_expense'=>$first_6month_expense[0]->total??0,
              'first_term_profit'=>($first_6month_income[0]->total??0)-($first_6month_expense[0]->total??0),
              'second_term_income'=>$second_6month_income[0]->total??0,
              'second_term_expense'=>$second_6month_expense[0]->total??0,
              'second_term_profit'=>($second_6month_income[0]->total??0)-($second_6month_expense[0]->total??0),
              'current_month_income'=>$current_month_income[0]->total??0,
              'current_month_expense'=>$current_month_expense[0]->total??0,
              'current_month_profit'=>($current_month_income[0]->total??0)-($current_month_expense[0]->total??0),
              'profit'=>Auth::guard('employee')->user()->role->name=='CEO'||Auth::guard('employee')->user()->role->name=='Super Admin'?$current_year_income[0]->total??0-$current_year_expense[0]->total??0:0,
          ];
          return view('index', compact('items','total_emp','monthly_income','monthly_expense','profit','account'));
      }elseif ($user->role->name=='Agent'){
          $sale_activity=SaleActivity::where('emp_id',Auth::guard('employee')->user()->id)->count();
          $numberOfalltickets=count($this->agent_all_ticket())+$follow_ticket;
          $requestation=Approvalrequest::where('emp_id',Auth::guard('employee')->user()->id)->count();
          $group=Group::whereHas('employees', function ($query) use ($id) {
              $query->where('employee_id', $id);
          })->count();
          $items = [
              'saleactivity'=>$sale_activity,
              'requestation'=>$requestation,
              'assignment'=>$assignment,
              'meeting'=>$meeting,
              'my_groups' =>$group,
              'all_ticket'=>$numberOfalltickets,
              'transaction'=>$transaction??0,
              'total_income'=>$current_year_income[0]->total??0,
              'total_expense'=>$current_year_expense[0]->total??0,
              'first_term_income'=>$first_6month_income[0]->total??0,
              'first_term_expense'=>$first_6month_expense[0]->total??0,
              'first_term_profit'=>($first_6month_income[0]->total??0)-($first_6month_expense[0]->total??0),
              'second_term_income'=>$second_6month_income[0]->total??0,
              'second_term_expense'=>$second_6month_expense[0]->total??0,
              'second_term_profit'=>($second_6month_income[0]->total??0)-($second_6month_expense[0]->total??0),
              'current_month_income'=>$current_month_income[0]->total??0,
              'current_month_expense'=>$current_month_expense[0]->total??0,
              'current_month_profit'=>($current_month_income[0]->total??0)-($current_month_expense[0]->total??0),
              'profit'=>Auth::guard('employee')->user()->role->name=='CEO'||Auth::guard('employee')->user()->role->name=='Super Admin'?$current_year_income[0]->total??0-$current_year_expense[0]->total??0:0,
          ];
      } else {
             $requestation=Approvalrequest::where('emp_id',Auth::guard('employee')->user()->id)->count();
             $sale_activity=SaleActivity::where('emp_id',Auth::guard('employee')->user()->id)->count();
             $myticket=ticket::where('created_emp_id',$user->id)->count();
             $follow_ticket=ticket_follower::where('emp_id',$user->id)->count();
             $numberOfalltickets=$myticket+$follow_ticket;
             $group=Group::whereHas('employees', function ($query) use ($id) {
                 $query->where('employee_id', $id);
             })->count();
         }
          $items = [
              'saleactivity'=>$sale_activity,
              'requestation'=>$requestation,
              'customer'=>$contact,
              'assignment'=>$assignment,
              'meeting'=>$meeting,
              'my_groups' =>$group,
              'all_ticket'=>$numberOfalltickets,
              'transaction'=>$transaction??0,
              'total_income'=>$current_year_income[0]->total??0,
              'total_expense'=>$current_year_expense[0]->total??0,
              'first_term_income'=>$first_6month_income[0]->total??0,
              'first_term_expense'=>$first_6month_expense[0]->total??0,
              'first_term_profit'=>($first_6month_income[0]->total??0)-($first_6month_expense[0]->total??0),
              'second_term_income'=>$second_6month_income[0]->total??0,
              'second_term_expense'=>$second_6month_expense[0]->total??0,
              'second_term_profit'=>($second_6month_income[0]->total??0)-($second_6month_expense[0]->total??0),
              'current_month_income'=>$current_month_income[0]->total??0,
              'current_month_expense'=>$current_month_expense[0]->total??0,
              'current_month_profit'=>($current_month_income[0]->total??0)-($current_month_expense[0]->total??0),
              'profit'=>Auth::guard('employee')->user()->role->name=='CEO'||Auth::guard('employee')->user()->role->name=='Super Admin'?$current_year_income[0]->total??0-$current_year_expense[0]->total??0:0,
          ];
//dd($monthly_expense,$monthly_income,$profit);
          return view('index', compact('items','total_emp','monthly_income','monthly_expense','profit'));
    }
    public function agent_all_ticket(){
        $auth_user=Auth::guard('employee')->user();
        $all_tickets=[];
        $created_tickets=ticket::where("created_emp_id",$auth_user->id)->get();
        if(!$created_tickets->isEmpty()){
            foreach ($created_tickets as $ticket){
                array_push($all_tickets,$ticket);
            }
        }
        $agent_tickets=assign_ticket::with('ticket')->orWhere("agent_id",$auth_user->id)->orWhere("dept_id",$auth_user->department_id)->get();
        if(!$agent_tickets->isEmpty()){
            foreach ($agent_tickets as $agent_ticket) {
                array_push($all_tickets, $agent_ticket->ticket);

            }
        }
        return $all_tickets;
    }
    public function report_status(){
        $all_status=status::all();
//        dd($all_status);
        $statuses=[];
        $report_for_agent=$this->agent_all_ticket();
        for($i=0;$i<count($all_status);$i ++){
            if(Auth::guard('employee')->user()->role->name=="Agent"){
                $same_status=[];
                foreach ($report_for_agent as $ticket){
                    if($ticket->status==$all_status[$i]->id){
                        array_push($same_status,$ticket);
                    }
                }
                $statuses[$all_status[$i]->name]=count($same_status);
            }else{
                $ticket=ticket::with("ticket_status","ticket_priority")->where('status',$all_status[$i]->id)->get();
                $statuses[$all_status[$i]->name]=count($ticket);
            }
        }
        return $statuses;
    }
    public function report_with_percentage()
    {

        $ticket = $this->report_status();
//        dd($ticket);
        $all_percentage = [];
        $all_ticket =$ticket['New']+$ticket['Open']+$ticket['Complete']+$ticket['Pending']+$ticket['Overdue']+$ticket['Close']+$ticket['In Progress'];
        if ($all_ticket == 0) {
            $all_ticket = 1;
        }
        $all_percentage['New'] = round($ticket['New'] / $all_ticket * 100, 2);
        $all_percentage['Open'] = round($ticket['Open']/ $all_ticket * 100, 2);
        $all_percentage['In-progress'] = round($ticket['In Progress'] / $all_ticket * 100, 2);
        $all_percentage['Solve'] = round(($ticket['Complete'] + $ticket['Close']) / $all_ticket * 100, 2);
        $all_percentage['Pending'] = round($ticket['Pending'] / $all_ticket * 100, 2);
        $all_percentage['Overdue'] = round($ticket['Overdue'] / $all_ticket * 100, 2);
        return $all_percentage;

    }

}
