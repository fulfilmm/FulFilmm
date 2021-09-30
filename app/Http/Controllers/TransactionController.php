<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\MainCompany;
use App\Models\Revenue;
use App\Models\Transaction;
use App\Models\TransactionCategory;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions=Transaction::with('expense','revenue','account')->get();
        return view('transaction.index',compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function expense()
    {
        $account=Account::all()->pluck('name','id')->all();
        $recurring=['No','Daily','Weekly','Monthly','Yearly'];
        $payment_method=['Cash','eBanking','WaveMoney','KBZ Pay'];
        $category=TransactionCategory::all();
        $customer=Customer::where('customer_type','Supplier')->get();
        $data=['customers'=>$customer,'account'=>$account,'recurring'=>$recurring,'payment_method'=>$payment_method,'category'=>$category];
        return view('transaction.expense',compact('data'));
    }
    public function expense_index(){

        $expense="Expense";
        $transactions=Transaction::with('expense','revenue','account')->where('type','Expense')->get();
        return view('transaction.index',compact('transactions','expense'));
    }
    public function revenue_index(){
        $revenue="Revenue";
        $transactions=Transaction::with('expense','revenue','account')->where('type','Revenue')->get();
        return view('transaction.index',compact('transactions','revenue'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function expense_store(Request $request)
    {
//        dd($request->all());
        $this->validate($request, [
            'transaction_date' => 'required',
            'amount' => 'required',
            'account' => 'required',
            'category' => 'required',
            'payment_method' => 'required',
        ]);
        $new_expense = new Expense();
        $new_expense->vendor_id = $request->customer_id;
        $new_expense->amount = $request->amount;
        $new_expense->reference = $request->reference;
        $new_expense->recurring = $request->recurring;
        $new_expense->payment_method = $request->payment_method;
        $new_expense->description = $request->description;
        $new_expense->category = $request->category;
        $new_expense->transaction_date = $request->transaction_date;
        $new_expense->emp_id = Auth::guard('employee')->user()->id;
        $new_expense->currency = $request->currency;
        if (isset($request->attachment)) {
            if ($request->attachment != null) {
                $name = $request->attachment->getClientOriginalName();
                $request->attachment->move(public_path() . '/attach_file', $name);

            }
            $new_expense->attachment=$name;
        }
        $new_expense->save();
        $this->transaction_add($request->account,$request->type,$new_expense->id,null);
        $this->account_update($request->amount,$request->account,$request->type);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction=Transaction::with('expense','revenue','account')->where('id',$id)->firstOrFail();
        $company=MainCompany::where('ismaincompany',true)->first();
        $customer=Customer::where('id',$transaction->type=='Revenue'?$transaction->revenue->customer_id:$transaction->expense->vendor_id)->first();
        $receiver=Employee::where('id',$transaction->type=='Revenue'?$transaction->revenue->emp_id:$transaction->expense->emp_id)->first();
        return view('transaction.show',compact('transaction','customer','receiver','company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function addrevenue()
    {  $account=Account::all()->pluck('name','id')->all();
        $recurring=['No','Daily','Weekly','Monthly','Yearly'];
        $payment_method=['Cash','eBanking','WaveMoney','KBZ Pay'];
        $category=TransactionCategory::all();
        $customer=Customer::orWhere('customer_type','Customer')->orWhere('customer_type','Lead')->orWhere('customer_type','Partner')->orWhere('customer_type','Inquery')->get();
        $data=['customers'=>$customer,'account'=>$account,'recurring'=>$recurring,'payment_method'=>$payment_method,'category'=>$category];
        return view('transaction.revenue',compact('data'));
    }

    public function store_revenue(Request $request)
    {
//        dd($request->all());
        $this->validate($request, [
            'transaction_date' => 'required',
            'amount' => 'required',
            'account' => 'required',
            'customer_id' => 'required',
            'category' => 'required',
            'payment_method' => 'required',
        ]);
        $new_revenue = new Revenue();
        $new_revenue->customer_id = $request->customer_id;
        $new_revenue->amount = $request->amount;
        $new_revenue->invoice_id = $request->invoice_id ?? null;
        $new_revenue->reference = $request->reference;
        $new_revenue->recurring = $request->recurring;
        $new_revenue->payment_method = $request->payment_method;
        $new_revenue->description = $request->description;
        $new_revenue->category = $request->category;
        $new_revenue->transaction_date = $request->transaction_date;
        $new_revenue->emp_id = Auth::guard('employee')->user()->id;
        $new_revenue->currency = $request->currency;
        if (isset($request->attachment)) {
            if ($request->attachment != null) {
                $name = $request->attachment->getClientOriginalName();
                $request->attachment->move(public_path() . '/attach_file', $name);

            }
            $new_revenue->attachment=$name;
        }
        $new_revenue->save();
        $this->transaction_add($request->account,$request->type,null,$new_revenue->id);
        $this->account_update($request->amount,$request->account,$request->type);
        return redirect()->back();
    }
    public function transaction_add($account_id,$type,$expense_id,$revenue_id){
        $transaction=new Transaction();
        $transaction->type=$type;
        $transaction->account_id=$account_id;
        $transaction->expense_id=$expense_id;
        $transaction->revenue_id=$revenue_id;
        $transaction->save();
    }
    public function add_category(Request $request){
        TransactionCategory::create($request->all());
        return response()->json([
           'Success'=>'New Category Add Success'
        ]);
    }
    public function account_update($amount, $id,$type)
    {
        $account=Account::where('id',$id)->first();
        if($type=='Revenue'){
            $account->balance=$account->opening_balance + $amount;
        }else{
            $account->balance=$account->opening_balance - $amount;
        }
        $account->update();
    }
}
