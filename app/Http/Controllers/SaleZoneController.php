<?php

namespace App\Http\Controllers;

use App\Models\OfficeBranch;
use App\Models\Region;
use App\Models\SaleZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth=Auth::guard('employee')->user();
        $region=Region::all();
        if($auth->role->name=='Super Admin'||$auth->role->name=='CEO'||$auth->role->name=='Sale Manager'){
            $branch=OfficeBranch::all();
            $zones=SaleZone::all();
        }else{
            $zones=[];
            $region=Region::where('branch_id',$auth->office_branch_id)->get();
            foreach ($region as $reg){
                $sale=SaleZone::where('region_id',$reg->id)->get();
                foreach ($sale as $item){
                    array_push($zones,$item);
                }
            }

            $branch=OfficeBranch::where('id',$auth->office_branch_id)->get();
        }
//        dd($zones);
        return view('customer.salezone',compact('zones','region','branch'));
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
        $this->validate($request,['name'=>'required']);
        SaleZone::create($request->all());

        return redirect()->back()->with('success','Added New Zone');
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
        $zone=SaleZone::where('id',$id)->first();
        $zone->update($request->all());
        return redirect('salezone')->with('Updated Zone');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $zone=SaleZone::where('id',$id)->first();
        $zone->delete();
        return redirect('salezone')->with('danger','Deleted Sale Zone');
    }
}
