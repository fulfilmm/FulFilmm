<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\product_price;
use App\Models\ProductVariations;
use App\Models\SellingUnit;
use Illuminate\Http\Request;

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
        $price_lists=product_price::with('unit','variant')->get();
        return view('sale.sellingunit.price',compact('price_lists'));
    }
    public function price_add(){
        $units=SellingUnit::all();
        $main_product=product::all();
        $products=ProductVariations::all();
        return view('sale.sellingunit.price_add',compact('units','main_product','products'));
    }
    public function store_price(Request $request){
//        dd($request->all());
        $this->validate($request,[
           'product_id'=>'required',
           'unit_id'=>'required',
           'sale_type'=>'required',
        ]);

       foreach ($request->product_id as $item){
           $unit=SellingUnit::where('id',$request->unit_id)->first();
           $unit->active=1;
           $unit->update();
           $exist_price=product_price::where('product_id',$item)->where('sale_type',$request->sale_type)->where('unit_id',$request->unit_id)->where('active',1)->first();
           $single_data['product_id']=$item;
           $single_data['unit_id']=$request->unit_id;
           $single_data['sale_type']=$request->sale_type;
           $single_data['price']=$request->single_price;
           $single_data['multi_price']=0;
           if($exist_price==null) {
               product_price::create($single_data);
           }else{
               $exist_price->active=0;
               $exist_price->update();
               product_price::create($single_data);
           }

           if($request->type=='multi'){
             for($i=0;$i<count($request->row_no);$i ++){
                 $data['product_id']=$item;
                 $data['unit_id']=$request->unit_id;
                 $data['sale_type']=$request->sale_type;
                 $data['price']=$request->price[$i];
                 $data['multi_price']=1;
                 $data['rule']=$request->rule[$i];
                 $data['min']=$request->min_qty[$i];
                 $data['max']=$request->max_qty[$i];
                 $data['start_date']=$request->start_date[$i];
                 $data['end_date']=$request->end_date[$i];
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
        $price->update($request->all());
        return redirect()->back();
    }
}
