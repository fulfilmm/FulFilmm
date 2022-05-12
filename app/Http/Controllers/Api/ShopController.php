<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ShopLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index()
    {
        $user=Auth::guard('api')->user();
        if($user->role->name=='Super Admin'||$user->role->name=='CEO'){
            $shops=ShopLocation::with('employee')->get();
        }else{
            $shops=ShopLocation::with('employee')->where('branch_id',$user->office_branch_id)->get();
        }

        return response()->json(['shops'=>$shops]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        return view('sale.SaleWay.Shop.create');
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
        return response()->json(['message'=>'Added new shop']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shop=ShopLocation::where('id',$id)->first();
        return response()->json(['shop'=>$shop]);
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
        return response()->json(['shop'=>$shop]);
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
        return response()->json(['shop'=>$shop]);
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
