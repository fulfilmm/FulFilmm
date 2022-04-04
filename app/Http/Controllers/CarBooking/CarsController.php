<?php

namespace App\Http\Controllers\CarBooking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarData;
use App\Models\MaintainRecord;
use App\Models\MaintainCheck;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('carBooking/index');
    }

    public function download($contract) {
        $filePath = public_path('/upload/car_list/contract/'.$contract);
        $fileName = $contract ;

        return response() -> download( $filePath, $fileName);
    }

    public function downloadAttach($data) {
        $filePath = public_path('/upload/car_list/attach/'.$data);
        $fileName = $data;

        return response() -> download( $filePath , $fileName);
    }
 
    // public function maintain($id) {
    //     $maintain 
    // }
   

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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$data = CarData::find($id);

        return view('carBooking/detail');
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
