<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeeExport;
use App\Imports\EmployeeImport;
use Exception;
use Maatwebsite\Excel\Exceptions\LaravelExcelException;

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
        return view('employee.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $departments = Department::all();
        return view('employee.createAndEdit', compact(
            'departments'
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
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        // dd($request->validated());
        Employee::create($request->validated());
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
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $departments = Department::all();
        return view('employee.createAndEdit', compact(
            'departments',
            'employee'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, Employee $employee)
    {
        //
        $employee->update($request->validated());
        return redirect('employees')->with('success', __('alert.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect('employees')->with('success', __('alert.delete_success'));
    }
}
