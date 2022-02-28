<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class BankTransferController extends Controller
{
    public function index(){

    }
    public function create(){
        $acount=Account::all();
        return view('transaction.banktransfer',compact('acount'));
    }
    public function store(){

    }
    public function edit($id){

    }
    public function update(Request $request,$id){

    }
    public function show($id){

    }
    public function destroy($id){

    }
}
