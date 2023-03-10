<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use http\Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:employee')->except('create');
    }
    public function index()
    {
        $employees = Employee::paginate(20);
        return response()->json(['employees'=>$employees]);
    }

    public function card(){
        $employees = Employee::paginate(20);
        return response()->json(['employees'=>$employees]);
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

        return response()->json([
            'departments'=>$departments,
            'roles'=>$roles,
        ]);
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
        $this->validate($request,[
            'email'=>'unique:employees'
        ]);
        $data  = collect($request->validated())->except('role_id')->toArray();

        $employee = Employee::create($data);
        $employee->assignRole($request->role_id);
        return redirect('employees')->with('success', __('alert.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        dd($employee);
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
        $data  = collect($request->validated())->except('role_id')->toArray();
        $data['can_login'] =  $data['can_login'] ?? "0";
        $data['can_post_assignment'] =  $data['can_post_assignment'] ?? "0";
        $employee->update($data);
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
