<?php

namespace App\Http\Controllers\CarBooking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarData;
use App\Models\MaintainRecord;

class MaintainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('carBooking/maintain');
    }

    

    public function download($data)
    {
        $filePath = public_path('/upload/maintain/attach/'.$data);
        $fileName = $data ;

        return response() -> download( $filePath, $fileName);
    } 

    public function downloadRecord($data)
    {
        $filePath = public_path('/upload/maintain/maintain_check/attaches/'.$data);
        $fileName = $data;

        return response() -> download($filePath, $fileName);
    }

    public function create()
    { 
        //
    }

   
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('carBooking/maintainDetail');
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
        //
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
    }
}
