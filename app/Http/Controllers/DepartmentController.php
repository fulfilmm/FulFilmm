<?php

namespace App\Http\Controllers;

use App\Exports\DepartmentExport;
use App\Http\Requests\DepartmentRequest;
use App\Imports\DepartmentImport;
use App\Models\Department;
use App\Models\Employee;
use App\Repositories\Contracts\DepartmentContract;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DepartmentController extends Controller
{
    private $department_contract;
    public function __construct(DepartmentContract $department_contract)
    {
        $this->department_contract = $department_contract;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('department.data.lists');
    }

    public function card(){
        $departments = Department::paginate(20);
        return view('department.data.cards', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_departments = $this->department_contract->parentDepartments()->pluck('name','id')->all();
        $employees = Employee::all()->pluck('name', 'id');
        return view('department.create', compact('parent_departments', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\http\Requests\DepartmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentRequest $request)
    {
        $department = $this->department_contract->create($request->all());
        $this->department_contract->assignDepartmentHead($department->id, $request->employee_id);
        return redirect()->route('departments.index')->with('success', __('alert.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $record = $this->department_contract->getDepartmentWithHead($id);
        $parent_departments = $this->department_contract->parentDepartments()->pluck('name','id')->all();
        $employees = Employee::all()->pluck('name', 'id');
        return view('department.edit', compact('record', 'parent_departments', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\DepartmentRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentRequest $request, $id)
    {
        $this->department_contract->updateById($id, $request->all());
        return redirect()->route('departments.index')->with('success', __('alert.update_success'));
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
        $this->department_contract->deleteById($id);
        return redirect()->route('departments.index')->with('success', __('alert.delete_success'));
    }

    public function export()
    {
        return Excel::download(new DepartmentExport, 'departments.xlsx');
    }

    public function import(Request $request)
    {
        try
        {
            Excel::import(new DepartmentImport, $request->file('import'));
            return redirect()->route('departments.index')->with('success', __('alert.import_success'));
        }catch(Exception $e)
        {
            return redirect()->route('departments.index')->with('error', $e->getMessage());
        }
    }
}
