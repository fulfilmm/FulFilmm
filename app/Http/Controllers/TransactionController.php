<?php

namespace App\Http\Controllers;

use App\Exports\BankTransactionExport;
use App\Models\Account;
use App\Models\Bill;
use App\Models\ChartOfAccount;
use App\Models\Customer;
use App\Models\DeliveryOrder;
use App\Models\DeliveryPay;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\ExpenseBudget;
use App\Models\ExpenseClaim;
use App\Models\Invoice;
use App\Models\MainCompany;
use App\Models\Revenue;
use App\Models\RevenueBudget;
use App\Models\Transaction;
use App\Models\TransactionCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;


class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::with('expense', 'revenue', 'account')->get();
        $employees = Employee::all()->pluck('name', 'id')->all();
        $invoice = Invoice::all()->pluck('invoice_id', 'id')->all();
        $bill = Bill::all()->pluck('bill_id', 'id')->all();
        return view('transaction.index', compact('transactions', 'employees', 'invoice', 'bill'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function expense()
    {
        $account = Account::where('enabled', 1)->get();
        $recurring = ['No', 'Daily', 'Weekly', 'Monthly', 'Yearly'];
        $payment_method = ['Cash', 'eBanking', 'WaveMoney', 'KBZ Pay'];
        $category = TransactionCategory::where('type',0)->get();
        $emps = Employee::all();
        $coas=ChartOfAccount::all();
        $customer = Customer::where('customer_type', 'Supplier')->get();
        $data = ['coas'=>$coas,'emps' => $emps, 'customers' => $customer, 'account' => $account, 'recurring' => $recurring, 'payment_method' => $payment_method, 'category' => $category];
        return view('transaction.expense', compact('data'));
    }

    public function expense_index()
    {
        $expenses = Expense::with('cat','supplier', 'approver', 'employee','bill','account')->get();
        return view('transaction.expense_index', compact('expenses'));
    }

    public function revenue_index()
    {
        $revenues =Revenue::with('account','cat','employee','approver','invoice')->get();
        return view('transaction.revenue_index', compact( 'revenues'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function expense_store(Request $request)
    {

        $this->validate($request, [
            'title'=>'required',
            'transaction_date' => 'required',
            'amount' => 'required',
            'account' => 'required',
            'category' => 'required',
            'payment_method' => 'required',
            'approver_id'=>'required',
            'attachment' => 'mimes:pdf,xlsx,doc,docx,jpg,jpeg,ppt,bip,|max:2048',
        ]);
        $new_expense = new Expense();
        $new_expense->title=$request->title;
        $new_expense->vendor_id = $request->customer_id;
        $new_expense->amount = $request->amount;
        $new_expense->reference = $request->reference;
        $new_expense->recurring = $request->recurring;
        $new_expense->payment_method = $request->payment_method;
        $new_expense->description = $request->description;
        $new_expense->category = $request->category;
        $new_expense->approver_id = $request->approver_id;
        $new_expense->coa_id=$request->coa_account;
        $new_expense->transaction_date = $request->transaction_date;
        $new_expense->emp_id = Auth::guard('employee')->user()->id;
        $new_expense->currency = $request->currency;
        $new_expense->bill_id = $request->bill_id ?? null;
        if (isset($request->attachment)) {
            if ($request->attachment != null) {
                $attach=$request->file('attachment');
                $input['filename'] =\Illuminate\Support\Str::random(10).time().'.'.$attach->extension();
                $request->attachment->move(public_path() . '/attach_file', $input['filename']);

            }
            $new_expense->attachment = $input['filename'];
        }
        $new_expense->save();
        if(isset($request->exp_id)){
            $exp=ExpenseClaim::where('id',$request->exp_id)->first();
            $exp->is_claim=1;
            $exp->update();
        }
        $this->transaction_add($request->account, $request->type, $new_expense->id, null);
        $last_tran = Transaction::orderBy('id', 'desc')->first();
        if (isset($request->bill_id)) {
            $bill = Bill::where('id', $request->bill_id)->first();
            $bill->due_amount = $bill->due_amount - $request->amount;
            $bill->update();
            return redirect(route('bills.show', $request->bill_id))->with('success', 'Add New Expense Successful');
        } else {
            return redirect(route('transactions.show', $last_tran->id))->with('success', 'Add New Expense Successful');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = Transaction::with('expense', 'revenue', 'account')->where('id', $id)->firstOrFail();
        $company = MainCompany::where('ismaincompany', true)->first();
        $category=TransactionCategory::all();
        $coas=ChartOfAccount::all();
        $customer = Customer::where('id', $transaction->type == 'Revenue' ? $transaction->revenue->customer_id : $transaction->expense->vendor_id)->first();
        $receiver = Employee::where('id', $transaction->type == 'Revenue' ? $transaction->revenue->emp_id : $transaction->expense->emp_id)->first();
        return view('transaction.show', compact('transaction', 'customer', 'receiver', 'company','category','coas'));
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
    {
        $emps = Employee::all();
        $account = Account::where('enabled', 1)->get();
        $recurring = ['No', 'Daily', 'Weekly', 'Monthly', 'Yearly'];
        $payment_method = ['Cash', 'eBanking', 'WaveMoney', 'KBZ Pay'];
        $category = TransactionCategory::where('type',1)->get();
        $coas=ChartOfAccount::all();
        $customer = Customer::orWhere('customer_type', 'Customer')->orWhere('customer_type', 'Lead')->orWhere('customer_type', 'Partner')->orWhere('customer_type', 'Inquery')->get();
        $data = ['coas'=>$coas,'emps' => $emps, 'customers' => $customer, 'account' => $account, 'recurring' => $recurring, 'payment_method' => $payment_method, 'category' => $category];
        return view('transaction.revenue', compact('data'));
    }

    public function store_revenue(Request $request)
    {
       if($request->advance_id){
        $revenue=Revenue::where('advance_pay_id',$request->advance_id)->first();
        $revenue->invoice_id=$request->invoice_id;
           if (isset($request->attachment)) {
               if ($request->attachment != null) {
                   $attach=$request->file('attachment');
                   $input['filename'] =\Illuminate\Support\Str::random(10).time().'.'.$attach->extension();
                   $request->attachment->move(public_path() . '/attach_file', $input['filename']);

               }
               $revenue->attachment = $input['filename'];
           }
           $revenue->reference = $request->reference;
        $revenue->update();
           if (isset($request->invoice_id)) {
               $inv = Invoice::where('id', $request->invoice_id)->first();
               $inv->due_amount = $inv->due_amount - $request->amount;
               $inv->update();
               return redirect(route('invoices.show', $request->invoice_id))->with('success', 'Add New Revenue Successful');
           } else {
               $last_tran = Transaction::orderBy('id', 'desc')->first();
               return redirect(route('transactions.show', $last_tran->id))->with('success', 'Add New Revenue Successful');
           }

       }else{
           $this->validate($request, [
               'title'=>'required',
               'transaction_date' => 'required',
               'amount' => 'required',
               'customer_id' => 'required',
               'category' => 'required',
               'payment_method' => 'required',
               'approver_id'=>'required',
               'attachment' => 'mimes:pdf,xlsx,doc,docx,jpg,jpeg,ppt,bip'
           ]);
           $new_revenue = new Revenue();
           $new_revenue->title=$request->title;
           $new_revenue->customer_id = $request->customer_id;
           $new_revenue->amount = $request->amount;
           $new_revenue->invoice_id = $request->invoice_id ?? null;
           $new_revenue->reference = $request->reference;
           $new_revenue->recurring = $request->recurring;
           $new_revenue->payment_method = $request->payment_method;
           $new_revenue->description = $request->description;
           $new_revenue->category = $request->category;
           $new_revenue->approver_id = $request->approver_id;
           $new_revenue->advance_pay_id=$request->advance_id??null;
           $new_revenue->coa_id=$request->coa_account;
           $new_revenue->transaction_date = $request->transaction_date;
           $new_revenue->emp_id = Auth::guard('employee')->user()->id;
           $new_revenue->currency = $request->currency;
           if (isset($request->attachment)) {
               if ($request->attachment != null) {
                   $attach=$request->file('attachment');
                   $input['filename'] =\Illuminate\Support\Str::random(10).time().'.'.$attach->extension();
                   $request->attachment->move(public_path() . '/attach_file', $input['filename']);

               }
               $new_revenue->attachment = $input['filename'];
           }
           if ($request->payment_method == 'Advance Payment') {
               $new_revenue->approve = 1;
           }
           $new_revenue->save();
           if(isset($request->invoice_id )){
               $delivery=DeliveryOrder::where('invoice_id',$request->invoice_id)->first();
             if($delivery!=null){
                 $deli_pay=DeliveryPay::where('delivery_id',$delivery->id)->first();
                 $deli_pay->receiver_invoice_amount=1;
                 $deli_pay->update();
             }
           }
           $this->transaction_add($request->account, $request->type, null, $new_revenue->id);
           if (isset($request->invoice_id)) {
               $inv = Invoice::where('id', $request->invoice_id)->first();
               $inv->due_amount = $inv->due_amount - $request->amount;
               $inv->update();
               return redirect(route('invoices.show', $request->invoice_id))->with('success', 'Add New Revenue Successful');
           } else {
               $last_tran = Transaction::orderBy('id', 'desc')->first();
               return redirect(route('transactions.show', $last_tran->id))->with('success', 'Add New Revenue Successful');
           }
       }
    }

    public function transaction_add($account_id, $type, $expense_id, $revenue_id)
    {
        $transaction = new Transaction();
        $transaction->type = $type;
        $transaction->account_id = $account_id;
        $transaction->expense_id = $expense_id;
        $transaction->revenue_id = $revenue_id;
        $transaction->save();
    }

    public function add_category(Request $request)
    {
//        dd($request->all());
        TransactionCategory::create($request->all());
        return response()->json([
            'Success' => 'New Category Add Success'
        ]);
    }

    public function category()
    {
        $category = TransactionCategory::all();
        return view('transaction.category', compact('category'));
    }

    public function update_cat(Request $request, $id)
    {
//        dd($id);
        $category = TransactionCategory::where('id', $id)->first();
        $category->name = $request->cat_name;
        $category->update();
        return redirect()->back();
    }

    public function delete_cat($id)
    {
//        dd($id);
        $category = TransactionCategory::where('id', $id)->first();
        $category->delete();
        return redirect()->back();
    }

    public function account_update($id, $type)
    {
        if ($type == 'Revenue') {
            $revenue = Revenue::where('id', $id)->first();
            if ($revenue->approver_id == Auth::guard('employee')->user()->id) {
                $transaction = Transaction::where('revenue_id', $revenue->id)->first();
                $account = Account::where('id', $transaction->account_id)->first();
                $account->balance = $account->balance + $revenue->amount;
                $revenue->approve = 1;
                $revenue->update();
                $account->update();
                $rev_budget=RevenueBudget::where('category_id',$revenue->category)->where('year',Carbon::parse($revenue->transaction_date)->format('Y'))->where('month',Carbon::parse($revenue->transaction_date)->format('m'))->first();
                $rev_budget->actual=$rev_budget->actual + $revenue->amount;
                $rev_budget->update();
            } else {
                return redirect('revenue')->with('error', 'You can not approve');
            }
        } else {
            $expense = Expense::where('id', $id)->first();
            if ($expense->approver_id == Auth::guard('employee')->user()->id) {
                $transaction = Transaction::where('expense_id', $expense->id)->first();
                $account = Account::where('id', $transaction->account_id)->first();
                $account->balance = $account->balance - $expense->amount;
                $expense->approve = 1;
                $expense->update();
                $account->update();
                $exp_budget=ExpenseBudget::where('category_id',$expense->category)->where('year',Carbon::parse($expense->transaction_date)->format('Y'))->where('month',Carbon::parse($expense->transaction_date)->format('m'))->first();
                $exp_budget->actual=$exp_budget->actual??0 + $expense->amount;
                $exp_budget->update();
            } else {
                return redirect('expense')->with('error', 'You can not approve');
            }
        }

        return redirect(route('transactions.index'));
    }
    public function export(Request $request){
        return Excel::download(new BankTransactionExport($request->start_date,$request->end_date), 'transaction.xlsx');
    }
}
