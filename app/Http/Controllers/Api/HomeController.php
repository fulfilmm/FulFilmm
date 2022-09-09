<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        return response()->json(['hello'=>'ljsdf']);
//        $Auth=Auth::guard('api')->user();
//        if(Auth::guard('api')->user()->mobile_seller==1){
//            $warehouse =Warehouse::where('branch_id', $Auth->office_branch_id)
//                ->where('mobile_warehouse',1)
//                ->first();
//
//            $in_stock=Stock::with('variant')
//                ->where('available', '>', 0)
//                ->where('warehouse_id',$warehouse->id)
//                ->get();
//        }else{
//
//            $warehouse =Warehouse::where('branch_id', $Auth->office_branch_id)
//                ->where('mobile_warehouse',0)
//                ->get();
//
//            $in_stock=[];
//            foreach ($warehouse as $wh) {
//                $single_stocks = Stock::with('variant')
//                    ->where('available', '>', 0)
//                    ->where('warehouse_id',$wh->id)
//                    ->get();
//                foreach ($single_stocks as $stock){
//                    array_push($in_stock,$stock);
//                }
//            }
//        }
//        $aval_product =[];
//
//        foreach ($in_stock as $inhand){
//            if($inhand->variant->enable==1){
//                array_push($aval_product,$inhand);
//            }
//        }
//        return response()->json(['products'=>$aval_product]);
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
