<?php

namespace App\Http\Controllers;

use App\Models\OfficeBranch;
use App\Models\ProductStockBatch;
use App\Models\ProductVariations;
use App\Models\Stock;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $warehouses=Warehouse::with('branch','main_warehouse')->get();
        $branches=OfficeBranch::all();
        $warehouse_qty=[];
        foreach ($warehouses as $warehouse){
            $product=ProductStockBatch::where('warehouse_id',$warehouse->id)->get();
            $total=0;
            foreach ($product as $item){
                $valuation=$item->qty*$item->purchase_price??0;
                $total+=$valuation;
            }

            $warehouse_qty[$warehouse->id]=$total;
        }
        $last_wh = Warehouse::orderBy('id', 'desc')->first();
        if ($last_wh != null) {
            $last_wh->warehouse_id++;
            $warehouse_id = $last_wh->warehouse_id;
        } else {
            $warehouse_id = "WH-001";
        }
        return view('warehouse.index',compact('warehouses','warehouse_qty','warehouse_id','branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'warehouse_id'=>'required',
            'branch_id'=>'required'
        ]);
        Warehouse::create($request->all());
        return redirect(route('warehouses.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $warehouse=Warehouse::where('id',$id)->firstorFail();
        $stocks=Stock::with('warehouse','variant')->where('warehouse_id',$id)->get();
        return view('warehouse.show',compact('warehouse','stocks'));
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
//        dd($request->all());
        $stocks=Warehouse::where('id',$id)->firstorFail();
        $stocks->name=$request->name;
        $stocks->description=$request->description;
        $stocks->is_virtual=$request->is_virtual??0;
        $stocks->address=$request->address;
        $stocks->update();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stock=Warehouse::where('id',$id)->firstorFail();
        $stock->delete();
        return redirect()->back();
    }
}
