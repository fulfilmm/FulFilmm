<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OfficeBranch;
use App\Models\Region;
use App\Models\SaleZone;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth=Auth::guard('api')->user();

//
        $companies=Company::all();
        $branch=OfficeBranch::where('id',$auth->office_branch_id)->get();

        $regions=[];
        $zones=[];
        foreach ($branch as $bh) {
            $region=Region::where('branch_id',$bh->id)->get();
            if(count($region)!=0){
                array_push($regions,$region);
            }
            foreach ($region as $reg){
                $zone=SaleZone::where('region_id',$reg->id)->get();

                if(count($zone)!=0){
                    array_push($zones,$zone);
                }
            }

        }



        return response()->json(['result'=>$auth,'branch'=>$branch,'region'=>$regions,'zone'=>$zones,'con'=>true]);
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
        //
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
}
