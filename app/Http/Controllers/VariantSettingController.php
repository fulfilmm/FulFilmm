<?php

namespace App\Http\Controllers;

use App\Models\VariantKey;
use App\Models\VariantValue;
use Illuminate\Http\Request;

class VariantSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $variants=VariantKey::all();
        $variants_value=VariantValue::all();
        return view('product.variantsetting',compact('variants','variants_value'));
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
//        dd($request->all());
        VariantKey::create($request->all());
    }
    public function value_add(Request $request){
       foreach ($request->value as $item){
           $value=new VariantValue();
           $value->variant_key=$request->variant_key;
           $value->value=$item;
           $value->save();
       }
       return redirect('product/variant/setting');
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
    public function active(Request $request,$id){
        $variant=VariantKey::where('id',$id)->first();
        $variant->active=$request->enable;
        $variant->update();
        return response()->json(['Account'=>$request->enable?'Active':'Deactive']);
    }
}
