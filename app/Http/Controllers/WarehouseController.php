<?php

namespace App\Http\Controllers;

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
        $warehouses=Warehouse::all();

        $warehouse_qty=[];
        foreach ($warehouses as $warehouse){
            $total_quantiy=Stock::where('warehouse_id',$warehouse->id)->get();
            $total=0;
            foreach ($total_quantiy as $qty){
                    $total=$total+$qty->stock_balance;
            }
            $warehouse_qty[$warehouse->id]=$total;
        }

        return view('warehouse.index',compact('warehouses','warehouse_qty'));
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
        $this->validate($request,['name'=>'required']);
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
        $stocks=Warehouse::where('id',$id)->firstorFail();
        $stocks->name=$request->name;
        $stocks->description=$request->description;
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
