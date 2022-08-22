<?php

namespace App\Http\Controllers;

use App\Models\AssginmentComment;
use App\Models\Assignment;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AssigmentController extends Controller
{
    public function index(Request $request)
    {
        $start = Carbon::parse($request->start_date)->startOfDay();
        $end = Carbon::parse($request->end_date)->endOfDay();
        $auth = Auth::guard('employee')->user();
        $role = $auth->role->name;
        $emp_id = $request->emp_id;
        $status = $request->status;
        $priority = $request->priority;
        switch ($auth->role->name) {
            case 'CEO':
                if ($request->emp_id != null && $request->priority == null && $request->status == null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id != null && $request->priority != null && $request->status == null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->where('priority', $request->priority)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id != null && $request->priority == null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->where('status', $request->status)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id != null && $request->priority != null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->where('status', $request->status)
                        ->where('priority', $request->priority)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id == null && $request->priority != null && $request->status == null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('priority', $request->priority)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id == null && $request->priority != null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('status', $request->status)
                        ->where('priority', $request->priority)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id == null && $request->priority == null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('status', $request->status)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } else {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                }

                $employees = Employee::all();

                return view('Assignment.index', compact('todo_list', 'employees', 'role', 'emp_id', 'status', 'priority', 'start', 'end'));
                break;
            case 'Super Admin':
                if ($request->emp_id != null && $request->priority == null && $request->status == null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id != null && $request->priority != null && $request->status == null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->where('priority', $request->priority)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id != null && $request->priority == null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->where('status', $request->status)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id != null && $request->priority != null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->where('status', $request->status)
                        ->where('priority', $request->priority)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id == null && $request->priority != null && $request->status == null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('priority', $request->priority)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id == null && $request->priority != null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('status', $request->status)
                        ->where('priority', $request->priority)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id == null && $request->priority == null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('status', $request->status)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } else {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                }
                $employees = Employee::all();
                return view('Assignment.index', compact('todo_list', 'employees', 'role', 'emp_id', 'status', 'priority', 'start', 'end'));
                break;
            case 'Sales Manager':
                if ($request->emp_id != null && $request->priority == null && $request->status == null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                } elseif ($request->emp_id != null && $request->priority != null && $request->status == null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->where('priority', $request->priority)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                } elseif ($request->emp_id != null && $request->priority == null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->where('status', $request->status)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                } elseif ($request->emp_id != null && $request->priority != null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->where('status', $request->status)
                        ->where('priority', $request->priority)
                        ->where('assignee_id', $auth->id)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id == null && $request->priority != null && $request->status == null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('priority', $request->priority)
                        ->where('assignee_id', $auth->id)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id == null && $request->priority != null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('status', $request->status)
                        ->where('priority', $request->priority)
                        ->where('assignee_id', $auth->id)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id == null && $request->priority == null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('status', $request->status)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                } else {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                }
                $employees = Employee::where('department_id', $auth->department_id)->get();
                return view('Assignment.index', compact('todo_list', 'employees', 'role', 'emp_id', 'status', 'priority', 'start', 'end'));
                break;
            case 'Finance Manager':
                if ($request->emp_id != null && $request->priority == null && $request->status == null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                } elseif ($request->emp_id != null && $request->priority != null && $request->status == null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->where('priority', $request->priority)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                } elseif ($request->emp_id != null && $request->priority == null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->where('status', $request->status)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                } elseif ($request->emp_id != null && $request->priority != null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->where('status', $request->status)
                        ->where('priority', $request->priority)
                        ->where('assignee_id', $auth->id)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id == null && $request->priority != null && $request->status == null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('priority', $request->priority)
                        ->where('assignee_id', $auth->id)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id == null && $request->priority != null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('status', $request->status)
                        ->where('priority', $request->priority)
                        ->where('assignee_id', $auth->id)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id == null && $request->priority == null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('status', $request->status)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                } else {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                }
                $employees = Employee::where('department_id', $auth->department_id)->get();
                return view('Assignment.index', compact('todo_list', 'employees', 'role', 'emp_id', 'status', 'priority', 'start', 'end'));
                break;
            case 'Customer Service Manager':
                if ($request->emp_id != null && $request->priority == null && $request->status == null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                } elseif ($request->emp_id != null && $request->priority != null && $request->status == null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->where('priority', $request->priority)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                } elseif ($request->emp_id != null && $request->priority == null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->where('status', $request->status)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                } elseif ($request->emp_id != null && $request->priority != null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->where('status', $request->status)
                        ->where('priority', $request->priority)
                        ->where('assignee_id', $auth->id)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id == null && $request->priority != null && $request->status == null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('priority', $request->priority)
                        ->where('assignee_id', $auth->id)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id == null && $request->priority != null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('status', $request->status)
                        ->where('priority', $request->priority)
                        ->where('assignee_id', $auth->id)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id == null && $request->priority == null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('status', $request->status)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                } else {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                }
                $employees = Employee::where('department_id', $auth->department_id)->get();
                return view('Assignment.index', compact('todo_list', 'employees', 'role', 'emp_id', 'status', 'priority', 'start', 'end'));
                break;
            case 'HR Manager':
                if ($request->emp_id != null && $request->priority == null && $request->status == null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                } elseif ($request->emp_id != null && $request->priority != null && $request->status == null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->where('priority', $request->priority)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                } elseif ($request->emp_id != null && $request->priority == null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->where('status', $request->status)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                } elseif ($request->emp_id != null && $request->priority != null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->where('status', $request->status)
                        ->where('priority', $request->priority)
                        ->where('assignee_id', $auth->id)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id == null && $request->priority != null && $request->status == null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('priority', $request->priority)
                        ->where('assignee_id', $auth->id)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id == null && $request->priority != null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('status', $request->status)
                        ->where('priority', $request->priority)
                        ->where('assignee_id', $auth->id)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id == null && $request->priority == null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('status', $request->status)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                } else {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                }
                $employees = Employee::where('department_id', $auth->department_id)->get();
                return view('Assignment.index', compact('todo_list', 'employees', 'role', 'emp_id', 'status', 'priority', 'start', 'end'));
                break;
            case 'Stock Manager':
                if ($request->emp_id != null && $request->priority == null && $request->status == null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                } elseif ($request->emp_id != null && $request->priority != null && $request->status == null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->where('priority', $request->priority)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                } elseif ($request->emp_id != null && $request->priority == null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->where('status', $request->status)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                } elseif ($request->emp_id != null && $request->priority != null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->where('status', $request->status)
                        ->where('priority', $request->priority)
                        ->where('assignee_id', $auth->id)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id == null && $request->priority != null && $request->status == null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('priority', $request->priority)
                        ->where('assignee_id', $auth->id)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id == null && $request->priority != null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('status', $request->status)
                        ->where('priority', $request->priority)
                        ->where('assignee_id', $auth->id)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id == null && $request->priority == null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('status', $request->status)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                } else {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                }
                $employees = Employee::where('department_id', $auth->department_id)->get();
                return view('Assignment.index', compact('todo_list', 'employees', 'role', 'emp_id', 'status', 'priority', 'start', 'end'));
                break;
            case'General Manager':
                if ($request->emp_id != null && $request->priority == null && $request->status == null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                } elseif ($request->emp_id != null && $request->priority != null && $request->status == null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->where('priority', $request->priority)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                } elseif ($request->emp_id != null && $request->priority == null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->where('status', $request->status)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                } elseif ($request->emp_id != null && $request->priority != null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->where('status', $request->status)
                        ->where('priority', $request->priority)
                        ->where('assignee_id', $auth->id)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id == null && $request->priority != null && $request->status == null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('priority', $request->priority)
                        ->where('assignee_id', $auth->id)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id == null && $request->priority != null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('status', $request->status)
                        ->where('priority', $request->priority)
                        ->where('assignee_id', $auth->id)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id == null && $request->priority == null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('status', $request->status)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                } else {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                }
                $employees = Employee::where('department_id', $auth->department_id)->get();
                return view('Assignment.index', compact('todo_list', 'employees', 'role', 'emp_id', 'status', 'priority', 'start', 'end'));
                break;
            case 'Car Admin':
                if ($request->emp_id != null && $request->priority == null && $request->status == null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                } elseif ($request->emp_id != null && $request->priority != null && $request->status == null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->where('priority', $request->priority)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                } elseif ($request->emp_id != null && $request->priority == null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->where('status', $request->status)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                } elseif ($request->emp_id != null && $request->priority != null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->where('status', $request->status)
                        ->where('priority', $request->priority)
                        ->where('assignee_id', $auth->id)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id == null && $request->priority != null && $request->status == null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('priority', $request->priority)
                        ->where('assignee_id', $auth->id)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id == null && $request->priority != null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('status', $request->status)
                        ->where('priority', $request->priority)
                        ->where('assignee_id', $auth->id)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id == null && $request->priority == null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('status', $request->status)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                } else {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->whereBetween('end_date', [$start, $end])
                        ->where('assignee_id', $auth->id)
                        ->get();

                }
                $employees = Employee::where('department_id', $auth->department_id)->get();
                return view('Assignment.index', compact('todo_list', 'employees', 'role', 'emp_id', 'status', 'priority', 'start', 'end'));
                break;
            default:
                if ($request->emp_id != null && $request->priority == null && $request->status == null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('emp_id', $auth->id)
                        ->get();

                } elseif ($request->emp_id != null && $request->priority != null && $request->status == null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->where('priority', $request->priority)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('emp_id', $auth->id)
                        ->get();

                } elseif ($request->emp_id != null && $request->priority == null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->where('status', $request->status)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('emp_id', $auth->id)
                        ->get();

                } elseif ($request->emp_id != null && $request->priority != null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('emp_id', $request->emp_id)
                        ->where('status', $request->status)
                        ->where('priority', $request->priority)
                        ->where('emp_id', $auth->id)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id == null && $request->priority != null && $request->status == null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('priority', $request->priority)
                        ->where('emp_id', $auth->id)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id == null && $request->priority != null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('status', $request->status)
                        ->where('priority', $request->priority)
                        ->where('emp_id', $auth->id)
                        ->whereBetween('end_date', [$start, $end])
                        ->get();

                } elseif ($request->emp_id == null && $request->priority == null && $request->status != null) {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->where('status', $request->status)
                        ->whereBetween('end_date', [$start, $end])
                        ->where('emp_id', $auth->id)
                        ->get();

                } else {
                    $todo_list = Assignment::with('owner', 'responsible_emp')
                        ->whereBetween('end_date', [$start, $end])
                        ->where('emp_id', $auth->id)
                        ->get();

                }
                $employees = Employee::where('id', $auth->id)->get();
                return view('Assignment.index', compact('todo_list', 'employees', 'role', 'emp_id', 'status', 'priority', 'start', 'end'));
                break;
        }

    }

    public function create()
    {


    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required',
            'emp_id' => 'required',
            'assignee_id' => 'required',
            'description' => 'nullable',
            'priority' => 'required',
            'status' => 'nullable',
            'end_date' => 'required',
            'attach' => 'nullable'
        ]);
       $task= Assignment::create($request->all());
        $emp=Employee::where('id',$request->emp_id)->first();
        $details = [
            'from'=>Auth::guard('employee')->user()->email,
            'email' => $emp->email,
            'subject' => 'Task Assignment',
            'assignee_name' =>ucfirst(Auth::guard('employee')->user()->name),
            'responsible_emp'=>$emp->name,
            'id'=>$task->id,
            'title'=>$request->title,
            'due_date'=>$request->end_date,
        ];
        Mail::send('Assignment.email', $details, function ($message) use ($details) {
            $message->from('sinyincinpu@gmail.com', 'Cloudark');
            $message->to($details['email']);
            $message->subject($details['subject']);
        });
        return redirect('assignments')->with('success', 'Add new todo list');

    }

    public function edit($id)
    {
        $auth = Auth::guard('employee')->user();
        $role = $auth->role->name;
        $todo_list = Assignment::with('owner', 'responsible_emp')->where('id', $id)->firstOrFail();
        if ($todo_list->assignee_id == $auth->id) {
            switch ($auth->role->name) {
                case 'CEO':
                    $employees = Employee::all();
                    return view('Assignment.edit', compact('todo_list', 'employees', 'role'));
                    break;
                case 'Super Admin':
                    $employees = Employee::all();
                    return view('Assignment.edit', compact('todo_list', 'employees', 'role'));
                    break;
                case 'Sales Manager':
                    $employees = Employee::where('department_id', $auth->department_id)->get();
                    return view('Assignment.edit', compact('todo_list', 'employees', 'role'));
                    break;
                case 'Finance Manager':
                    $employees = Employee::where('department_id', $auth->department_id)->get();
                    return view('Assignment.edit', compact('todo_list', 'employees', 'role'));
                    break;
                case 'Customer Service Manager':
                    $employees = Employee::where('department_id', $auth->department_id)->get();
                    return view('Assignment.edit', compact('todo_list', 'employees', 'role'));
                    break;
                case 'HR Manager':
                    $employees = Employee::where('department_id', $auth->department_id)->get();
                    return view('Assignment.edit', compact('todo_list', 'employees', 'role'));
                    break;
                case 'Stock Manager':
                    $employees = Employee::where('department_id', $auth->department_id)->get();
                    return view('Assignment.edit', compact('todo_list', 'employees', 'role'));
                    break;
                case'General Manager':
                    $employees = Employee::where('department_id', $auth->department_id)->get();
                    return view('Assignment.edit', compact('todo_list', 'employees', 'role'));
                    break;
                case 'Car Admin':
                    $employees = Employee::where('department_id', $auth->department_id)->get();
                    return view('Assignment.edit', compact('todo_list', 'employees', 'role'));
                    break;
                default:
                    $employees = Employee::where('id', $auth->id)->get();
                    return view('Assignment.edit', compact('todo_list', 'employees', 'role'));
            }
        } else {
            return redirect()->back()->with('error', 'You Can not edit this task');
        }
    }

    public function update(Request $request, $id)
    {
        $todo = Assignment::where('id', $id)->first();
        $todo->progress = $request->progress;
        $todo->title = $request->title;
        $todo->description = $request->description;
        $todo->status = $request->status;
        $todo->priority = $request->priority;
        $todo->end_date = $request->end_date;
        $todo->emp_id = $request->emp_id;
        $todo->assignee_id = $request->assignee_id;
        $todo->update();

        return redirect('assignments')->with('success', 'Task Updated');
    }

    public function show($id)
    {
        $todo_list = Assignment::with('owner', 'responsible_emp')->where('id', $id)->firstOrFail();
        $comments = AssginmentComment::with('employee')->where('assignment_id', $id)->get();
//        dd($comments);
        return view('Assignment.show', compact('todo_list', 'comments'));
    }

    public function comment(Request $request)
    {
        $this->validate($request, [
            'comment' => 'required'
        ]);
//        dd($request->all());
        $comment = new AssginmentComment();
        if(isset($request->attach)) {
//            dd('hell');
            $attach = $request->file('attach');
            $input['filename'] =\Illuminate\Support\Str::random(10).time().'.'.$attach->getClientOriginalExtension();
            $request->attach->move(public_path() . '/ticket_attach/', $input['filename']);
            $comment->attach =$input['filename'];
        }
        $comment->emp_id = $request->emp_id;
        $comment->assignment_id = $request->assignment_id;
        $comment->comment = $request->comment;
//        dd($comment);
        $comment->save();
        return redirect(route('assignments.show', $request->assignment_id))->with('success', 'Add new comment');
    }
}
