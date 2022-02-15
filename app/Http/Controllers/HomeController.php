<?php

namespace App\Http\Controllers;


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
use App\Notifications\AlertNotification;
use Illuminate\Support\Facades\Auth;
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
          return view('index', compact('numberOfalltickets','agents','depts','assign_ticket','status','status_report','report_percentage','count_down',));
      }else{

          $meeting=Meetingmember::with('meeting')->where('member_id',Auth::guard('employee')->user()->id)->count();
//          dd($meeting);
          $assignment=MinutesAssign::where('emp_id',Auth::guard('employee')->user()->id)->count();
          $user=Auth::guard('employee')->user();
          $follow_ticket=ticket_follower::where('emp_id',$user->id)->count();
          $requestation=Approvalrequest::where('emp_id',Auth::guard('employee')->user()->id)->count();
         ;
          $contact=Customer::count();
         if($user->role->name=='Agent'){
             $sale_activity=SaleActivity::where('emp_id',Auth::guard('employee')->user()->id)->count();
             $numberOfalltickets=count($this->agent_all_ticket())+$follow_ticket;
         }elseif ($user->role->name=='Super Admin'||$user->role->name=='CEO'||$user->role->name=='Manager'){
             $sale_activity=SaleActivity::where('report_to',Auth::guard('employee')->user()->id)->count();
             $numberOfalltickets=ticket::all()->count();
         }else{
             $sale_activity=SaleActivity::where('emp_id',Auth::guard('employee')->user()->id)->count();
             $myticket=ticket::where('created_emp_id',$user->id)->count();
             $follow_ticket=ticket_follower::where('emp_id',$user->id)->count();
             $numberOfalltickets=$myticket+$follow_ticket;
         }
          $id = Auth::id();
            $total_emp=Employee::count();
          $items = [
              'saleactivity'=>$sale_activity,
              'requestation'=>$requestation,
              'customer'=>$contact,
              'assignment'=>$assignment,
              'meeting'=>$meeting,
              'my_groups' => Group::whereHas('employees', function ($query) use ($id) {
                  $query->where('employee_id', $id);
              })->count(),
              'all_ticket'=>$numberOfalltickets,
          ];

          return view('index', compact('items','total_emp'));
      }
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
        $all_percentage['Open'] = round($ticket['Open']+$ticket['In Progress'] / $all_ticket * 100, 2);
        $all_percentage['Solve'] = round(($ticket['Complete'] + $ticket['Close']) / $all_ticket * 100, 2);
        $all_percentage['Pending'] = round($ticket['Pending'] / $all_ticket * 100, 2);
        $all_percentage['Overdue'] = round($ticket['Overdue'] / $all_ticket * 100, 2);
        return $all_percentage;

    }

}
