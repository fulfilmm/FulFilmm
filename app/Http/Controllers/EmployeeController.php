<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Brand;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\OfficeBranch;
use App\Models\Region;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeeExport;
use App\Imports\EmployeeImport;
use Exception;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $this->middleware('auth:employee')->except('create');
    }

    public function index()
    {
        return view('employee.data.lists');
    }

    public function card()
    {
        $auth=Auth::guard('employee')->user();
       if($auth->role->name=='Super Admin'||$auth->role->name=='CEO'||$auth->role->name=='Hr Manager'){
           $employees = Employee::with('branch')->orderBy('empid', 'desc')
               ->paginate(25);
           $branch = OfficeBranch::all();
       }else{
           $employees = Employee::with('branch')->orderBy('empid', 'desc')
               ->where('office_branch_id',$auth->office_branch_id)
               ->paginate(25);
           $branch = OfficeBranch::where('id',$auth->office_branch_id)->get();
       }
        return view('employee.data.cards', compact('employees', 'branch'));
    }

    public function search(Request $request)
    {
       $auth=Auth::guard('employee')->user();
       if($auth->role->name=='Super Admin'||$auth->role->name=='CEO'){
           $employees = Employee::orderBy('empid', 'desc')->where('id', $request->search)->orWhere('name', 'LIKE', $request->search)->orWhere('empid', $request->serach)->paginate(20);
           $branch = OfficeBranch::all();
       }else{
           $employees = Employee::orderBy('empid', 'desc')->where('office_branch_id',$auth->office_branch_id)->where('id', $request->search)->orWhere('name', 'LIKE', $request->search)->orWhere('empid', $request->serach)->paginate(20);
           $branch = OfficeBranch::all();
       }
        return view('employee.data.cards', compact('employees', 'branch'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        //

        $departments = Department::all()->pluck('name', 'id');
        $roles = Role::all()->pluck('name', 'id');
        $office = OfficeBranch::all();
        $all_employee = Employee::all()->pluck('name', 'id')->all();
        $auth = Auth::guard('employee')->user();
        if ($auth->role->name == 'Super Admin' || $auth->role->name == 'CEO') {
            $warehouse = Warehouse::all();
            $region = Region::all();
        } else {
            $warehouse = Warehouse::where('branch_id', $auth->office_branch_id)->get();
            $region = Region::where('branch_id', $auth->office_branch_id)->get();
        }

        return view('employee.create', compact(
            'departments',
            'roles',
            'office',
            'all_employee',
            'warehouse',
            'region'
        ));
    }


    public function import(Request $request)
    {
        // dd($request);
        try {
            Excel::import(new EmployeeImport, $request->file('import'));
            return redirect()->route('employees.index')->with('success', __('alert.import_success'));
        } catch (Exception $e) {
            // dd($e);
            return redirect()->route('employees.index')->with('error', $e->getMessage());
        }
    }

    public function export(Request $request)
    {
        return Excel::download(new EmployeeExport($request->start_date, $request->end_date), 'employees.xlsx');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(EmployeeRequest $request)
    {
//        dd($request->all());
        $this->validate($request, [
            'email' => 'unique:employees'
        ]);
        $data = collect($request->validated())->except('role_id')->toArray();
//dd($data);
        $last_emp = Employee::orderBy('empid', 'desc')->first();

        if ($last_emp != null) {
            $last_emp->empid++;
            $employee_id = $last_emp->empid;
        } else {
            $employee_id = "Emp-00001";
        }
//        dd($employee_id);
        $employee = new Employee();
        $employee->name = $data['name'];
        $employee->empid = $employee_id;
        $employee->email = $data['email'];
        $employee->phone = $data['phone'];
        $employee->office_branch_id = $data['office_branch_id'] ?? null;
        $employee->work_phone = $data['work_phone'];
        $employee->join_date = $data['join_date'];
        $employee->password = $request->password;
        $employee->department_id = $data['department_id'];
        $employee->can_login = $data['can_login'] ?? 0;
        $employee->dob = $request->dob;
        $employee->address = $request->address;
        $employee->report_to = $request->report_to;
        $employee->gender = $request->gender;
        $employee->mobile_seller = $request->mobile_seller??0;
        $employee->region_id = $request->region_id;
        $employee->warehouse_id = $request->warehouse_id;

        if ($request->profile_img != null) {
            $profile = $request->file('profile_img');
            $input['filename'] = \Illuminate\Support\Str::random(10) . time() . '.' . $profile->extension();
            $request->profile_img->move(public_path() . '/img/profiles', $input['filename']);
            $employee->profile_img = $input['filename'];
        }
        $employee->save();
        $employee->assignRole($request->role_id);
        $office_branch = OfficeBranch::where('id', $data['office_branch_id'])->first();
        $office_branch->status = 1;
        $office_branch->update();
        return redirect('employees')->with('success', __('alert.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $employee = Employee::with('department', 'reportperson')->where('id', $id)->firstOrFail();

        if (isset($request->start)) {
            $start = Carbon::parse($request->start)->startOfDay();
            $end = Carbon::parse($request->end)->endOfDay();
            $invoices = Invoice::with('customer')->where('emp_id', $id)
                ->whereBetween('created_at', [$start, $end])
                ->get();
            $grand_total = DB::table("invoices")
                ->select(DB::raw("SUM(grand_total) as total"))
                ->where('emp_id', $id)
                ->whereBetween('created_at', [$start, $end])
                ->where('cancel', 0)
                ->get();
            $total_on_transaction = DB::table("revenues")
                ->select(DB::raw("SUM(amount) as total"))
                ->where('emp_id', $id)
                ->where('approve', 1)
                ->whereBetween('created_at', [$start, $end])
                ->get();
            $expenses = DB::table("emp_expenses")
                ->select(DB::raw("SUM(amount) as total"))
                ->whereBetween('created_at', [$start, $end])
                ->where('emp_id', $id)->whereBetween('created_at', [$start, $end])
                ->get();
        } else {
            $start = null;
            $end = null;
            $invoices = Invoice::with('customer')->where('emp_id', $id)->get();
            $grand_total = DB::table("invoices")
                ->select(DB::raw("SUM(grand_total) as total"))
                ->where('cancel', 0)
                ->where('emp_id', $id)
                ->get();

            $total_on_transaction = DB::table("revenues")
                ->select(DB::raw("SUM(amount) as total"))
                ->where('emp_id', $id)
                ->where('approve', 1)
                ->get();
            $expenses = DB::table("emp_expenses")
                ->select(DB::raw("SUM(amount) as total"))
                ->where('emp_id', $id)
                ->get();
        }
        $receivable = DB::table("invoices")
            ->select(DB::raw("SUM(due_amount) as total"))
            ->where('cancel', 0)
            ->where('emp_id', $id)
            ->get();
        return view('employee.show', compact('employee', 'invoices', 'grand_total', 'total_on_transaction', 'receivable', 'expenses', 'start', 'end'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee $employee
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $departments = Department::all()->pluck('name', 'id');
        $roles = Role::all()->pluck('name', 'id');
        $office = OfficeBranch::all();
        $all_employee = Employee::all()->pluck('name', 'id')->all();
        $auth = Auth::guard('employee')->user();
        if ($auth->role->name == 'Super Admin' || $auth->role->name == 'CEO') {
            $warehouse = Warehouse::all();
            $region = Region::all();
        } else {
            $warehouse = Warehouse::where('branch_id', $auth->office_branch_id)->get();
            $region = Region::where('branch_id', $auth->office_branch_id)->get();
        }

        return view('employee.edit', compact(
            'departments',
            'roles',
            'employee',
            'office',
            'all_employee',
            'warehouse',
            'region'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Employee $employee
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(EmployeeRequest $request, Employee $employee)
    {
        $data = collect($request->validated())->except('role_id')->toArray();
        $data['can_login'] = $data['can_login'] ?? "0";
        $data['can_post_assignment'] = $data['can_post_assignments'] ?? "0";
        $email_exit = Employee::where('id', '!=', $employee->id)->where('email', $data['email'])->first();
        if ($email_exit == null) {
            $employee->name = $data['name'];
            $employee->email = $data['email'];
            $employee->phone = $data['phone'];
            $employee->office_branch_id = $request->office_branch_id;
            $employee->work_phone = $data['work_phone'];
            $employee->join_date = $data['join_date'];
            $employee->department_id = $data['department_id'];
            $employee->can_login = $data['can_login'];
            $employee->can_post_assignments = $data['can_post_assignment'];
            $employee->dob = $request->dob;
            $employee->address = $request->address;
            $employee->report_to = $request->report_to;
            $employee->warehouse_id = $request->warehouse_id;
            $employee->mobile_seller = $request->mobile_seller??0;
            $employee->region_id = $request->region_id;
            $employee->warehouse_id = $request->warehouse_id;

            if ($request->profile_img != null) {
                $profile = $request->file('profile_img');
                $input['filename'] = \Illuminate\Support\Str::random(10) . time() . '.' . $profile->extension();
                $request->profile_img->move(public_path() . '/img/profiles', $input['filename']);
                $employee->profile_img = $input['filename'];
            }
            $employee->update();
            $employee->syncRoles($request->role_id);
            $office_branch = OfficeBranch::where('id', $request->office_branch_id)->first();
            $office_branch->status = 1;
            $office_branch->update();
            return redirect('employees')->with('success', __('alert.update_success'));
        } else {
            return redirect('employees')->with('error', 'Email already Exist');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee $employee
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect('employees')->with('success', __('alert.delete_success'));
    }

    public function password_edit()
    {
        return view('settings.passwordchange');
    }

    public function password_update(Request $request, $id)
    {
        $emp = Employee::where('id', $id)->first();
        if (password_verify($request->current_pass, $emp->password)) {
            $emp->password = Hash::make($request->password);
            $emp->update();
        }
        return redirect('/')->with('success', 'Password Change Successful!');
    }
}
