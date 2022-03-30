<?php

namespace App\Http\Controllers\Api\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\orderItem;
use App\Models\MainCompany;
use App\Models\product;

class InvoiceDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // //public $status = ['Paid' , 'Unpaid', 'Pending', 'Cancel'];

        // public function index(){
        //     $all_inv = Invoice::with('customer') 
        //                 ->get();
        //     $status = $this -> status;

        //     return response() -> json(['all_inv' => $all_inv, 'status' => $status]);
        // }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
