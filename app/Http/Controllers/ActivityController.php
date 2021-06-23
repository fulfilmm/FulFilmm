<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityComment;
use App\Repositories\Contracts\ActivityContract;
use App\Models\Employee;
use Carbon\Carbon;
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
        //The activity creator name is excluded due to request
        $employees = Employee::where('id', '!=', auth()->id())->pluck('name', 'id')->all();
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['date'] = Carbon::createFromFormat('d/m/Y', $request->date);
        $data['employee_id'] = loginUser()->id;
        $data['department_id'] = loginUser()->department->id;
        $activity = $this->activity_contract->create($data);

        if (isset($data['co_owners'])) {
            $this->activity_contract->addCoOwners($activity, $data['co_owners']);
        }
        return redirect()->route('activities.index')->with('success', __('alert.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $activity = $this->activity_contract->activityWithTasks($id);
  
        $this->authorize('can-acknowledge', $activity);
        $messages = ActivityComment::where('activity_id', $id)
            ->with('user')
            ->get();
        return view('activity.tasks', compact('activity', 'messages'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {
        //
        $employees = Employee::where('id', '!=', auth()->id())->pluck('name', 'id')->all();
        return view('activity.edit', compact('activity','employees'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {

        
        $request['date'] = Carbon::createFromFormat('d/m/Y', $request->date);
        // dd(Carbon::createFromFormat('d/m/Y', $request->date));

        $activity = $this->activity_contract->updateById($id, $request->all());

        $this->activity_contract->syncCoOwners($activity, $request->co_owners);

        return redirect()->route('activities.index')->with('success', __('alert.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->activity_contract->deleteById($id);
        return redirect()->route('activities.index')->with('success', __('alert.delete_success'));
    }


    public function acknowledge($activity_id): \Illuminate\Http\RedirectResponse
    {
        $this->activity_contract->acknowledgeActivity($activity_id);
        return redirect()->route('activities.index')->with('success', __('alert.acknowledged'));
    }
}
