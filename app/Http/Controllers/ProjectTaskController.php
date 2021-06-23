<?php

namespace App\Http\Controllers;

use App\Models\ProjectTask;
use App\Repositories\Contracts\ProjectTaskContract;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProjectTaskController extends Controller
{
    private $projectTaskContract;

    public function __construct(ProjectTaskContract $projectTaskContract)
    {
        $this->projectTaskContract = $projectTaskContract;
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        if ($request->keyword === 'normal') {
            $request['due_date'] = Carbon::createFromFormat('d/m/Y', $request->due_date);
            $validated = $request->validate([
                'due_date' => 'required|date|after_or_equal:today',
            ]);

        }

        $project_id = $request->project_id;
        $project_task = $this->projectTaskContract->create( $request->all());
        $project_task->assigned_employees()->attach($request->project_task_employee ?? []);

        return redirect()->route('projects.show', $project_id)->with('success', __('alert.create_success'));
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        //
        $project_id = $request->project;
        $this->projectTaskContract->deleteById($id);
        return redirect()->route('projects.show', $project_id)->with('success', __('alert.delete_success'));
    }

    public function toggleStatus($id, Request $request)
    {
        $project_id = $request->project_id;
        $task = ProjectTask::find($id);
        $task->status = !$task->status;
        $task->save();

        return redirect()->route('projects.show', $project_id)->with('success', 'Task Updated');
    }
}
