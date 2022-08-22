<?php

namespace App\Http\Controllers;

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
        $start = Carbon::parse($request->start_date)->startOfDay();
        $end = Carbon::parse($request->end_date)->endOfDay();
        $auth = Auth::guard('employee')->user();
        switch ($auth->role->name) {
            case "Super Admin":
                $schedules = DealActivitySchedule::whereBetween('from_date', [$start, $end])->get();
                $next_plan = next_plan::with('employee','customer')->orWhereBetween("date_time", [$start, $end])->orWhereBetween('alert_date',[$start,$end])->orderBy('id', 'desc')->get();
//                dd($schedules,$next_plan);
                return view('Schedule.index',compact('schedules','next_plan'));
                break;
            case "CEO":
                $schedules = DealActivitySchedule::whereBetween('from_date', [$start, $end])->get();
                $next_plan = next_plan::with('employee','customer')->whereBetween("date_time", [$start, $end])->orderBy('id', 'desc')->get();
                return view('Schedule.index',compact('schedules','next_plan'));
                break;
            case "General Manager":
                $schedules = DealActivitySchedule::whereBetween('from_date', [$start, $end])->get();
                $next_plan = next_plan::with('employee','customer')->whereBetween("date_time", [$start, $end])->orderBy('id', 'desc')->get();
                return view('Schedule.index',compact('schedules','next_plan'));
                break;
            case "Customer Service Manager":
                $employees=Employee::where('department_id',$auth->department->id)->get();
                $schedules=[];
                $next_plan=[];
                foreach ($employees as $item) {
                    $schedule = DealActivitySchedule::whereBetween('from_date', [$start, $end])->where('emp_id',$item->id)->get();
                    $next = next_plan::with('employee','customer')->where('emp_id',$item->id)->whereBetween("date_time", [$start, $end])->orderBy('id', 'desc')->get();
                   foreach ($schedule as $sche){
                        array_push($schedules, $sche);
                    }
                    foreach ($next as $plan) {
                        array_push($next_plan, $plan);
                    }

                }
                return view('Schedule.index',compact('schedules','next_plan'));
                break;
            case "Stock Manager":
                $employees=Employee::where('department_id',$auth->department->id)->get();
                $schedules=[];
                $next_plan=[];
                foreach ($employees as $item) {
                    $schedule = DealActivitySchedule::whereBetween('from_date', [$start, $end])->where('emp_id',$item->id)->get();
                    $next = next_plan::with('employee','customer')->where('emp_id',$item->id)->whereBetween("date_time", [$start, $end])->orderBy('id', 'desc')->get();
                    foreach ($schedule as $sche){
                        array_push($schedules, $sche);
                    }
                    foreach ($next as $plan) {
                        array_push($next_plan, $plan);
                    }

                }
                return view('Schedule.index',compact('schedules','next_plan'));
                break;

            case "Finance Manager":
                $employees=Employee::where('department_id',$auth->department->id)->get();
                $schedules=[];
                $next_plan=[];
                foreach ($employees as $item) {
                    $schedule = DealActivitySchedule::whereBetween('from_date', [$start, $end])->where('emp_id',$item->id)->get();
                    $next = next_plan::with('employee','customer')->where('emp_id',$item->id)->whereBetween("date_time", [$start, $end])->orderBy('id', 'desc')->get();
                    foreach ($schedule as $sche){
                        array_push($schedules, $sche);
                    }
                    foreach ($next as $plan) {
                        array_push($next_plan, $plan);
                    }

                }
                return view('Schedule.index',compact('schedules','next_plan'));
                break;
            case "HR Manager":
                $employees=Employee::where('department_id',$auth->department->id)->get();
                $schedules=[];
                $next_plan=[];
                foreach ($employees as $item) {
                    $schedule = DealActivitySchedule::whereBetween('from_date', [$start, $end])->where('emp_id',$item->id)->get();
                    $next = next_plan::with('employee','customer')->where('emp_id',$item->id)->whereBetween("date_time", [$start, $end])->orderBy('id', 'desc')->get();
                    foreach ($schedule as $sche){
                        array_push($schedules, $sche);
                    }
                    foreach ($next as $plan) {
                        array_push($next_plan, $plan);
                    }

                }
                return view('Schedule.index',compact('schedules','next_plan'));
                break;
            case "Sales Manager":
                $employees=Employee::where('department_id',$auth->department->id)->get();
                $schedules=[];
                $next_plan=[];
                foreach ($employees as $item) {
                    $schedule = DealActivitySchedule::whereBetween('from_date', [$start, $end])->where('emp_id',$item->id)->get();
                    $next = next_plan::with('employee','customer')->where('emp_id',$item->id)->whereBetween("date_time", [$start, $end])->orderBy('id', 'desc')->get();
                    foreach ($schedule as $sche){
                        array_push($schedules, $sche);
                    }
                    foreach ($next as $plan) {
                        array_push($next_plan, $plan);
                    }

                }
                return view('Schedule.index',compact('schedules','next_plan'));
                break;
            case "Car Admin":
                $employees=Employee::where('department_id',$auth->department->id)->get();
                $schedules=[];
                $next_plan=[];
                foreach ($employees as $item) {
                    $schedule = DealActivitySchedule::whereBetween('from_date', [$start, $end])->where('emp_id',$item->id)->get();
                    $next = next_plan::with('employee','customer')->where('emp_id',$item->id)->whereBetween("date_time", [$start, $end])->orderBy('id', 'desc')->get();
                    foreach ($schedule as $sche){
                        array_push($schedules, $sche);
                    }
                    foreach ($next as $plan) {
                        array_push($next_plan, $plan);
                    }

                }
                return view('Schedule.index',compact('schedules','next_plan'));
                break;
            default:
                $schedules = DealActivitySchedule::whereBetween('from_date', [$start, $end])->where('emp_id',$auth->id)->get();
                $next_plan = next_plan::with('employee','customer')->where('emp_id',$auth->id)->whereBetween("date_time", [$start, $end])->orderBy('id', 'desc')->get();
                return view('Schedule.index',compact('schedules','next_plan'));
        }
        }
    }
