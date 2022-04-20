<?php

namespace App\Http\Controllers;

use App\Models\DiscountPromotion;
use App\Models\OfficeBranch;
use App\Models\ProductVariations;
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
            $promo_discounts=DiscountPromotion::with('variant','branch')->get();
        }else{
            $promo_discounts=DiscountPromotion::with('variant','branch')->where('branch_id',$auth->office_branch_id)->get();
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
            $branch=OfficeBranch::all();
        }else{
            $branch=OfficeBranch::where('id',$auth->office_branch_id)->get();
        }
        $products=ProductVariations::all();

        return view('sale.DiscountAndPromotion.create',compact('products','branch'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
            $branch=OfficeBranch::all();
        }else{
            $branch=OfficeBranch::where('id',$auth->office_branch_id)->get();
        }
        return view('sale.DiscountAndPromotion.edit',compact('pro_discount','products','branch'));
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
