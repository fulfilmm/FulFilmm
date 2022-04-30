<?php

namespace App\Http\Controllers;

use App\Models\ShopLocation;
use Illuminate\Http\Request;

class ShopRegister extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shops=ShopLocation::with('employee')->get();
        return view('sale.SaleWay.Shop.index',compact('shops'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sale.SaleWay.Shop.create');
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
        $this->validate($request,[
           'name'=>'required',
            'location'=>'required',
            'customer_id'=>'nullable',
            'picture'=>'nullable',
            'contact'=>'required',
            'phone'=>'required',
            'description'=>'nullable'
        ]);
        ShopLocation::create($request->all());
        return redirect('shop')->with('success','Added new shop');
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
        $shop=ShopLocation::where('id',$id)->firstorFail();
        return view('sale.SaleWay.Shop.edit',compact('shop'));
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
        $shop=ShopLocation::where('id',$id)->firstorFail();
        $shop->update($request->all());
        return redirect('shop')->with('success','Updated shop');
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
