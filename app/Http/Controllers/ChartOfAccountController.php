<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use App\Models\COAType;
use Illuminate\Http\Request;

class ChartOfAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coas=ChartOfAccount::all();
        $types=COAType::all();
        return view('ChartOfAccount.index',compact('coas','types'));
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
            'code'=>'required',
            'type'=>'required'
        ]);
        ChartOfAccount::create($request->all());
        return redirect('chartofaccount')->with('success','Add new chart of account success!');
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
        $this->validate($request,[
            'name'=>'required',
            'code'=>'required',
            'type'=>'required'
        ]);
        $coa=ChartOfAccount::where('id',$id)->first();
        $coa->update($request->all());
        return redirect('chartofaccount')->with('success','Updated Successful');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coa=ChartOfAccount::where('id',$id)->firstOrFail();
        $coa->delete();
        return redirect('chartofaccount')->with('success','Deleted Successful');
    }
    public function coatype_index(){
        $type=COAType::all();
        return view('ChartOfAccount.accountype',compact('type'));
    }
    public function coatype(Request $request){
        COAType::create($request->all());
        return redirect('coatype')->with('success','Add new Account Type');
    }
}
