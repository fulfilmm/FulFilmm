<?php

namespace App\Http\Controllers;

use App\Models\ActivityTask;
use App\Repositories\Contracts\ActivityTaskContract;
use Illuminate\Http\Request;

class ActivityTaskController extends Controller
{
    private $activity_task_contract;
    public function __construct(ActivityTaskContract $activity_task_contract)
    {
        $this->activity_task_contract = $activity_task_contract;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $activity_id = $request->activity_id;
        $this->activity_task_contract->create($request->all());
        return redirect()->route('activities.show', $activity_id)->with('success', __('alert.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id, Request $request)
    {
        $activity_id = $request->activity_id;
        $this->activity_task_contract->deleteById($id);
        return redirect()->route('activities.show', $activity_id)->with('success', __('alert.delete_success'));
    }

    public function toggleStatus($id, Request $request)
    {
        $activity_id = $request->activity_id;
        $task = ActivityTask::find($id);
        $task->status = !$task->status;
        $task->save();

        return redirect()->route('activities.show', $activity_id)->with('success', 'Task Updated');
    }
}
