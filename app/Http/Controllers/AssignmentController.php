<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignmentRequest;
use App\Models\Assignment;
use App\Models\Department;
use App\Models\Employee;
use App\Repositories\Contracts\AssignmentContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    private $assignment_contract;

    public function __construct(AssignmentContract $assignment_contract)
    {
        $this->assignment_contract = $assignment_contract;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        //
        $employees = Employee::all()->pluck('name', 'id')->all();
        return view('assignment.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AssignmentRequest $request)
    {
        $data = $request->all();
        $data['assigned_by'] = loginUser()->id;
        $data['creator_department_id'] = loginUser()->department->id;
        $assignment = $this->assignment_contract->create($data);
        $assignment->assigned_employees()->attach($data['assigned_employee']);
        return redirect()->route('assignments.index')->with('success', __('alert.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($assignment_id)
    {
        $assignment = $this->assignment_contract->getAssignmentsWithTasks($assignment_id);
        $employees = Employee::all()->pluck('name', 'id')->all();
        return view('assignment.tasks', compact('assignment','employees'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function edit(Assignment $assignment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function update(AssignmentRequest $request, $id)
    {
        $this->assignment_contract->updateById($id, $request->all());
        return redirect()->route('assignments.index')->with('success', __('alert.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        //
        $this->assignment_contract->deleteById($id);
        return redirect()->route('assignment.index')->with('success', __('alert.delete_success'));
    }
}
