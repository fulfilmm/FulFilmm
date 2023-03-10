<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SaleWay;
use App\Models\ShopLocation;
use App\Models\way_assign_shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=Auth::guard('api')->user();
        if($user->role->name=='Super Admin'||$user->role->name=='CEO'){
            $sales_ways=SaleWay::all();
        }else{
            $sales_ways=SaleWay::where('branch_id',$user->office_branch_id)->get();
        }

        return response()->json(['sales_ways'=>$sales_ways]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shops=ShopLocation::all()->pluck('name','id')->all();
        return response()->json(['shops'=>$shops]);
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
            'shop_id'=>'required',
            'way_id'=>'required',
            'branch_id'=>'required',
        ]);
        $way=SaleWay::create($request->all());
//        return response()->json([$request->shop_id]);
        foreach ($request->shop_id as $key=>$val){
            $shop=ShopLocation::where('id',$val)->first();
            $data['reach_location']=$shop->location;
            $data['shop_id']=$val;
            $data['way_id']=$way->id;
            $data['branch_id']=Auth::guard('api')->user()->office_branch_id;
            way_assign_shop::create($data);
        }
        return response()->json(['message'=>'Success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $way=SaleWay::where('id',$id)->first();
        $assgin_shop=way_assign_shop::with('shop')->where('way_id',$id)->get();
        $shops=ShopLocation::all()->pluck('name','id')->all();

        return response()->json(['way'=>$way,'assign_shop'=>$assgin_shop,'shops'=>$shops]);
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
    public function remove_shop(Request $request){
        $no_shop=count($request->shop_id);
        foreach ($request->shop_id as $key=>$val){
            $assign_shop=way_assign_shop::where('id',$val)->first();
            $assign_shop->delete();

        }
        return response()->json(['message','Remove'.$no_shop]);
    }
    public function add_shop(Request $request){
        $no_shop=count($request->shop_id);
        foreach ($request->shop_id as $key=>$val){
            $exits=way_assign_shop::where('shop_id',$val)->where('way_id',$request->way_id)->first();
            if($exits==null){
                $shop=ShopLocation::where('id',$val)->first();
                $data['reach_location']=$shop->location;
                $data['shop_id']=$val;
                $data['way_id']=$request->way_id;
                way_assign_shop::create($data);
            }
        }
        return response()->json(['message'=>'Added '.$no_shop.' shops']);
    }
}
