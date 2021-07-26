<?php

namespace App\Http\Controllers;

use App\Models\assign_ticket;
use App\Models\case_type;
use App\Models\count_down;
use App\Models\countdown;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Employee;
use App\Models\priority;
use App\Models\product;
use App\Models\solved_time;
use App\Models\status;
use App\Models\ticket;
use App\Models\ticket_comments;
use App\Models\ticket_follower;
use App\Models\ticket_sender;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\TicketPieChartReport;
use function PHPUnit\Framework\isEmpty;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $auth_user=Auth::guard('employee')->user();
        $statuses=status::all();
        $depts=Department::all();
        $cases = case_type::all();
        $priorities = priority::all();
        $products=product::all();
        $clients=Customer::all();
        $all_emp=Employee::all();
        $last_ticket = ticket::orderBy('id', 'desc')->first();
        if (isset($last_ticket)) {
            // Sum 1 + last id
            $last_ticket->ticket_id++;
            $ticket_id = $last_ticket->ticket_id;
        } else {
            $ticket_id = "Ticket" . "-00001";
        }
        $assign_ticket=assign_ticket::with('agent','dept')->get();
        if ($auth_user->role->name=='Agent') {
            $all_tickets=$this->agent_all_ticket();
            $status_report=$this->report_status();
            $report_percentage=$this->report_with_percentage();
//            dd($all_tickets);
            return view('ticket.index',compact('all_tickets','assign_ticket','status_report','report_percentage','statuses','depts','ticket_id',"cases",'priorities','clients','all_emp','products'));
        }else{
            $all_tickets=ticket::with('ticket_status','ticket_priority')->get();
            $status_report=$this->report_status();
            $report_percentage=$this->report_with_percentage();
//            dd($all_tickets);

        }

        return view('ticket.index',compact('all_tickets','assign_ticket','statuses','ticket_id','cases','priorities','all_emp','depts','clients','products','status_report','report_percentage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses=status::all();
        $cases = case_type::all();
        $depts=Department::all();
        $priorities = priority::all();
        $products=product::all();
        $all_emp=Employee::all();
        $last_ticket = ticket::orderBy('id', 'desc')->first();
        if (isset($last_ticket)) {
            // Sum 1 + last id
            $last_ticket->ticket_id++;
            $ticket_id = $last_ticket->ticket_id;
        } else {
            $ticket_id = "Ticket" . "-00001";
        }
        return view('ticket.ticket_for_guest',compact('statuses','ticket_id','cases','priorities','all_emp','depts','products'));

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $this->validate($request, [
//            'files.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//            'title' => 'required',
//            'message' => 'required',
//
//        ]);
//        dd($request->all());
        //add customer info store
        $this->add_sender_info($request->all());
        $last_sender=ticket_sender::orderBy('id', 'desc')->first();
        $status=status::where('name',"New")->first();
        $ticket = new ticket();
        $ticket->title = $request->subject;
        if(Auth::guard('employee')->check()){
            $ticket->created_emp_id=Auth::guard()->user()->id;
        }
        $ticket->message = $request->description;
        $ticket->case_type = $request->case;
        $ticket->ticket_id = $request->ticket_id;
        $ticket->status = $status->id;
        $ticket->product_id = $request->product_id;
        $ticket->customer_id = $last_sender->id;
        $ticket->priority = $request->priority;
        if ($request->hasfile('files')) {
            foreach ($request->file('files') as $image) {
                $name = $image->getClientOriginalName();
                $image->move(public_path() . '/ticket_picture/', $name,);
                $data[] = $name;
            }

        }
        $ticket->photo =json_encode($data);
        if ($request->hasfile('attachment')) {
            $attach=$request->file('attachment');
            $attach_name = $attach->getClientOriginalName();
            $attach->move(public_path() . '/ticket_attach/', $attach_name);
            $ticket->attachment=$attach_name;
        }
        $ticket->save();
        //assign_ticket
        $this->assign_ticket($request->assign_id,$ticket->id,$request->assignType);
        //add follower
        $last_ticket=ticket::orderBy('id','desc')->first();
        $this->add_ticket_follower($request->follower,$last_ticket->id);

        return redirect()->back()->with('Success', __('alert.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $assign_ticket=assign_ticket::with("agent","dept")->where("ticket_id",$id)->first();
        $ticket=ticket::with("ticket_status",'ticket_priority','sender_info','created_by')->where('id',$id)->first();
        $photos = json_decode($ticket->photo);
        $comment=ticket_comments::with("comment_user")->where("ticket_id",$id)->get();
        $ticket_followers=ticket_follower::with('ticket_followed')->where("ticket_id",$id)->get();
        $all_emp=Employee::all();
        $unassign_emp=[];
        foreach ($all_emp as $emp){
            if($emp->id!=$assign_ticket->agent_id){
                array_push($unassign_emp,$emp);
            }
        }
        $unfollowed_emps=[];
        $depts=[];
        $all_depts =Department::all();
        foreach ($all_depts as $dept){
            if($dept->id!=$assign_ticket->dept_id){
                array_push($depts,$dept);
            }
        }
        foreach ($all_emp as $emp){
            $is_follower=ticket_follower::where("ticket_id",$id)->where("emp_id",$emp->id)->first();
            if($is_follower==null){
                array_push($unfollowed_emps,$emp);
            }
        }
        $countdown = countdown::where("ticket_id", $id)->first();
        if ($countdown == null) {
            $end = Carbon::now();
        } else {
            $end = Carbon::create($countdown->endtime);
        }
//        dd($unfollowed_emps);
        return view('ticket.ticket-view',compact('ticket','photos','assign_ticket','comment','ticket_followers','all_emp','unfollowed_emps','all_emp','depts','unassign_emp','end'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
    public function postcomment(Request $request)
    {
        $comments = new ticket_comments();
        $comments->ticket_id = $request->ticket_id;
        $comments->user_id =Auth::guard('employee')->user()->id;
        $comments->comment = $request->comment;
        $comments->save();
        return redirect()->back();
    }
    public function status_change(Request  $request,$id){
//        dd($request->all());
        $change_ticket_status=ticket::where('id',$id)->first();
        $change_ticket_status->status=$request->status_id;
        $change_ticket_status->update();
        return redirect()->back();
    }
    public function add_ticket_follower($follower,$ticket_id){
        for ($i = 0; $i < count($follower); $i++) {
            $ticket_follower = new ticket_follower();
            $ticket_follower->ticket_id =$ticket_id;
            $ticket_follower->emp_id = $follower[$i];
            $ticket_follower->save();

        }
    }
    public function add_sender_info($data){

        if(Auth::guard('employee')->check()){
            $sender_info =ticket_sender::where("customer_id",$data['client'])->first();
        }else{
            $sender_info =ticket_sender::where("phone",$data['client_phone'])->first();
        }
        if ($sender_info == null) {
            $user_info = new ticket_sender();
            $existing_customer=Customer::where('id',$data['client'])->first();
            if($existing_customer==null){
                $user_info->name=$data['client_name'];
                $user_info->phone=$data['client_phone'];
            }else{
                $user_info->name=$existing_customer->name;
                $user_info->phone=$existing_customer->phone;
                $user_info->customer_id=$existing_customer->id;
            }
            $user_info->save();
        }
    }
    public function assign_ticket($assigned_id,$ticket_id,$type){
        $assign_ticket = new assign_ticket();
        if ($type == "agent") {
            $assign_ticket->agent_id = $assigned_id;
            $assign_ticket->ticket_id = $ticket_id;
            $assign_ticket->type_of_assign = 0;
        }else
        {
            $assign_ticket->dept_id = $assigned_id;
            $assign_ticket->ticket_id =$ticket_id;
            $assign_ticket->type_of_assign = 1;
        }
        $assign_ticket->save();
        $this->countdown($ticket_id,$assigned_id);
    }
    public function add_more_follower(Request $request){
        $this->add_ticket_follower($request->follower,$request->ticket_id);
        return redirect()->back()->with('Success', __('alert.create_success'));
    }
    public function reassign(Request $request){
//        dd($request->all());
        $assign_ticket=assign_ticket::where("ticket_id",$request->ticket_id)->first();
//        dd($assign_ticket);
        if ($request->assignType == "agent") {
            $assign_ticket->agent_id = $request->assign_id;
            $assign_ticket->type_of_assign = 0;
            $assign_ticket->dept_id=null;
        }else{
            $assign_ticket->dept_id = $request->assign_id;
            $assign_ticket->type_of_assign = 1;
            $assign_ticket->agent_id=null;
        }
        $assign_ticket->update();
        return redirect()->back();
    }
    public function countdown($ticket_id,$agent_id){
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
    public function report_with_percentage(){

        $ticket=$this->report_status();
        $all_percentage=[];
        $all_ticket=count(ticket::all());
        if($all_ticket==0){
            $all_ticket=1;
        }
        $all_percentage['New']=round($ticket['New']/$all_ticket*100,2);
        $all_percentage['Open']=round($ticket['Open']/$all_ticket*100,2);
        $all_percentage['Solve']=round($ticket['Complete']+$ticket['Close']/$all_ticket*100,2);
        $all_percentage['Pending']=round($ticket['Pending']/$all_ticket*100,2);
        return $all_percentage;

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
        $agent_tickets=assign_ticket::with('ticket')->where("agent_id",$auth_user->id)->get();
        if(!$agent_tickets->isEmpty()){
            foreach ($agent_tickets as $agent_ticket) {
                array_push($all_tickets, $agent_ticket->ticket);
            }
        }
        $assign_dept=assign_ticket::with("ticket")->where("dept_id",$auth_user->department_id)->get();
        if(!$assign_dept->isEmpty()){
            foreach ($assign_dept as $dept_ticket) {
                array_push($all_tickets, $dept_ticket->ticket);
            }
        }
        return $all_tickets;
    }

}
