<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Comment;
use App\Repositories\Contracts\ActivityContract;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    private $activity_contract;
    public function __construct(ActivityContract $activity_contract)
    {
        $this->activity_contract = $activity_contract;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        //
        $employees = Employee::all()->pluck('name', 'id')->all();
        return view('activity.index', compact('employees'));
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['employee_id'] = Auth::id() ?? 1;
        $this->activity_contract->create($data);
        return redirect()->route('activities.index')->with('success', __('alert.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $activity = $this->activity_contract->activityWithTasks($id);
        $messages = Comment::where('activity_id', $id)
            ->with('user')
            ->get();
        return view('activity.tasks', compact('activity', 'messages'));
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->activity_contract->updateById($id, $request->all());
        return redirect()->route('activities.index')->with('success', __('alert.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->activity_contract->deleteById($id);
        return redirect()->route('activities.index')->with('success', __('alert.delete_success'));
    }
}
