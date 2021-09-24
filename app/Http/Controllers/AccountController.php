<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\MainCompany;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account=Account::all();
        return view('account.index',compact('account'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company=MainCompany::where('ismaincompany',true)->first();
        return view('account.create',compact('company'));
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
            'number'=>'required',
            'currency'=>'required',
            'company_id'=>'required'

        ]);
        Account::create($request->all());
        return redirect(route('accounts.index'))->with('success','New Account Create Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $account=Account::where('id',$id)->first();
        $transaction=Transaction::with('revenue','expense')->where('account_id',$id)->get();
        $incoming=0;$outgoing=0;
        foreach ($transaction as $tran){
            if($tran->type=='Revenue'){
                $incoming=$incoming+$tran->revenue->amount;
            }else{
                $outgoing=$outgoing+$tran->expense->amount;
            }
        }
        return view('account.show',compact('account','transaction','outgoing','incoming'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $account=Account::where('id',$id)->first();
        return view('account.edit',compact('account'));
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
        $account=Account::where('id',$id)->first();
         $account->name=$request->name;
         $account->number=$request->number;
         $account->currency=$request->currency;
         $account->opening_balance=$request->opening_balance;
         $account->bank_name=$request->bank_name;
         $account->bank_phone=$request->bank_phone;
         $account->bank_address=$request->bank_address;
         $account->enabled=$request->enable;
         $account->update();
        return redirect(route('accounts.show',$account->id));
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
