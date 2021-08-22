<?php

namespace App\Http\Controllers;

use App\Models\assign_ticket;
use App\Models\case_type;
use App\Models\Company;
use App\Models\countdown;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Group;
use App\Models\MainCompany;
use App\Models\priority;
use App\Models\product;
use App\Models\solved_time;
use App\Models\status;
use App\Models\ticket;
use App\Models\ticket_comments;
use App\Models\ticket_follower;
use App\Models\ticket_sender;
use App\Models\ticketrequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class TicketController extends Controller
{
    protected $status_color = ['New' => '#49d1b6', 'Open' => '#e84351', 'Close' => '#4e5450', 'Pending' => '#f0ed4f', 'In Progress' => '#2333e8', 'Complete' => '#18b820', 'Overdue' => '#000'];

//query select
    public function __construct()
    {
        $count_down = countdown::where('endtime', '<', Carbon::now())->get();
        if (!$count_down->isEmpty()) {
            foreach ($count_down as $over_due) {
                $ticket = ticket::with('ticket_status')->where('id', $over_due->ticket_id)->first();
                if ($ticket->ticket_status->name != 'Complete' && $ticket->ticket_status->name != 'Close') {
                    $over_duestatus = status::where('name', 'Overdue')->first();
                    $ticket->status = $over_duestatus->id;
                    $ticket->update();
                }
            }
        }
    }

    public function data_all()
    {
        $depts = Department::all();
        $cases = case_type::all();
        $priorities = priority::all();
        $products = product::all();
        $clients = Customer::all();
        $all_emp = Employee::all();
        return ['depts' => $depts, 'case' => $cases, 'priority' => $priorities, 'product' => $products, 'client' => $clients, 'all_emp' => $all_emp];
    }
//end query select
    //index start
    public function index()
    {

        $status_color = $this->status_color; //for status color show
        $auth_user = Auth::guard('employee')->user();
        $statuses = status::all()->pluck('name', 'id')->all();
        $depts = Department::all()->pluck('name', 'id')->all();
        $priorities = priority::all()->pluck('priority', 'id')->all();
        $all_emp = Employee::all()->pluck('name', 'id')->all();
        $assign_ticket = assign_ticket::with('agent', 'dept')->get();
        $status_report = $this->report_status();
        $report_percentage = $this->report_with_percentage();
        if ($auth_user->role->name == 'Agent') {
            $all_tickets = $this->agent_all_ticket();

//            dd($all_tickets);
        } elseif ($auth_user->role->name == 'Employee') {
            $all_tickets = ticket::with('ticket_status', 'ticket_priority')->where("created_emp_id", $auth_user->id)->paginate(10);
        } else {
            $all_tickets = ticket::with('ticket_status', 'ticket_priority', 'created_by')->paginate(10);

        }

        return view('ticket.index', compact('status_color', 'all_tickets', 'assign_ticket', 'statuses', 'priorities', 'all_emp', 'depts', 'status_report', 'report_percentage'));
    }

    //index end


    //ticket create
    public function create()
    {
        $parent_companies = Company::all()->pluck('name', 'id')->all();
        $companies = Company::all()->pluck('name', 'id')->all();
        $data = $this->data_all();
        $prefix = MainCompany::where('ismaincompany', true)->pluck('ticket_prefix', 'id')->first();
        $last_ticket = ticket::orderBy('id', 'desc')->first();
        if (isset($last_ticket)) {
            // Sum 1 + last id
            $ischange=$last_ticket->ticket_id;
            $ischange=explode("-", $ischange);
            if($ischange[0]==$prefix){
                $last_ticket->ticket_id++;
                $ticket_id = $last_ticket->ticket_id;
            }else{
                $arr=[$prefix,$ischange[1]];
                $pre=implode('-',$arr);
                $pre ++;
                $ticket_id=$pre;
            }

        } else {
            $ticket_id = ($prefix ?: 'Ticket') . "-00001";
        }
        $group = Group::all()->pluck('name', 'id')->all();

        return view('ticket.create', compact('ticket_id', 'data', 'companies', 'parent_companies', 'group'));
    }

    //create end "code review finish"


    public function followed_ticket()
    {
        $status_color = $this->status_color;
        $statuses = status::all();
        $data = $this->data_all();
        $assign_ticket = assign_ticket::with('agent', 'dept')->get();
        $followed_tickets = ticket_follower::with('ticket')->where("emp_id", Auth::guard('employee')->user()->id)->get();
        $last_ticket = ticket::orderBy('id', 'desc')->first();
        if (isset($last_ticket)) {
            // Sum 1 + last id
            $last_ticket->ticket_id++;
            $ticket_id = $last_ticket->ticket_id;
        } else {
            $ticket_id = "Ticket" . "-00001";
        }
        $all_tickets = [];
        foreach ($followed_tickets as $follow_ticket) {
            array_push($all_tickets, $follow_ticket->ticket);
        }
        return view('ticket.followed_ticket', compact('status_color', 'assign_ticket', 'all_tickets', 'data', 'statuses', 'ticket_id',));
    }

    public function store(Request $request)
    {
//        dd($request->all());
        try {
            $this->validate($request, [
                'files.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'attachment' => 'mimes:pdf,xlsx,doc,docx,jpg,jpeg,ppt,bip',
                'subject' => 'required',
                'assignType' => 'required',
                'description' => 'required',
                'client_name' => $request->has('client_name') ? 'required' : '',
                'client_phone' => $request->has('client_phone') ? 'required' : ''

            ]);
        } catch (ValidationException $e) {
            return redirect()->route('tickets.create')->with('error', $e->getMessage());
        }

        //add customer info store
        $this->add_sender_info($request->all());
        $last_sender = ticket_sender::orderBy('id', 'desc')->first();
        $status = status::where('name', "New")->first();
        $ticket = new ticket();
        $ticket->title = $request->subject;
        if (Auth::guard('employee')->check()) {
            $ticket->created_emp_id = Auth::guard()->user()->id;
        }
        $ticket->message = $request->description;
        $ticket->case_type = $request->case;
        $ticket->ticket_id = $request->ticket_id;
        $ticket->status = $status->id;
        $ticket->product_id = $request->product_id;
        $ticket->customer_id = $last_sender->id;
        $ticket->source = $request->source;
        $ticket->tag = $request->tag;
        $ticket->isassign = $request->assignType == "item0" ? 0 : 1;
        $ticket->priority = $request->priority;
        if ($request->hasfile('files')) {
            foreach ($request->file('files') as $image) {
                $name = $image->getClientOriginalName();
                $image->move(public_path() . '/ticket_picture/', $name,);
                $data[] = $name;
            }
            $ticket->photo = json_encode($data);
        }

        if ($request->hasfile('attachment')) {
            $attach = $request->file('attachment');
            $attach_name = $attach->getClientOriginalName();
            $attach->move(public_path() . '/ticket_attach/', $attach_name);
            $ticket->attachment = $attach_name;
        }
        $ticket->save();
        if($request->complain_id!=null){
            $exterrequest=ticketrequest::where('id',$request->complain_id)->first();
            $exterrequest->is_open=1;
            $exterrequest->update();
        }

        //assign_ticket
        if ($request->assignType != 'item0') {
            $this->assign_ticket($request->assign_id, $ticket->id, $request->assignType);
        }

        //add follower
        $last_ticket = ticket::orderBy('id', 'desc')->first();
        if ($request->follower != null) {
            $this->add_ticket_follower($request->follower, $last_ticket->id);
        }

        return redirect()->route('tickets.index')->with('Success', __('alert.create_success'));
    }

    public function show($id)
    {
        $statuses = status::all()->pluck('name', 'id')->all();//1

        $assign_ticket = assign_ticket::where("ticket_id", $id)->first();//2

        $ticket = ticket::with("ticket_status", 'ticket_priority', 'sender_info', 'created_by')->where('id', $id)->first();//3
        $photos = json_decode($ticket->photo);
        $comment = ticket_comments::with("comment_user")->where("ticket_id", $id)->get();//4
        $ticket_followers = ticket_follower::with('ticket_followed')->where("ticket_id", $id)->get();//5
        $all_emp = Employee::all();
        $depts = Department::all();
        $priorities=priority::all();
        $countdown = countdown::where("ticket_id", $id)->first();
        if ($countdown == null) {
            $end = Carbon::now();
        } else {
            $end = Carbon::create($countdown->endtime);
        }
        $status_color = $this->status_color;
//        dd($unfollowed_emps);
        return view('ticket.ticket-view', compact('status_color', 'ticket', 'photos', 'assign_ticket', 'comment', 'ticket_followers', 'all_emp', 'depts', 'end', 'statuses','priorities'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $delete_ticket = ticket::where('id', $id)->first();
        $delete_ticket->delete();
        return redirect()->route('tickets.index')->with('success', __('alert.delete_success'));
    }

    public function postcomment(Request $request)
    {
//        dd($request->all());
        $comments = new ticket_comments();
        $comments->ticket_id = $request->ticket_id;
        $comments->user_id = Auth::guard('employee')->user()->id;
        $comments->comment = $request->comment;
        $doc = $request->attach_file;
        if ($doc != null) {
            $name = $doc->getClientOriginalName();
            $request->attach_file->move(public_path() . '/ticket_attach/', $name);
            $comments->document_file = $name;
        }
        $comments->save();
        return redirect()->back();
    }
    public function cmt_delete($id){
        $cmt=ticket_comments::where('id',$id)->first();
        $cmt->delete();
        return redirect()->back()->with('success','Comment Deleted');
    }
    public function status_change(Request $request, $id)
    {
//        dd($request->all());
        $change_ticket_status = ticket::where('id', $id)->first();
        $change_ticket_status->status = $request->status_id;
        $change_ticket_status->update();
        return response()->json([
            'success'=>'Change Success'
        ]);
    }
    public function priority_change(Request $request,$id){
        $ticket=ticket::where('id',$id)->first();
        if($ticket->isassign==0){
            $ticket->priority=$request->priority_id;
            $ticket->update();
        }
        return response()->json([
           'success'=>'Priority Change Success!'
        ]);
    }

    public function add_ticket_follower($follower, $ticket_id)
    {
        for ($i = 0; $i < count($follower); $i++) {
            $ishas = ticket_follower::where('emp_id', $follower[$i])->where('ticket_id', $ticket_id)->first();
            if ($ishas == null) {
                $ticket_follower = new ticket_follower();
                $ticket_follower->ticket_id = $ticket_id;
                $ticket_follower->emp_id = $follower[$i];
                $ticket_follower->save();
                $emp=Employee::where('id',$follower[$i])->first();
                $ticket=ticket::where('id',$ticket_id)->first();
                $this->mailnoti($emp->email,$emp->name, 'You are added  as a follower in ', $ticket->ticket_id,$ticket->id);
            }



        }
    }

    public function add_sender_info($data)
    {

        if (Auth::guard('employee')->check()) {
            $sender_info = ticket_sender::where("customer_id", $data['client'])->first();
        } else {
            $sender_info = ticket_sender::where("phone", $data['client_phone'])->first();
        }
        if ($sender_info == null) {
            $user_info = new ticket_sender();
            $existing_customer = Customer::where('id', $data['client'])->first();
            if ($existing_customer == null) {
                $user_info->name = $data['client_name'];
                $user_info->phone = $data['client_phone'];
            } else {
                $user_info->name = $existing_customer->name;
                $user_info->phone = $existing_customer->phone;
                $user_info->customer_id = $existing_customer->id;
            }
            $user_info->save();
        }
    }

    public function assignee(Request $request)
    {
        $this->assign_ticket($request->assign_id, $request->ticket_id, $request->assignType);
        return redirect()->back()->with('success', 'Success assign ticket');
    }

    public function assign_ticket($assigned_id, $ticket_id, $type)
    {
        $is_assign= assign_ticket::where("ticket_id", $ticket_id)->first();

       if($is_assign==null) {
           $assign_ticket = new assign_ticket();
           if ($type == "agent") {
               $assign_ticket->agent_id = $assigned_id;
               $assign_ticket->ticket_id = $ticket_id;

           } elseif ($type == 'dept') {
               $assign_ticket->dept_id = $assigned_id;
               $assign_ticket->ticket_id = $ticket_id;

           } elseif ($type == 'group') {
               $assign_ticket->group_id = $assigned_id;
               $assign_ticket->ticket_id = $ticket_id;
           }
           $assign_ticket->type_of_assign = $type;
           $assign_ticket->save();

           if ($type == 'agent') {
               $emp = Employee::where('id', $assigned_id)->first();
               $this->mailnoti($emp->email,$emp->name, 'You are Aassigned', $assign_ticket->ticket->ticket_id, $ticket_id);
           } elseif ($type == 'dept') {
               $employee = Employee::where('department_id', $assigned_id)->get();
               $email = [];
               foreach ($employee as $emp) {
                   array_push($email, $emp->email);
               }
               $this->mailnoti($email, 'Employee of ' . $employee[0]->department->name, 'Your department are Aassigned ', $assign_ticket->ticket->ticket_id, $ticket_id);
           }

           $ticket_status = ticket::where('id', $ticket_id)->first();
           $ticket_status->isassign = 1;
           $ticket_status->update();
           $this->countdown($ticket_id, $assigned_id);
       }else{
        return redirect()->back()->with('error','It has been assigned');
       }
    }

    public function add_more_follower(Request $request)
    {

        $this->add_ticket_follower($request->follower, $request->ticket_id);
        return redirect()->back()->with('Success', __('alert.create_success'));
    }

    public function reassign(Request $request)
    {
//        dd($request->all());
        $assign_ticket = assign_ticket::with('ticket')->where("ticket_id", $request->ticket_id)->first();
        if ($request->assignType == "agent") {
            $assign_ticket->agent_id = $request->assign_id;
            $assign_ticket->type_of_assign = $request->assignType;
            $assign_ticket->dept_id = null;

        } else {
            $assign_ticket->dept_id = $request->assign_id;
            $assign_ticket->type_of_assign = $request->assignType;
            $assign_ticket->agent_id = null;
        }

        $assign_ticket->update();
        if($request->assignType=='agent'){
            $emp = Employee::where('id', $request->assign_id)->first();
            $this->mailnoti($emp->email,$emp->name, 'You are reaassigned', $assign_ticket->ticket->ticket_id,$assign_ticket->ticket->id);
        }elseif($request->assignType=='dept'){
            $employee=Employee::with('department')->where('department_id',$request->assign_id)->get();
           $email=[];
            foreach ($employee as $emp){
                array_push($email,$emp->email);
            }

            $this->mailnoti($email,'Employee of '.$employee[0]->department->name, 'Your department are reaassigned ', $assign_ticket->ticket->ticket_id,$assign_ticket->ticket->id);
        }
        return redirect()->back();
    }

    public function countdown($ticket_id, $agent_id)
    {
        $ticket_info = ticket::with("ticket_priority")->where('id', $ticket_id)->firstOrFail();
        $countdown = countdown::where("ticket_id", $ticket_id)->first();
        if ($countdown == null) {
            $countdownCreate = new countdown();
            $countdownCreate->ticket_id = $ticket_id;
            $countdownCreate->endtime = \Carbon\Carbon::now("Asia/Yangon")->addHour($ticket_info->ticket_priority->hours)->addMinutes($ticket_info->ticket_priority->minutes)->addSeconds($ticket_info->ticket_priority->seconds);
            $countdownCreate->save();
            $solveTime = new solved_time();
            $solveTime->ticket_id = $ticket_info->id;
            $solveTime->startedTime = Carbon::now();
            $solveTime->agent_id = $agent_id;
            $solveTime->priority = $ticket_info->priority;
            $solveTime->save();
        }
    }

    //for ticket report
    public function report_status()
    {
        $all_status = status::all();
//        dd($all_status);
        $statuses = [];
        $report_for_agent = $this->agent_all_ticket();
        for ($i = 0; $i < count($all_status); $i++) {
            if (Auth::guard('employee')->user()->role->name == "Agent") {
                $same_status = [];
                foreach ($report_for_agent as $ticket) {
                    if ($ticket->status == $all_status[$i]->id) {
                        array_push($same_status, $ticket);
                    }
                }
                $statuses[$all_status[$i]->name] = count($same_status);
            } elseif (Auth::guard('employee')->user()->role->name == 'Employee') {
                $ticket = ticket::with("ticket_status", "ticket_priority")->where('status', $all_status[$i]->id)->where('created_emp_id', Auth::guard('employee')->user()->id)->get();
                $statuses[$all_status[$i]->name] = count($ticket);
            } else {
                $ticket = ticket::with("ticket_status", "ticket_priority")->where('status', $all_status[$i]->id)->get();
                $statuses[$all_status[$i]->name] = count($ticket);
            }
        }
        return $statuses;
    }

    public function report_with_percentage()
    {

        $ticket = $this->report_status();
//        dd($ticket);
        $all_percentage = [];
        $all_ticket = $ticket['New'] + $ticket['Open'] + $ticket['Complete'] + $ticket['Pending'] + $ticket['Overdue'] + $ticket['Close'] + $ticket['In Progress'];
        if ($all_ticket == 0) {
            $all_ticket = 1;
        }
        $all_percentage['New'] = round($ticket['New'] / $all_ticket * 100, 2);
        $all_percentage['Open'] = round(($ticket['Open'] + $ticket['In Progress'] )/ $all_ticket * 100, 2);
        $all_percentage['Solve'] = round(($ticket['Complete'] + $ticket['Close']) / $all_ticket * 100, 2);
        $all_percentage['Pending'] = round($ticket['Pending'] / $all_ticket * 100, 2);
        $all_percentage['Overdue'] = round($ticket['Overdue'] / $all_ticket * 100, 2);
        return $all_percentage;

    }


    //All ticket by relative person
    public function agent_all_ticket()
    {
        $auth_user = Auth::guard('employee')->user();
        $all_tickets = [];
        $created_tickets = ticket::where("created_emp_id", $auth_user->id)->get();
        if (!$created_tickets->isEmpty()) {
            foreach ($created_tickets as $ticket) {
                array_push($all_tickets, $ticket);
            }
        }
        if ($auth_user->role->name == 'Agent') {
            $agent_tickets = assign_ticket::with('ticket')->where("agent_id", $auth_user->id)->get();
            if (!$agent_tickets->isEmpty()) {
                foreach ($agent_tickets as $agent_ticket) {
                    array_push($all_tickets, $agent_ticket->ticket);
                }
            }
            $assign_dept = assign_ticket::with("ticket")->where("dept_id", $auth_user->department_id)->get();
            if (!$assign_dept->isEmpty()) {
                foreach ($assign_dept as $dept_ticket) {
                    array_push($all_tickets, $dept_ticket->ticket);
                }
            }
        } elseif ($auth_user->role->name == 'Employee') {
            $follow_ticket = ticket_follower::with('ticket')->where('emp_id', $auth_user->id)->get();
            foreach ($follow_ticket as $f_ticket) {
                array_push($all_tickets, $f_ticket->ticket);
            }
        }
        return $all_tickets;
    }

    public function mailnoti($email,$name, $type, $id,$ticket_id)
    {
        $address=$email;
        $company = MainCompany::where('ismaincompany', 1)->first();
        $details = [

            'subject' => $company->name."Ticket notification.",
            'type' => $type,
            'name' => $name,
            'id' => $id,
            'ticket_id'=>$ticket_id,
            'from' => Auth::guard('employee')->user()->email,
            'from_name' => Auth::guard('employee')->user()->name,
            'company' => $company->name,

        ];
        Mail::send('ticket.mailnoti', $details, function ($message) use ($details,$address) {
            $message->from($details['from'], $details['company']);
          if(is_array($address)){
              dd('true');
              foreach ($address as $key=>$val){
                  $message->to($val);
              }
          }else{
              $message->to($address);
          }

            $message->subject($details['subject']);
        });
    }
}
