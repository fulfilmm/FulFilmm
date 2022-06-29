<?php

namespace App\Http\Controllers;

use App\Exports\BankTransactionExport;
use App\Models\Account;
use App\Models\Bill;
use App\Models\BillItem;
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
use App\Models\PurchaseOrder;
use App\Models\Revenue;
use App\Models\RevenueBudget;
use App\Models\Transaction;
use App\Models\TransactionCategory;
use App\Traits\NotifyTrait;
use Carbon\Carbon;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;


class TransactionController extends Controller
{
    use NotifyTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::with('expense', 'revenue', 'account', 'bill')->get();
        $employees = Employee::all()->pluck('name', 'id')->all();
        $invoice = Invoice::all()->pluck('invoice_id', 'id')->all();
        $bill = Bill::all()->pluck('bill_id', 'id')->all();
        return view('transaction.index', compact('transactions', 'employees', 'invoice', 'bill'));
    }
    public function revenue_index()
    {
        $auth = Auth::guard('employee')->user();
        if ($auth->role->name == 'CEO' || $auth->role->name == 'Super Admin' || $auth->role->name == 'Finance Manager') {
            $revenues = Revenue::with('cat', 'employee', 'branch_cashier', 'invoice', 'manager')->get();
        } else if ($auth->role->name=='Finance Manager') {
            $revenues = Revenue::with('cat', 'employee', 'branch_cashier', 'invoice', 'manager')
                ->where('finance_manager', $auth->id)
                ->where('is_cashintransit',1)
                ->where('approve',1)
                ->orWhere('emp_id', $auth->id)
                ->get();

        } else {
            $revenues = Revenue::with('cat', 'employee', 'branch_cashier', 'invoice', 'manager')
                ->orWhere('emp_id', $auth->id)
                ->orWhere('cashier', $auth->id)
                ->get();
        }
        return view('transaction.Revenue.index', compact('revenues'));
    }
    public function addrevenue()
    {

        $recurring = ['No', 'Daily', 'Weekly', 'Monthly', 'Yearly'];
        $payment_method = ['Cash', 'eBanking', 'WaveMoney', 'KBZ Pay'];
        $category = TransactionCategory::where('type', 1)->get();
//        $coas = ChartOfAccount::all();
        $customer = Customer::orWhere('customer_type', 'Customer')->orWhere('customer_type', 'Lead')->orWhere('customer_type', 'Partner')->orWhere('customer_type', 'Inquery')->get();
//        dd($customer);
        $employee=Employee::where('office_branch_id',Auth::guard('employee')->user()->office_branch_id)->get();
        $data = [
            'emps'=>$employee,'customers' => $customer, 'recurring' => $recurring, 'payment_method' => $payment_method, 'category' => $category];
        return view('transaction.Revenue.create', compact('data'));
    }

    public function store_revenue(Request $request)
    {
//        dd($request->all());
        $this->validate($request, [
            'transaction_date' => 'required',
            'amount' => 'required',
            'customer_id' => 'required',
            'category' => 'required',
            'payment_method' => 'required',
            'approver_id'=>'required',
            'attachment' => 'mimes:pdf,xlsx,doc,docx,jpg,jpeg,ppt,bip',
//                'coa_account'=>'required'
        ]);

        try {
            $branch_acc=Account::where('branch_id',Auth::guard('employee')->user()->office_branch_id)->first();

            $emps=Employee::where('head_office',Auth::guard('employee')->user()->head_office)->get();
            $financeManger=[];
            foreach ($emps as $emp){
                if($emp->role->name=='Finance Manager'){
                    array_push($financeManger,$emp);
                }
            }
//            dd($branch_acc);
            $new_revenue = new Revenue();
            $new_revenue->title = $request->title;
            $new_revenue->customer_id = $request->customer_id;
            $new_revenue->amount = $request->amount;
            $new_revenue->invoice_id = $request->invoice_id ?? null;
            $new_revenue->reference = $request->reference;
            $new_revenue->recurring = $request->recurring;
            $new_revenue->payment_method = $request->payment_method;
            $new_revenue->description = $request->description;
            $new_revenue->category = $request->category;
            $new_revenue->cashier = $request->approver_id;
            $new_revenue->advance_pay_id = $request->advance_id ?? null;
            $employee = Employee::where('head_office', Auth::guard('employee')->user()->head_office)->get();
            foreach ($employee as $emp) {
                if ($emp->role->name =='Finance Manager') {
                    $new_revenue->head_account = Account::where('enabled', 1)->where('head_office',Auth::guard('employee')->user()->head_office)->where('head_account',1)->first()->id;
                    $new_revenue->finance_manager =$financeManger[0]->id;
                };
            }
            $new_revenue->cashier_account = $branch_acc->id;
            $new_revenue->transaction_date = $request->transaction_date;
            $new_revenue->emp_id = Auth::guard('employee')->user()->id;
            $new_revenue->branch_id = Auth::guard('employee')->user()->office_branch_id;
            $new_revenue->currency = $request->currency;
            if ($request->payment_method != "Cash") {
                $new_revenue->is_cashintransit = 1;
            }
            if (isset($request->attachment)) {
                if ($request->attachment != null) {
                    $attach = $request->file('attachment');
                    $input['filename'] = \Illuminate\Support\Str::random(10) . time() . '.' . $attach->extension();
                    $request->attachment->move(public_path() . '/attach_file', $input['filename']);

                }
                $new_revenue->attachment = $input['filename'];
            }
            if ($request->payment_method == 'Advance Payment') {
                $new_revenue->approve = 1;
            }
            $new_revenue->save();
            if($request->advance=='on'){
                $customer=Customer::where('id',$request->customer_id)->first();
                $customer->advance_balance-=$request->amount;
                $customer->update();
            }
            if (isset($request->invoice_id)) {
                $inv = Invoice::where('id', $request->invoice_id)->first();
                $employee = Employee::where('id', $inv->emp_id)->first();
                $employee->amount_in_hand += $request->amount;
                $employee->update();
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        if (isset($request->invoice_id)) {
            $delivery = DeliveryOrder::where('invoice_id', $request->invoice_id)->first();
            if ($delivery != null) {
                $deli_pay = DeliveryPay::where('delivery_id', $delivery->id)->first();
                $deli_pay->receiver_invoice_amount = 1;
                $deli_pay->update();
            }
        }
        $this->transaction_add($branch_acc->id, $request->type, null, $new_revenue->id);
        $this->addnotify($request->approver_id, 'noti', 'Add new revenue', 'revenue', Auth::guard('employee')->user()->id);
        if ($new_revenue->is_cashintransit) {
            $this->addnotify($new_revenue->finance_manager, 'noti', 'Add new revenue', 'revenue', Auth::guard('employee')->user()->id);

        }
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
    public function revenue_edit($id)
    {
        $revenue = Revenue::where('id', $id)->first();
        $transaction = Transaction::where('revenue_id', $revenue->id)->first();
        $emps = Employee::where('office_branch_id', Auth::guard('employee')->user()->office_branch_id)->get();
        $recurring = ['No', 'Daily', 'Weekly', 'Monthly', 'Yearly'];
        $payment_method = ['Cash', 'eBanking', 'WaveMoney', 'KBZ Pay'];
        $category = TransactionCategory::where('type', 1)->get();
//        $coas = ChartOfAccount::all();
        $customer = Customer::orWhere('customer_type', 'Customer')->orWhere('customer_type', 'Lead')->orWhere('customer_type', 'Partner')->orWhere('customer_type', 'Inquery')->get();
        $data = [
//            'coas' => $coas,
            'emps' => $emps, 'customers' => $customer, 'recurring' => $recurring, 'payment_method' => $payment_method, 'category' => $category];
        return view('transaction.Revenue.edit', compact('data', 'revenue', 'transaction'));
    }
    public function revenue_update(Request $request, $id)
    {
        try {

            $new_revenue = Revenue::where('id', $id)->first();
            $new_revenue->title = $request->title;
            $new_revenue->customer_id = $request->customer_id;
            $new_revenue->amount = $request->amount;
            $new_revenue->invoice_id = $request->invoice_id ?? null;
            $new_revenue->reference = $request->reference;
            $new_revenue->recurring = $request->recurring;
            $new_revenue->payment_method = $request->payment_method;
            $new_revenue->description = $request->description;
            $new_revenue->category = $request->category;
            $new_revenue->advance_pay_id = $request->advance_id ?? null;
//            $new_revenue->coa_id = $request->coa_account;
            $new_revenue->transaction_date = $request->transaction_date;
            $new_revenue->emp_id = Auth::guard('employee')->user()->id;
            $new_revenue->branch_id = Auth::guard('employee')->user()->office_branch_id;
            $new_revenue->currency = $request->currency;
            if (isset($request->attachment)) {
                if ($request->attachment != null) {
                    $attach = $request->file('attachment');
                    $input['filename'] = \Illuminate\Support\Str::random(10) . time() . '.' . $attach->extension();
                    $request->attachment->move(public_path() . '/attach_file', $input['filename']);

                }
                $new_revenue->attachment = $input['filename'];
            }
            if ($request->payment_method == 'Advance Payment') {
                $new_revenue->approve = 1;
            }
            if (isset($request->invoice_id)) {
                $inv = Invoice::where('id', $request->invoice_id)->first();
                $employee = Employee::where('id', $inv->emp_id)->first();
                $employee->amount_in_hand -= $new_revenue->amount;
                $employee->update();
            }
            $new_revenue->update();
            if (isset($request->invoice_id)) {
                $inv = Invoice::where('id', $request->invoice_id)->first();
                $employee = Employee::where('id', $inv->emp_id)->first();
                $employee->amount_in_hand += $request->amount;
                $employee->update();
            }
            $transaction = Transaction::where('revenue_id', $id)->first();
            $transaction->account_id = $request->account;
            $transaction->update();
            return redirect('revenue')->with('success', 'Revenue updated');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function revenue_delete($id)
    {
        $revenue = Revenue::where('id', $id)->first();
        $transaction = Transaction::where('revenue_id', $revenue->id)->first();
        $transaction->delete();
        $revenue->delete();
        return redirect('revenue')->with('success', 'Deleted Successful');
    }

    public function expense()
    {
        $account = Account::where('enabled', 1)->get();
        $recurring = ['No', 'Daily', 'Weekly', 'Monthly', 'Yearly'];
        $payment_method = ['Cash', 'eBanking', 'WaveMoney', 'KBZ Pay'];
        $category = TransactionCategory::where('type', 0)->get();
        $emps = Employee::where('office_branch_id', Auth::guard('employee')->user()->office_branch_id)->get();
//        $coas = ChartOfAccount::all();
        $customer = Customer::where('customer_type', 'Supplier')->get();
        $data = [
//            'coas' => $coas,
            'emps' => $emps, 'customers' => $customer, 'account' => $account, 'recurring' => $recurring, 'payment_method' => $payment_method, 'category' => $category];
        return view('transaction.Expense.create', compact('data'));
    }
    public function expense_index()
    {

        $auth = Auth::guard('employee')->user();
        if ($auth->role->name == 'CEO' || $auth->role->name == 'Super Admin' || $auth->role->name == 'Finance Manager') {
            $expenses = Expense::with('cat', 'supplier', 'approver', 'employee', 'bill')->get();
        } else {
            $expenses = Expense::with('cat', 'supplier', 'approver', 'employee', 'bill')
                ->orWhere('emp_id', $auth->id)
                ->orWhere('approver_id', $auth->id)
                ->get();
        }

        return view('transaction.Expense.index', compact('expenses'));
    }
    public function expense_store(Request $request)
    {

//        dd($request->all());
        $this->validate($request, [
            'transaction_date' => 'required',
            'amount' => 'required',
            'account' => 'required',
            'category' => 'required',
            'payment_method' => 'required',
            'approver_id' => 'required',
            'attachment' => 'mimes:pdf,xlsx,doc,docx,jpg,jpeg,ppt,bip,|max:2048',
//            'coa_account'=>'required'
        ]);
        if (isset($request->bill_id)) {
            $bill_amount = Bill::where('id', $request->bill_id)->first();
            if ($bill_amount->due_amount != 0) {
                try {
                    $new_expense = new Expense();
                    $new_expense->title = $request->title;
                    $new_expense->vendor_id = $request->customer_id;
                    $new_expense->amount = $request->amount;
                    $new_expense->reference = $request->reference;
                    $new_expense->recurring = $request->recurring;
                    $new_expense->payment_method = $request->payment_method;
                    $new_expense->description = $request->description;
                    $new_expense->category = $request->category;
                    $new_expense->approver_id = $request->approver_id;
//                    $new_expense->coa_id = $request->coa_account;
                    $new_expense->transaction_date = $request->transaction_date;
                    $new_expense->emp_id = Auth::guard('employee')->user()->id;
                    $new_expense->branch_id = Auth::guard('employee')->user()->office_branch_id;
                    $new_expense->currency = $request->currency;
                    $new_expense->bill_id = $request->bill_id ?? null;
//        dd($new_expense);
                    if (isset($request->attachment)) {
                        if ($request->attachment != null) {
                            $attach = $request->file('attachment');
                            $input['filename'] = \Illuminate\Support\Str::random(10) . time() . '.' . $attach->extension();
                            $request->attachment->move(public_path() . '/attach_file', $input['filename']);

                        }
                        $new_expense->attachment = $input['filename'];
                    }
                    $new_expense->save();
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', $e->getMessage());
                }
                if (isset($request->exp_id)) {
                    $exp = ExpenseClaim::where('id', $request->exp_id)->first();
                    $exp->is_claim = 1;
                    $exp->update();
                }
                $this->transaction_add($request->account, $request->type, $new_expense->id, null);
                $this->addnotify($request->approver_id, 'noti', 'Add new expense', 'expense', Auth::guard('employee')->user()->id);

                $bill = Bill::where('id', $request->bill_id)->first();
                $bill->due_amount = $bill->due_amount - $request->amount;
                $bill->update();
                return redirect(route('bills.show', $request->bill_id))->with('success', 'Add New Expense Successful');
            } else {
                return redirect()->back()->with('danger', 'This bill is payment has been made');
            }
        } else {
            try {
                $new_expense = new Expense();
                $new_expense->title = $request->title;
                $new_expense->vendor_id = $request->customer_id;
                $new_expense->amount = $request->amount;
                $new_expense->reference = $request->reference;
                $new_expense->recurring = $request->recurring;
                $new_expense->payment_method = $request->payment_method;
                $new_expense->description = $request->description;
                $new_expense->category = $request->category;
                $new_expense->approver_id = $request->approver_id;
//                $new_expense->coa_id = $request->coa_account;
                $new_expense->transaction_date = $request->transaction_date;
                $new_expense->emp_id = Auth::guard('employee')->user()->id;
                $new_expense->branch_id = Auth::guard('employee')->user()->office_branch_id;
                $new_expense->currency = $request->currency;
                $new_expense->bill_id = $request->bill_id ?? null;
//        dd($new_expense);
                if (isset($request->attachment)) {
                    if ($request->attachment != null) {
                        $attach = $request->file('attachment');
                        $input['filename'] = \Illuminate\Support\Str::random(10) . time() . '.' . $attach->extension();
                        $request->attachment->move(public_path() . '/attach_file', $input['filename']);

                    }
                    $new_expense->attachment = $input['filename'];
                }
                $new_expense->save();
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
            if (isset($request->exp_id)) {
                $exp = ExpenseClaim::where('id', $request->exp_id)->first();
                $exp->is_claim = 1;
                $exp->update();
            }
            $this->transaction_add($request->account, $request->type, $new_expense->id, null);
            $this->addnotify($request->approver_id, 'noti', 'Add new expense', 'expense', Auth::guard('employee')->user()->id);
            $last_tran = Transaction::orderBy('id', 'desc')->first();
            return redirect(route('transactions.show', $last_tran->id))->with('success', 'Add New Expense Successful');
        }


    }
    public function expense_delete($id)
    {
        $expense = Expense::where('id', $id)->first();
        $transaction = Transaction::where('expense_id', $expense->id)->first();
        $transaction->delete();
        $expense->delete();
        return redirect('revenue')->with('success', 'Deleted Successful');
    }
    public function expense_edit($id)
    {
        $expense = Expense::where('id', $id)->first();
        $transaction = Transaction::where('expense_id', $id)->first();
        $account = Account::where('enabled', 1)->get();
        $recurring = ['No', 'Daily', 'Weekly', 'Monthly', 'Yearly'];
        $payment_method = ['Cash', 'eBanking', 'WaveMoney', 'KBZ Pay'];
        $category = TransactionCategory::where('type', 0)->get();
        $emps = Employee::all();
//        $coas = ChartOfAccount::all();
        $customer = Customer::where('customer_type', 'Supplier')->get();
        $data = [
//            'coas' => $coas,
            'emps' => $emps, 'customers' => $customer, 'account' => $account, 'recurring' => $recurring, 'payment_method' => $payment_method, 'category' => $category];
        return view('transaction.Expense.edit', compact('data', 'expense', 'transaction'));
    }
    public function expense_update(Request $request, $id)
    {
        try {
            $new_expense = Expense::where('id', $id)->first();
            $new_expense->title = $request->title;
            $new_expense->vendor_id = $request->customer_id;
            $new_expense->amount = $request->amount;
            $new_expense->reference = $request->reference;
            $new_expense->recurring = $request->recurring;
            $new_expense->payment_method = $request->payment_method;
            $new_expense->description = $request->description;
            $new_expense->category = $request->category;
            $new_expense->approver_id = $request->approver_id;
//            $new_expense->coa_id = $request->coa_account;
            $new_expense->transaction_date = $request->transaction_date;
            $new_expense->emp_id = Auth::guard('employee')->user()->id;
            $new_expense->branch_id = Auth::guard('employee')->user()->office_branch_id;
            $new_expense->currency = $request->currency;
            $new_expense->bill_id = $request->bill_id ?? null;
//        dd($new_expense);
            if (isset($request->attachment)) {
                if ($request->attachment != null) {
                    $attach = $request->file('attachment');
                    $input['filename'] = \Illuminate\Support\Str::random(10) . time() . '.' . $attach->extension();
                    $request->attachment->move(public_path() . '/attach_file', $input['filename']);

                }
                $new_expense->attachment = $input['filename'];
            }
            if (isset($request->bill_id)) {
                $bill = Bill::where('id', $request->bill_id)->first();
                $bill->due_amount += $new_expense->amount;
                $bill->update();
            }
            $new_expense->update();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        if (isset($request->exp_id)) {
            $exp = ExpenseClaim::where('id', $request->exp_id)->first();
            $exp->is_claim = 1;
            $exp->update();
        }
        $last_tran = Transaction::where('expense_id', $id)->first();
        if (isset($request->bill_id)) {
            $bill = Bill::where('id', $request->bill_id)->first();
            $bill->due_amount = $bill->due_amount - $request->amount;
            $bill->update();
            return redirect(route('bills.show', $request->bill_id))->with('success', 'Update Expense Successful');
        } else {
            return redirect(route('transactions.show', $last_tran->id))->with('success', 'Update  Expense Successful');
        }

    }

    public function show($id)
    {
        $transaction = Transaction::with('expense', 'revenue', 'account')->where('id', $id)->firstOrFail();
        $company = MainCompany::where('ismaincompany', true)->first();
        $category = TransactionCategory::all();
//        $coas = ChartOfAccount::all();
        $customer = Customer::where('id', $transaction->type == 'Revenue' ? $transaction->revenue->customer_id : $transaction->expense->vendor_id)->first();
        $receiver = Employee::where('id', $transaction->type == 'Revenue' ? $transaction->revenue->emp_id : $transaction->expense->emp_id)->first();
        return view('transaction.show', compact('transaction', 'customer', 'receiver', 'company', 'category'));
    }
    public function edit($id)
    {
        //
    }

    public function destroy($id)
    {
        //
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
//        dd($type);
        if ($type == 'Revenue') {
            $revenue = Revenue::with('invoice')->where('id', $id)->first();

            if ($revenue->cashier == Auth::guard('employee')->user()->id) {
                $account = Account::where('id', $revenue->cashier_account)->first();
                $account->balance = $account->balance + $revenue->amount;
                $revenue->approve = 1;
                $revenue->update();
                $account->update();
                if (isset($revenue->invoice->customer_id)) {
                    $customer = Customer::where('id', $revenue->invoice->customer_id)->first();
                    $customer->current_credit = $customer->current_credit - $revenue->amount;
                    $customer->use_amount+=$revenue->amount;
                    $customer->update();
                    $employee = Employee::where('id', $revenue->invoice->emp_id)->first();
                    $employee->amount_in_hand = $employee->amount_in_hand - $revenue->amount;
                    $employee->update();
                }
                return redirect('revenue')->with('success', 'You has been receipted this revenue');
//                $rev_budget=RevenueBudget::where('category_id',$revenue->category)->where('year',Carbon::parse($revenue->transaction_date)->format('Y'))->where('month',Carbon::parse($revenue->transaction_date)->format('m'))->first();
//                $rev_budget->actual=$rev_budget->actual + $revenue->amount;
//                $rev_budget->update();
            }elseif ($revenue->finance_manager == Auth::guard('employee')->user()->id) {
                $head_acc = Account::where('id', $revenue->head_account)->first();
                $head_acc->balance = $head_acc->balance + $revenue->amount;
                $revenue->received = 1;
                $revenue->update();
                $head_acc->update();
                $cashier_account = Account::where('id', $revenue->cashier_account)->first();
                $cashier_account->balance = $cashier_account->balance - $revenue->amount;
                $revenue->update();
                $cashier_account->update();
                return redirect('revenue')->with('success', 'You has been receipted this revenue');
            }else {
                return redirect('revenue')->with('error', 'You can not approve');
            }
        } else {
            $expense = Expense::where('id', $id)->first();
            if ($expense->approver_id == Auth::guard('employee')->user()->id) {
                $withdraw_acc = Account::where('emp_id',$expense->approver_id)->first();
                $withdraw_acc->balance = $withdraw_acc->balance - $expense->amount;
                $expense->approve = 1;
                $expense->update();
                $withdraw_acc->update();
                if ($expense->bill_id != null) {
                    $items = BillItem::where('bill_id', $expense->bill_id)->get();
                    foreach ($items as $item) {
                        $po = PurchaseOrder::where('id', $item->po_id)->first();
                        $po->payable_amount = $po->payable_amount - $expense->amount;
                        $po->update();
                    }
                }
//                $exp_budget=ExpenseBudget::where('category_id',$expense->category)->where('year',Carbon::parse($expense->transaction_date)->format('Y'))->where('month',Carbon::parse($expense->transaction_date)->format('m'))->first();
//                $exp_budget->actual=$exp_budget->actual??0 + $expense->amount;
//                $exp_budget->update();
                return redirect('expense')->with('success', 'You has been approved this expense');

            } else {
                return redirect('expense')->with('error', 'You can not approve');
            }
        }

    }

    public function export(Request $request)
    {
        return Excel::download(new BankTransactionExport($request->start_date, $request->end_date), 'transaction.xlsx');
    }

    public function transer_branch(Request $request)
    {
//        dd($request->all());
        foreach ($request->revenue as $key => $val) {
            $revenue = Revenue::where('id', $val)->first();
            $revenue->is_cashintransit = 1;
            if (isset($request->attachment)) {
                if ($request->attachment != null) {
                    $attach = $request->file('attachment');
                    $input['filename'] = \Illuminate\Support\Str::random(10) . time() . '.' . $attach->extension();
                    $request->attachment->move(public_path() . '/attach_file', $input['filename']);

                }
                $revenue->second_attach = $input['filename'];
            }
            $revenue->comment=$request->comment;
            $revenue->update();
        }
        return redirect()->back()->with('success','Transferred to ' . count($request->revenue) . ' revenue transaction');
    }
}