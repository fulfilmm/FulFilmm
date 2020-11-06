<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Repositories\Contracts\DepartmentContract;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\http\Requests\DepartmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentRequest $request)
    {
        //
        $this->department_contract->create($request->all());
        return redirect()->route('department.index')->with('success', __('alert.create_success'));
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
        $record = $this->department_contract->getById($id);
        return view('', compact('record'));
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
        return redirect()->route('department.index')->with('success', __('alert.update_success'));
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
        return redirect()->route('department.index')->with('success', __('alert.delete_success'));
    }
}
