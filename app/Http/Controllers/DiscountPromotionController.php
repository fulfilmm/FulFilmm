<?php

namespace App\Http\Controllers;

use App\Models\DiscountPromotion;
use App\Models\OfficeBranch;
use App\Models\ProductVariations;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscountPromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth=Auth::guard('employee')->user();
        if($auth->role->name=='Super Admin'||$auth->role->name=='CEO'){
            $promo_discounts=DiscountPromotion::with('variant','region')->get();
        }else{
            $promo_discounts=DiscountPromotion::with('variant','region')->where('region_id',$auth->region_id)->get();
        }

        return view('sale.DiscountAndPromotion.index',compact('promo_discounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $auth=Auth::guard('employee')->user();
        if($auth->role->name=='Super Admin'||$auth->role->name=='CEO'){
            $region=Region::all();
        }else{
            $region=Region::where('id',$auth->region_id)->get();
        }
        $products=ProductVariations::all();

        return view('sale.DiscountAndPromotion.create',compact('products','region'));
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
            'rate'=>'required',
            'variant_id'=>'required',
            'type'=>'required',
            'start_date'=>'nullable',
            'end_date'=>'nullable',
            'description'=>'nullable',
            'sale_type'=>'required',
            'region_id'=>'required'

        ]);
        DiscountPromotion::create($request->all());
        return redirect(route('discount_promotions.index'));
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
        $pro_discount=DiscountPromotion::where('id',$id)->first();
        $products=ProductVariations::all();
        $auth=Auth::guard('employee')->user();
        if($auth->role->name=='Super Admin'||$auth->role->name=='CEO'){
            $region=Region::all();
        }else{
            $region=Region::where('id',$auth->region_id)->get();
        }
        return view('sale.DiscountAndPromotion.edit',compact('pro_discount','products','region'));
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
        $data=DiscountPromotion::where('id',$id)->first();
        $data->update($request->all());
        return redirect(route('discount_promotions.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data=DiscountPromotion::where('id',$id)->firstOrFail();
        $data->delete();
    }
}
