<?php

namespace App\Http\Controllers;

use App\Models\AssignmentTask;
use App\Repositories\Contracts\AssignmentTaskContract;
use Illuminate\Http\Request;

class AssignmentTaskController extends Controller
{
    private $assignmentTaskContract;

    public function __construct(AssignmentTaskContract $assignmentTaskContract)
    {
        $this->assignmentTaskContract = $assignmentTaskContract;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $assignment_id = $request->assignment_id;
        $this->assignmentTaskContract->create($request->all());
        return redirect()->route('assignments.show', $assignment_id)->with('success', __('alert.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id, Request $request)
    {
        $assignment_id = $request->assignment_id;
        $this->assignmentTaskContract->deleteById($id);
        return redirect()->route('assignments.show', $assignment_id)->with('success', __('alert.delete_success'));
    }

    public function toggleStatus($id, Request $request)
    {
        $assignment_id = $request->assignment_id;
        $task = AssignmentTask::find($id);
        $task->status = !$task->status;
        $task->save();

        return redirect()->route('assignments.show', $assignment_id)->with('success', 'Task Updated');
    }
}
