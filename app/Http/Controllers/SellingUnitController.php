<?php

namespace App\Http\Controllers;

use App\Imports\PriceImport;
use App\Models\OfficeBranch;
use App\Models\product;
use App\Models\product_price;
use App\Models\ProductVariations;
use App\Models\Region;
use App\Models\SellingPriceRule;
use App\Models\SellingUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SellingUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sellingunits=SellingUnit::with('product')->get();
        return view('sale.sellingunit.index',compact('sellingunits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products=product::all();
        return view('sale.sellingunit.create',compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach ($request->product_id as $p_id){
            $data['product_id']=$p_id;
            $data['unit']=$request->unit;
            $data['unit_convert_rate']=$request->unit_convert_rate;
            SellingUnit::create($data);
        }
        return redirect(route('sellingunits.index'));
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
        $unit=SellingUnit::where('id',$id)->firstOrFail();
        $products=ProductVariations::all();
        return view('sale.sellingunit.edit',compact('unit','products'));
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
        $unit=SellingUnit::where('id',$id)->first();
        $unit->unit=$request->unit;
        $unit->unit_convert_rate=$request->unit_convert_rate;
//        $unit->product_id=$request->product_id;
        $unit->update();
        return redirect(route('sellingunits.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $unit=SellingUnit::where('id',$id)->firstOrFail();
        $unit->delete();
        return redirect(route('sellingunits.index'));
    }
    public function price_list(){
//        dd('je;p');
        $units=SellingUnit::all();
        if(Auth::guard('employee')->user()->role->name=='Super Admin'||Auth::guard('employee')->user()->role->name=='CEO'){
            $price_lists=product_price::with('unit','variant','region')->get();
            $region=Region::all()->pluck('name','id')->all();
        }else{
            $price_lists=product_price::with('unit','variant','region')->where('region_id',Auth::guard('employee')->user()->region_id)->get();
            $region=Region::where('id',Auth::guard('employee')->user()->region_id)->pluck('name','id')->all();
        }
        $product=product::all()->pluck('product_code','id')->all();
        return view('sale.sellingunit.price',compact('price_lists','units','region','product'));
    }
    public function price_add(){
        $units=SellingUnit::all();
        $main_product=product::all();
        $products=ProductVariations::all();
        if(Auth::guard('employee')->user()->role->name=='Super Admin'||Auth::guard('employee')->user()->role->name=='CEO'){
            $branch=OfficeBranch::all();
            $region=Region::with('branch')->get();
        }else{
            $branch=OfficeBranch::select('id','name')->where('id',Auth::guard('employee')->user()->office_branch_id)->get();
            $region=Region::with('branch')->where("branch_id",Auth::guard('employee')->user()->office_branch_id)->get();
        }
//        dd($branch);
        return view('sale.sellingunit.price_add',compact('units','main_product','products','branch','region'));
    }
    public function store_price(Request $request){
//        dd($request->all());
        $this->validate($request,[
           'product_id'=>'required',
           'unit_id'=>'required',
           'sale_type'=>'required',
            'region_id'=>'required'
        ]);
        foreach ($request->region_id as $region_id){
            foreach ($request->product_id as $item){
            for($i=0;$i<count($request->row_no);$i ++){
                $data['product_id']=$item;
                $data['unit_id']=$request->unit_id;
                $data['sale_type']=$request->sale_type;
                $data['price']=$request->price[$i];
                $data['min']=$request->min_qty[$i];
                $data['max']=$request->max_qty[$i];
                $data['start_date']=$request->start_date[$i];
                $data['end_date']=$request->end_date[$i];
                $data['region_id']=$region_id;
                product_price::create($data);
            }
            }
        }
        return redirect(route('add.index'));
    }
    public function price_active($status,$id){
        $price=product_price::where('id',$id)->firstOrFail();
     if($status=='active'){
         $price->active=1;
     }else{
         $price->active=0;
     }
        $price->update();
     return redirect()->back();
    }
    public function price_destory($id){
        $price=product_price::where('id',$id)->firstOrFail();
        $price->delete();
        return redirect()->back();
    }
    public function update_price(Request $request,$id){
        $price=product_price::where('id',$id)->firstOrFail();
        if(isset($request->price_type)){
            $price->multi_price=$request->price_type;
        }else{
            $price->price=$request->price;
        }
        $price->update();
        return redirect()->back();
    }
    public function price_import(Request $request){
        Excel::import(new PriceImport(),$request->file('import'));
        return redirect('product/price/index')->with('success','Success prices import');
    }
}
