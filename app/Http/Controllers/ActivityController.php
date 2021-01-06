<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Repositories\Contracts\ActivityContract;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        //
        $customers = Customer::get();
        return view('activity.index', compact('customers'));
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->activity_contract->create($request->all());
        return redirect()->route('activities.index')->with('success', __('alert.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $activity = $this->activity_contract->activityWithTasks($id);
        return view('activity.details', compact('activity'));
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
        $this->activity_contract->updateById($id, $request->all());
        return redirect()->route('activities.index')->with('success', __('alert.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->activity_contract->deleteById($id);
        return redirect()->route('activities.index')->with('success', __('alert.delete_success'));
    }
}
