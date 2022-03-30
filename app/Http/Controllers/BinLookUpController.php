<?php

namespace App\Http\Controllers;

use App\Models\BinLookUp;
use Illuminate\Http\Request;

class BinLookUpController extends Controller
{
    public function index(){
        $binlookup=BinLookUp::all();
        return view('Inventory.BinLookUp.index',compact('binlookup'));
    }
    public function create(){
        return view('Inventory.BinLookUp.create');
    }
    public function store(Request $request){
        $this->validate($request,[
            'bin_no'=>'required',
            'location'=>'required',

        ]);
        BinLookUp::create($request->all());
        return redirect('binlookup')->with('success','New Bin Create Success');
    }
    public function edit($id){
        $binlookup=BinLookUp::where('id',$id)->first();
        return view('Inventory.BinLookUp.edit',compact('binlookup'));
    }
    public function update(Request $request,$id){
        $binlookup=BinLookUp::where('id',$id)->first();
        $binlookup->update($request->all());
        return redirect('binlookup')->with('success','Updated Bin Look Up');
    }
    public function show($id){

    }
    public function destroy($id){
        $binlookup=BinLookUp::where('id',$id)->first();
        $binlookup->delete();
        return redirect('binlookup')->with('success','Deleted Bin Look Up');
    }
}
