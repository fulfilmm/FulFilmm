<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignmentRequest;
use App\Models\ActivityComment;
use App\Models\Assignment;
use App\Models\AssignmentComment;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Group;
use App\Repositories\Contracts\AssignmentContract;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
        $groups = Group::all()->pluck('name', 'id');
        return view('assignment.index', compact('employees', 'groups'));
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AssignmentRequest $request)
    {
        $data = $request->all();
        $data['due_date'] = Carbon::createFromFormat('d/m/Y', $request->due_date);
        $data['assigned_by'] = loginUser()->id;
        $data['creator_department_id'] = loginUser()->department->id;
        $assignment = $this->assignment_contract->create($data);
        $assignment->assigned_employees()->attach($data['assigned_employee'] ?? []);
        $assignment->assigned_groups()->attach($data['assigned_group'] ?? []);
        return redirect()->route('assignments.index')->with('success', __('alert.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Assignment $assignment
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function show($assignment_id)
    {

        $assignment = $this->assignment_contract->getAssignmentsWithTasks($assignment_id);
        $messages = AssignmentComment::where('assignment_id', $assignment_id)
            ->with('user')
            ->get();
        if ($assignment) {
            $employees = Employee::all()->pluck('name', 'id')->all();
            return view('assignment.tasks', compact('assignment', 'employees', 'messages'));
        }
        return abort(404);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Assignment $assignment
     * @return \Illuminate\Http\Response
     */
    public function edit(Assignment $assignment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Assignment $assignment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AssignmentRequest $request, $id)
    {
        $assignment = $this->assignment_contract->updateById($id, $request->all());
        return redirect()->route('assignments.index')->with('success', __('alert.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Assignment $assignment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        //this would be soft delete

        $this->assignment_contract->deleteById($id);
        return redirect()->route('assignments.index')->with('success', __('alert.delete_success'));
    }

    public function changeStatus($id, Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'status' => [
                'required',
                Rule::in(['created','working','done']),
            ]
        ]);

        $assignment = Assignment::find($id);
        if($assignment){
            $assignment->status = $request->status;
            $assignment->save();

            return redirect()->route('assignments.show', $id)->with('success', 'Assignment Status is updated');
        }
        return abort(404);

    }
}
