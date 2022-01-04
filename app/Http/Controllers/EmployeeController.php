<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeeExport;
use App\Imports\EmployeeImport;
use Exception;
use Maatwebsite\Excel\Exceptions\LaravelExcelException;
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

    public function card(){
        $employees = Employee::paginate(20);
        return view('employee.data.cards', compact('employees'));
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

        return view('employee.create', compact(
            'departments',
            'roles'
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

    public function export()
    {
        return Excel::download(new EmployeeExport, 'employees.xlsx');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(EmployeeRequest $request)
    {
        $data  = collect($request->validated())->except('role_id')->toArray();
//dd($data);
        $last_emp = Employee::orderBy('id', 'desc')->first();

        if ($last_emp != null) {
            $last_emp->employee_id++;
            $employee_id = $last_emp->empid;
        } else {
            $employee_id = "Emp-00001";
        }
        $employee = new Employee();
        $employee->name=$data['name'];
        $employee->empid=$employee_id;
        $employee->email=$data['email'];
        $employee->phone=$data['phone'];
        $employee->work_phone=$data['work_phone'];
        $employee->join_date=$data['join_date'];
        $employee->password=$request->password;
        $employee->department_id=$data['department_id'];
        $employee->can_login=$data['can_login']??0;
        if($request->profile_img!=null){
            $name = $request->profile_img->getClientOriginalName();
            $request->profile_img->move(public_path() . '/img/profiles', $name);
            $employee->profile_img = $name;
        }
        $employee->save();
        $employee->assignRole($request->role_id);
        return redirect('employees')->with('success', __('alert.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee=Employee::with('department')->where('id',$id)->first();
        return view('employee.show',compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $departments = Department::all()->pluck('name', 'id');
        $roles = Role::all()->pluck('name', 'id');

        return view('employee.edit', compact(
            'departments',
            'roles',
            'employee'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(EmployeeRequest $request, Employee $employee)
    {
//        dd($employee);
        $data  = collect($request->validated())->except('role_id')->toArray();
        $data['can_login'] =  $data['can_login'] ?? "0";
        $data['can_post_assignment'] =  $data['can_post_assignments'] ?? "0";

        $employee->name=$data['name'];
        $employee->email=$data['email'];
        $employee->phone=$data['phone'];
        $employee->work_phone=$data['work_phone'];
        $employee->join_date=$data['join_date'];
        $employee->department_id=$data['department_id'];
        $employee->can_login=$data['can_login'];
        $employee->can_post_assignments=$data['can_post_assignment'];
        if($request->profile_img!=null){
            $name = $request->profile_img->getClientOriginalName();
            $request->profile_img->move(public_path() . '/img/profiles', $name);
            $employee->profile_img = $name;
        }
            $employee->update();
            $employee->syncRoles($request->role_id);
            return redirect('employees')->with('success', __('alert.update_success'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect('employees')->with('success', __('alert.delete_success'));
    }
}
