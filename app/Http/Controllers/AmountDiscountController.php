<?php

namespace App\Http\Controllers;

use App\Models\AmountDiscount;
use App\Models\OfficeBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AmountDiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth=Auth::guard('employee')->user();
        if($auth->role->name=='Super Admin'||$auth->role->name=='CEO'||$auth->role->name=='Sale Manager'){
            $discount=AmountDiscount::with('branch')->get();
            $branch=OfficeBranch::all();
        }else{
            $discount=AmountDiscount::with('branch')->where('branch_id',$auth->office_branch_id)->get();
            $branch=OfficeBranch::where('id',$auth->office_branch_id)->get();
        }
        return view('sale.DiscountAndPromotion.amount_discount',compact('discount','branch'));
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
           'sale_type'=>'required',
           'min_amount'=>'required',
           'max_amount'=>'required',
           'rate'=>'required'
        ]);
        AmountDiscount::create($request->all());
        return redirect('discount')->with('success','Added new amount discount');
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
        $discount=AmountDiscount::where('id',$id)->first();
        $discount->update($request->all());
        return redirect('discount')->with('success','Updated  amount discount');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dis_amount=AmountDiscount::where('id',$id)->first();
        $dis_amount->delete();
        return redirect('discount')->with('success','Deleted  amount discount');
    }
}
