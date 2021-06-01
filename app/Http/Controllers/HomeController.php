<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Assignment;
use App\Models\Employee;
use App\Models\Group;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Assign;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $id = Auth::id();

        $items = [
//            'projects' => Project::count(),
            'my_assignments' => Assignment::whereHas('assigned_employees', function ($query) use ($id) {
                $query->where('employee_id', $id);
            })->count(),
            'my_activities' => Activity::where('employee_id', $id)->count(),
            'my_groups' => Group::whereHas('employees', function ($query) use ($id) {
                $query->where('employee_id', $id);
            })->count(),
        ];

        return view('index', compact('items'));
    }
}
