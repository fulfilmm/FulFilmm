<?php

namespace App\Http\Controllers;

use App\Imports\RegionImport;
use App\Models\OfficeBranch;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth=Auth::guard('employee')->user();
      if($auth->role->name=='Super Admin'||$auth->role->name=="CEO"){
          $regions=Region::with('branch')->get();
          $branch=OfficeBranch::all();
      }else{
          $regions=Region::with('branch')->where('branch_id',$auth->office_branch_id)->get();
          $branch=OfficeBranch::where('id',$auth->office_branch_id)->get();
      }

        return view('customer.region',compact('regions','branch'));
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
        $this->validate($request,[
           'name'=>'required',
           'branch_id'=>'required'
        ]);
        Region::create($request->all());
        $office_branch=OfficeBranch::where('id',$request->branch_id)->first();
        $office_branch->status=1;
        $office_branch->update();
        return redirect()->back()->with('success','Added new Region');
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
        $region=Region::where('id',$id)->first();
        $region->update($request->all());
        $office_branch=OfficeBranch::where('id',$request->branch_id)->first();
        $office_branch->status=1;
        $office_branch->update();
        return redirect()->back()->with('success','Added new Region');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $region=Region::where('id',$id)->first();
        $region->delete();
        return redirect()->back()->with('success','Deleted successful');
    }
    public function import(Request $request){
//        dd($request->all());
        Excel::import(new RegionImport(), $request->file('import'));
        return redirect('region')->with('message','Import successful');
    }
}
