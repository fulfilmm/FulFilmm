<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DealActivitySchedule;
use App\Models\Employee;
use App\Models\next_plan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index(Request $request)

    {

        if(isset($request->start_date)) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();
        }else{
            $start =null;
            $end = null;
        }
        $select_customer=$request->customer_id??null;
        $auth = Auth::guard('employee')->user();
        $customers=Customer::all();
        switch ($auth->role->name) {
            case "Super Admin":
//                if(isset($request->))
               if(isset($request->start_date)){
                   if($select_customer==null){
                       $schedules = DealActivitySchedule::whereBetween('from_date', [$start, $end])->get();
                       $next_plan = next_plan::with('employee','customer')->whereBetween("date_time", [$start, $end])->orderBy('id', 'desc')->get();
                   }else{
                       $schedules = DealActivitySchedule::whereBetween('from_date', [$start, $end])->get();
                       $next_plan = next_plan::with('employee','customer')->whereBetween("date_time", [$start, $end])->orderBy('id', 'desc')->where('contact_id',$select_customer)->get();
                   }

               }else{
                   if($select_customer==null){
                       $schedules = DealActivitySchedule::whereDate('from_date','>=',Carbon::today())->get();
                       $next_plan = next_plan::with('employee','customer')->whereDate("date_time",'>=',Carbon::today())->orderBy('date_time', 'desc')->get();
                   }else{
                       $schedules = DealActivitySchedule::whereDate('from_date','>=',Carbon::today())->get();
                       $next_plan = next_plan::with('employee','customer')
                           ->whereDate("date_time",'>=',Carbon::today())
                           ->orderBy('date_time', 'desc')
                           ->where('contact_id',$select_customer)
                           ->get();
                   }
               }
//                dd($schedules,$next_plan);
//                dd($start,$end);
                return view('Schedule.index',compact('schedules','next_plan','customers','start','end','select_customer'));
                break;
            case "CEO":
                if(isset($request->start_date)){
                    if($select_customer==null){
                        $schedules = DealActivitySchedule::whereBetween('from_date', [$start, $end])->get();
                        $next_plan = next_plan::with('employee','customer')->whereBetween("date_time", [$start, $end])->orderBy('id', 'desc')->get();
                    }else{
                        $schedules = DealActivitySchedule::whereBetween('from_date', [$start, $end])->get();
                        $next_plan = next_plan::with('employee','customer')->whereBetween("date_time", [$start, $end])->orderBy('id', 'desc')->where('contact_id',$select_customer)->get();
                    }
                }else{
                    if($select_customer==null){
                        $schedules = DealActivitySchedule::whereDate('from_date','>=',Carbon::today())->get();
                        $next_plan = next_plan::with('employee','customer')->whereDate("date_time",'>=',Carbon::today())->orderBy('date_time', 'desc')->get();
                    }else{
                        $schedules = DealActivitySchedule::whereDate('from_date','>=',Carbon::today())->get();
                        $next_plan = next_plan::with('employee','customer')
                            ->whereDate("date_time",'>=',Carbon::today())
                            ->orderBy('date_time', 'desc')
                            ->where('contact_id',$select_customer)
                            ->get();
                    }

                }
                return view('Schedule.index',compact('schedules','next_plan','customers','start','end'));
                break;
            case "General Manager":
                if(isset($request->start_date)){
                    if($select_customer==null){
                        $schedules = DealActivitySchedule::whereBetween('from_date', [$start, $end])->get();
                        $next_plan = next_plan::with('employee','customer')->whereBetween("date_time", [$start, $end])->orderBy('id', 'desc')->get();
                    }else{
                        $schedules = DealActivitySchedule::whereBetween('from_date', [$start, $end])->get();
                        $next_plan = next_plan::with('employee','customer')->whereBetween("date_time", [$start, $end])->orderBy('id', 'desc')->where('contact_id',$select_customer)->get();
                    }
                }else{
                    if($select_customer==null){
                        $schedules = DealActivitySchedule::whereDate('from_date','>=',Carbon::today())->get();
                        $next_plan = next_plan::with('employee','customer')->whereDate("date_time",'>=',Carbon::today())->orderBy('date_time', 'desc')->get();
                    }else{
                        $schedules = DealActivitySchedule::whereDate('from_date','>=',Carbon::today())->get();
                        $next_plan = next_plan::with('employee','customer')
                            ->whereDate("date_time",'>=',Carbon::today())
                            ->orderBy('date_time', 'desc')
                            ->where('contact_id',$select_customer)
                            ->get();
                    }
                }
                return view('Schedule.index',compact('schedules','next_plan','customers','start','end'));
                break;
            case "Customer Service Manager":
                $employees=Employee::where('department_id',$auth->department->id)->get();
                $schedules=[];
                $next_plan=[];
                foreach ($employees as $item) {
                    if(isset($request->start_date)){
                        if($select_customer==null){
                            $schedule = DealActivitySchedule::whereBetween('from_date', [$start, $end])->where('emp_id',$item->id)->get();
                            $next = next_plan::with('employee','customer')->where('emp_id',$item->id)->whereBetween("date_time", [$start, $end])->orderBy('id', 'desc')->get();
                        }else{
                            $schedule = DealActivitySchedule::whereBetween('from_date', [$start, $end])->where('emp_id',$item->id)->get();
                            $next = next_plan::with('employee','customer')->where('emp_id',$item->id)->whereBetween("date_time", [$start, $end])->orderBy('id', 'desc')->where('contact_id',$select_customer)->get();
                        }
                    }else{
                        if($select_customer==null){
                            $schedule = DealActivitySchedule::whereDate('from_date','>=',Carbon::today())->where('emp_id',$item->id)->get();
                            $next = next_plan::with('employee','customer')->where('emp_id',$item->id)->whereDate("date_time",'>=',Carbon::today())->orderBy('id', 'desc')->get();
                        }else{
                            $schedule = DealActivitySchedule::whereDate('from_date','>=',Carbon::today())->where('emp_id',$item->id)->get();
                            $next = next_plan::with('employee','customer')
                                ->where('emp_id',$item->id)
                                ->whereDate("date_time",'>=',Carbon::today())
                                ->orderBy('id', 'desc')
                                ->where('contact_id',$select_customer)
                                ->get();
                        }
                    }

                   foreach ($schedule as $sche){
                        array_push($schedules, $sche);
                    }
                    foreach ($next as $plan) {
                        array_push($next_plan, $plan);
                    }

                }
                return view('Schedule.index',compact('schedules','next_plan','customers','start','end','select_customer'));
                break;
            case "Stock Manager":
                $employees=Employee::where('department_id',$auth->department->id)->get();
                $schedules=[];
                $next_plan=[];
                foreach ($employees as $item) {
                    if(isset($request->start_date)){
                        if($select_customer==null){
                            $schedule = DealActivitySchedule::whereBetween('from_date', [$start, $end])->where('emp_id',$item->id)->get();
                            $next = next_plan::with('employee','customer')->where('emp_id',$item->id)->whereBetween("date_time", [$start, $end])->orderBy('id', 'desc')->get();
                        }else{
                            $schedule = DealActivitySchedule::whereBetween('from_date', [$start, $end])->where('emp_id',$item->id)->get();
                            $next = next_plan::with('employee','customer')->where('emp_id',$item->id)->whereBetween("date_time", [$start, $end])->orderBy('id', 'desc')->where('contact_id',$select_customer)->get();
                        }
                    }else{
                        if($select_customer==null){
                            $schedule = DealActivitySchedule::whereDate('from_date','>=',Carbon::today())->where('emp_id',$item->id)->get();
                            $next = next_plan::with('employee','customer')->where('emp_id',$item->id)->whereDate("date_time",'>=',Carbon::today())->orderBy('id', 'desc')->get();
                        }else{
                            $schedule = DealActivitySchedule::whereDate('from_date','>=',Carbon::today())->where('emp_id',$item->id)->get();
                            $next = next_plan::with('employee','customer')
                                ->where('emp_id',$item->id)
                                ->whereDate("date_time",'>=',Carbon::today())
                                ->orderBy('id', 'desc')
                                ->where('contact_id',$select_customer)
                                ->get();
                        }
                    }

                    foreach ($schedule as $sche){
                        array_push($schedules, $sche);
                    }
                    foreach ($next as $plan) {
                        array_push($next_plan, $plan);
                    }

                }
                return view('Schedule.index',compact('schedules','next_plan','customers','start','end','select_customer'));
                break;

            case "Finance Manager":
                $employees=Employee::where('department_id',$auth->department->id)->get();
                $schedules=[];
                $next_plan=[];
                foreach ($employees as $item) {
                    if(isset($request->start_date)){
                        if($select_customer==null){
                            $schedule = DealActivitySchedule::whereBetween('from_date', [$start, $end])->where('emp_id',$item->id)->get();
                            $next = next_plan::with('employee','customer')->where('emp_id',$item->id)->whereBetween("date_time", [$start, $end])->orderBy('id', 'desc')->get();
                        }else{
                            $schedule = DealActivitySchedule::whereBetween('from_date', [$start, $end])->where('emp_id',$item->id)->get();
                            $next = next_plan::with('employee','customer')->where('emp_id',$item->id)->whereBetween("date_time", [$start, $end])->orderBy('id', 'desc')->where('contact_id',$select_customer)->get();
                        }
                    }else{
                        if($select_customer==null){
                            $schedule = DealActivitySchedule::whereDate('from_date','>=',Carbon::today())->where('emp_id',$item->id)->get();
                            $next = next_plan::with('employee','customer')->where('emp_id',$item->id)->whereDate("date_time",'>=',Carbon::today())->orderBy('id', 'desc')->get();
                        }else{
                            $schedule = DealActivitySchedule::whereDate('from_date','>=',Carbon::today())->where('emp_id',$item->id)->get();
                            $next = next_plan::with('employee','customer')
                                ->where('emp_id',$item->id)
                                ->whereDate("date_time",'>=',Carbon::today())
                                ->orderBy('id', 'desc')
                                ->where('contact_id',$select_customer)
                                ->get();
                        }
                    }

                    foreach ($schedule as $sche){
                        array_push($schedules, $sche);
                    }
                    foreach ($next as $plan) {
                        array_push($next_plan, $plan);
                    }

                }
                return view('Schedule.index',compact('schedules','next_plan','customers','start','end','select_customer'));
                break;
            case "HR Manager":
                $employees=Employee::where('department_id',$auth->department->id)->get();
                $schedules=[];
                $next_plan=[];
                foreach ($employees as $item) {
                    if(isset($request->start_date)){
                        if($select_customer==null){
                            $schedule = DealActivitySchedule::whereBetween('from_date', [$start, $end])->where('emp_id',$item->id)->get();
                            $next = next_plan::with('employee','customer')->where('emp_id',$item->id)->whereBetween("date_time", [$start, $end])->orderBy('id', 'desc')->get();
                        }else{
                            $schedule = DealActivitySchedule::whereBetween('from_date', [$start, $end])->where('emp_id',$item->id)->get();
                            $next = next_plan::with('employee','customer')->where('emp_id',$item->id)->whereBetween("date_time", [$start, $end])->orderBy('id', 'desc')->where('contact_id',$select_customer)->get();
                        }
                    }else{
                        if($select_customer==null){
                            $schedule = DealActivitySchedule::whereDate('from_date','>=',Carbon::today())->where('emp_id',$item->id)->get();
                            $next = next_plan::with('employee','customer')->where('emp_id',$item->id)->whereDate("date_time",'>=',Carbon::today())->orderBy('id', 'desc')->get();
                        }else{
                            $schedule = DealActivitySchedule::whereDate('from_date','>=',Carbon::today())->where('emp_id',$item->id)->get();
                            $next = next_plan::with('employee','customer')
                                ->where('emp_id',$item->id)
                                ->whereDate("date_time",'>=',Carbon::today())
                                ->orderBy('id', 'desc')
                                ->where('contact_id',$select_customer)
                                ->get();
                        }
                    }

                    foreach ($schedule as $sche){
                        array_push($schedules, $sche);
                    }
                    foreach ($next as $plan) {
                        array_push($next_plan, $plan);
                    }

                }
                return view('Schedule.index',compact('schedules','next_plan','customers','start','end','select_customer'));
                break;
            case "Sales Manager":
                $employees=Employee::where('department_id',$auth->department->id)->get();
                $schedules=[];
                $next_plan=[];
                foreach ($employees as $item) {
                    if(isset($request->start_date)){
                        if($select_customer==null){
                            $schedule = DealActivitySchedule::whereBetween('from_date', [$start, $end])->where('emp_id',$item->id)->get();
                            $next = next_plan::with('employee','customer')->where('emp_id',$item->id)->whereBetween("date_time", [$start, $end])->orderBy('id', 'desc')->get();
                        }else{
                            $schedule = DealActivitySchedule::whereBetween('from_date', [$start, $end])->where('emp_id',$item->id)->get();
                            $next = next_plan::with('employee','customer')->where('emp_id',$item->id)->whereBetween("date_time", [$start, $end])->orderBy('id', 'desc')->where('contact_id',$select_customer)->get();
                        }
                    }else{
                        if($select_customer==null){
                            $schedule = DealActivitySchedule::whereDate('from_date','>=',Carbon::today())->where('emp_id',$item->id)->get();
                            $next = next_plan::with('employee','customer')->where('emp_id',$item->id)->whereDate("date_time",'>=',Carbon::today())->orderBy('id', 'desc')->get();
                        }else{
                            $schedule = DealActivitySchedule::whereDate('from_date','>=',Carbon::today())->where('emp_id',$item->id)->get();
                            $next = next_plan::with('employee','customer')
                                ->where('emp_id',$item->id)
                                ->whereDate("date_time",'>=',Carbon::today())
                                ->orderBy('id', 'desc')
                                ->where('contact_id',$select_customer)
                                ->get();
                        }
                    }

                    foreach ($schedule as $sche){
                        array_push($schedules, $sche);
                    }
                    foreach ($next as $plan) {
                        array_push($next_plan, $plan);
                    }

                }
                return view('Schedule.index',compact('schedules','next_plan','customers','start','end','select_customer'));
                break;
            case "Car Admin":
                $employees=Employee::where('department_id',$auth->department->id)->get();
                $schedules=[];
                $next_plan=[];
                foreach ($employees as $item) {
                    if(isset($request->start_date)){
                        if($select_customer==null){
                            $schedule = DealActivitySchedule::whereBetween('from_date', [$start, $end])->where('emp_id',$item->id)->get();
                            $next = next_plan::with('employee','customer')->where('emp_id',$item->id)->whereBetween("date_time", [$start, $end])->orderBy('id', 'desc')->get();
                        }else{
                            $schedule = DealActivitySchedule::whereBetween('from_date', [$start, $end])->where('emp_id',$item->id)->get();
                            $next = next_plan::with('employee','customer')->where('emp_id',$item->id)->whereBetween("date_time", [$start, $end])->orderBy('id', 'desc')->where('contact_id',$select_customer)->get();
                        }
                    }else{
                        if($select_customer==null){
                            $schedule = DealActivitySchedule::whereDate('from_date','>=',Carbon::today())->where('emp_id',$item->id)->get();
                            $next = next_plan::with('employee','customer')->where('emp_id',$item->id)->whereDate("date_time",'>=',Carbon::today())->orderBy('id', 'desc')->get();
                        }else{
                            $schedule = DealActivitySchedule::whereDate('from_date','>=',Carbon::today())->where('emp_id',$item->id)->get();
                            $next = next_plan::with('employee','customer')
                                ->where('emp_id',$item->id)
                                ->whereDate("date_time",'>=',Carbon::today())
                                ->orderBy('id', 'desc')
                                ->where('contact_id',$select_customer)
                                ->get();
                        }
                    }

                    foreach ($schedule as $sche){
                        array_push($schedules, $sche);
                    }
                    foreach ($next as $plan) {
                        array_push($next_plan, $plan);
                    }

                }
                return view('Schedule.index',compact('schedules','next_plan','customers','start','end','select_customer'));
                break;
            default:
                if(isset($request->start_date)) {
                    if($select_customer==null){
                        $schedules = DealActivitySchedule::whereBetween('from_date', [$start, $end])->where('emp_id', $auth->id)->get();
                        $next_plan = next_plan::with('employee', 'customer')->where('emp_id', $auth->id)->whereBetween("date_time", [$start, $end])->orderBy('id', 'desc')->get();
                    }else{
                        $schedules = DealActivitySchedule::whereBetween('from_date', [$start, $end])->where('emp_id', $auth->id)->get();
                        $next_plan = next_plan::with('employee', 'customer')
                            ->where('emp_id', $auth->id)
                            ->whereBetween("date_time", [$start, $end])
                            ->orderBy('id', 'desc')
                            ->where('contact_id',$select_customer)
                            ->get();
                    }
                }else{
                    if($select_customer==null){
                        $schedules = DealActivitySchedule::whereDate('from_date','>=',Carbon::today())->where('emp_id', $auth->id)->get();
                        $next_plan = next_plan::with('employee', 'customer')->where('emp_id', $auth->id)->whereDate("date_time",'>=',Carbon::today())->orderBy('id', 'desc')->get();
                    }else{
                        $schedules = DealActivitySchedule::whereDate('from_date','>=',Carbon::today())->where('emp_id', $auth->id)->get();
                        $next_plan = next_plan::with('employee', 'customer')
                            ->where('emp_id', $auth->id)
                            ->whereDate("date_time",'>=',Carbon::today())
                            ->orderBy('id', 'desc')
                            ->where('contact_id',$select_customer)
                            ->get();
                    }

                }
                return view('Schedule.index',compact('schedules','next_plan','customers','select_customer'));
        }
        }
    }
