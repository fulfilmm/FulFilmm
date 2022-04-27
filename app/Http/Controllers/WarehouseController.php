<?php

namespace App\Http\Controllers;

use App\Models\OfficeBranch;
use App\Models\ProductStockBatch;
use App\Models\ProductVariations;
use App\Models\Stock;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $auth=Auth::guard('employee')->user();
       if($auth->role->name=='Super Admin'||$auth->role->name=='CE0'||$auth->role->name=='Stock Manager'){
           $warehouses=Warehouse::with('branch','main_warehouse')->get();
           $branches=OfficeBranch::all();

//        dd($branches);
           $warehouse_qty=[];
           foreach ($warehouses as $warehouse){
               $product=Stock::where('warehouse_id',$warehouse->id)->get();
               $total=0;
               foreach ($product as $item){
                   $valuation=$item->stock_balance*$item->cos??0;
                   $total+=$valuation;
               }

               $warehouse_qty[$warehouse->id]=$total;
           }
       }else if ($auth->role->name=='Stock Controller'){
           $warehouses=Warehouse::with('branch','main_warehouse')->where('branch_id',$auth->office_branch_id)->get();
           $branches=OfficeBranch::where('id',$auth->office_branch_id)->get();

//        dd($branches);
           $warehouse_qty=[];
           foreach ($warehouses as $warehouse){
               $product=Stock::where('warehouse_id',$warehouse->id)->get();
               $total=0;
               foreach ($product as $item){
                   $valuation=$item->stock_balance*$item->cos??0;
                   $total+=$valuation;
               }

               $warehouse_qty[$warehouse->id]=$total;
           }
       }else{
           $warehouses=Warehouse::with('branch','main_warehouse')->where('id',$auth->warehouse_id)->get();
           $branches=OfficeBranch::where('id',$auth->office_branch_id)->get();

//        dd($branches);
           $warehouse_qty=[];
           foreach ($warehouses as $warehouse){
               $product=Stock::where('warehouse_id',$warehouse->id)->get();
               $total=0;
               foreach ($product as $item){
                   $valuation=$item->stock_balance*$item->cos??0;
                   $total+=$valuation;
               }

               $warehouse_qty[$warehouse->id]=$total;
           }
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
        $branch=OfficeBranch::where('id',$request->branch_id)->first();
        $branch->warehouse_created=1;
        $branch->status=1;
        $branch->update();

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
        $stocks->branch_id=$request->branch_id;
        $stocks->mobile_warehouse=$request->mobile_warehouse??0;
        $stocks->update();
        $office_branch=OfficeBranch::where('id',$request->branch_id)->first();
        $office_branch->status=1;
        $office_branch->update();
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
