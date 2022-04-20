<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\MainCompany;
use App\Models\OfficeBranch;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = Auth::guard('employee')->user();
        if ($auth->role->name == 'CEO' || $auth->role->name == 'Super Admin' || $auth->role->name == 'Finance Manager') {
            $account = Account::with('branch')->get();
        } else {
            $account = Account::with('branch')->where('branch_id', $auth->office_branch_id)->get();
        }

        return view('account.index', compact('account'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $auth = Auth::guard('employee')->user();
        if ($auth->role->name == 'CEO' || $auth->role->name == 'Super Admin' || $auth->role->name == 'Finance Manager') {
            $company = MainCompany::where('ismaincompany', true)->first();
            $branch = OfficeBranch::all()->pluck('name', 'id')->all();
            return view('account.create', compact('company', 'branch'));
        } else {
            return redirect()->back()->with('warning', 'Sorry!You can not create a new account.Super Admin,CEO and Finance Manager only can create a new bank account');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $this->validate($request, [
            'account_id' => 'required',
            'name' => 'required',
            'number' => 'required',
            'currency' => 'required',

        ]);
        $account = new Account();
        $account->account_no = $request->account_id;
        $account->name = $request->name;
        $account->number = $request->number;
        $account->currency = $request->currency;
        $account->company_id = $request->company_id;
        $account->bank_address = $request->bank_address;
        $account->balance = $request->balance ?? 0;
        $account->opening_balance = $request->balance ?? 0.0;
        $account->enabled = $request->enable ?? 0;
        $account->bank_name = $request->bank_name;
        $account->bank_phone = $request->bank_phone;
        $account->branch_id = $request->branch_id;
        $account->save();
        return redirect(route('accounts.index'))->with('success', 'New Account Create Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $auth = Auth::guard('employee')->user();
        if ($auth->role->name == 'CEO' || $auth->role->name == 'Super Admin' || $auth->role->name == 'Finance Manager') {
            $account = Account::where('id', $id)->firstOrFail();
            $transaction = Transaction::with('revenue', 'expense')->where('account_id', $id)->get();
            $incoming = 0;
            $outgoing = 0;
            foreach ($transaction as $tran) {
                if ($tran->type == 'Revenue') {
                    $incoming = $incoming + $tran->revenue->amount;
                } else {
                    $outgoing = $outgoing + $tran->expense->amount;
                }
            }
        } else {
            $account = Account::where('id', $id)->where('branch_id', $auth->office_branch_id)->firstOrFail();
            $transaction = Transaction::with('revenue', 'expense')->where('account_id', $id)->get();
            $incoming = 0;
            $outgoing = 0;
            foreach ($transaction as $tran) {
                if ($tran->type == 'Revenue') {
                    $incoming = $incoming + $tran->revenue->amount;
                } else {
                    $outgoing = $outgoing + $tran->expense->amount;
                }
            }
        }
        return view('account.show', compact('account', 'transaction', 'outgoing', 'incoming'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $auth = Auth::guard('employee')->user();
        if ($auth->role->name == 'CEO' || $auth->role->name == 'Super Admin' || $auth->role->name == 'Finance Manager') {
            $account = Account::where('id', $id)->first();
            $branch=OfficeBranch::all()->pluck('name','id')->all();
            return view('account.edit', compact('account','branch'));
        }else{
            return redirect()->back()->with('warning', 'Sorry!You can not edit account.Super Admin,CEO and Finance Manager only can edit account');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        dd($request->all());
        $auth = Auth::guard('employee')->user();
        if ($auth->role->name == 'CEO' || $auth->role->name == 'Super Admin' || $auth->role->name == 'Finance Manager') {
            $account = Account::where('id', $id)->first();
            $account->account_no = $request->account_id;
            $account->name = $request->name;
            $account->number = $request->number;
            $account->currency = $request->currency;
            $account->opening_balance = $request->opening_balance;
            $account->bank_name = $request->bank_name;
            $account->bank_phone = $request->bank_phone;
            $account->branch_id = $request->branch_id;
            $account->bank_address = $request->bank_address;
            $account->enabled = $request->enable ?? 0;
            $account->update();
            return redirect(route('accounts.show', $account->id));
        }else{
            return redirect()->back()->with('warning', 'Sorry!You can not update account.Super Admin,CEO and Finance Manager only can update account');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account = Account::where('id', $id)->first();
        $account->delete();
        return redirect()->back()->with('success', 'Account Delete Success');
    }

    public function enable(Request $request, $id)
    {
        $account = Account::where('id', $id)->first();
        $account->enabled = $request->enable;
        $account->update();
        return response()->json(['Account' => $request->enable == 1 ? 'Enabled' : 'Disabled']);
    }
}
