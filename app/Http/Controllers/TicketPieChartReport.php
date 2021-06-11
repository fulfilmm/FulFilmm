<?php

namespace App\Http\Controllers;

use App\Models\assign_ticket;
use App\Models\priority;
use App\Models\status;
use App\Models\ticket;
use Illuminate\Support\Facades\Auth;

class TicketPieChartReport extends Controller
{
    public function index(){
        $priority=$this->report_priority();
        $statuses=$this->report_status();
        return view('ticket.chartreport',compact('statuses','priority'));
    }
    public function report_priority(){
        $priorities=priority::all();
        $priority=[];
        $report_for_agent=$this->agent_all_ticket();
        for($j=0;$j<count($priorities);$j++){
            if(Auth::guard('employee')->user()->role->name=="Agent"){
                $same_priority=[];
                foreach ($report_for_agent as $ticket){
                    if($ticket->priority==$priorities[$j]->id && $ticket!=null){
                        array_push($same_priority,$ticket);
                    }
                }
                $priority[$priorities[$j]->priority]=count($same_priority);
            }else {
                $ticket_with_priority = ticket::with("ticket_status", "ticket_priority")->where('priority', $priorities[$j]->id)->get();
                $priority[$priorities[$j]->priority] = count($ticket_with_priority);
            }
        }
        return $priority;
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
//            dd($all_tickets);
            foreach ($assign_dept as $dept_ticket) {
                       array_push($all_tickets, $dept_ticket->ticket);
                   }
        }
        return $all_tickets;
    }
}
