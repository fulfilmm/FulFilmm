<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\Revenue;
use App\Models\Transaction;
use App\Models\TransactionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $emps =Employee::where('office_branch_id', Auth::guard('api')->user()->office_branch_id)->get();
        $cashier=[];
        foreach ($emps as $emp){
            if($emp->role->name=='Regional Cashier'&& $emp->region_id==Auth::guard('api')->user()->region_id){
                array_push($cashier,$emp);
            }
        }
        $recurring = ['No', 'Daily', 'Weekly', 'Monthly', 'Yearly'];
        $payment_method = ['Cash', 'eBanking', 'WaveMoney', 'KBZ Pay'];
        $category = TransactionCategory::where('type', 1)->get();
//        $coas = ChartOfAccount::all();
        $customer = Customer::orWhere('customer_type', 'Customer')->orWhere('customer_type', 'Lead')->orWhere('customer_type', 'Partner')->orWhere('customer_type', 'Inquery')->get();
        return response()->json([
//            'coas' => $coas,
            'regional_cashier' => $cashier, 'customers' => $customer, 'recurring' => $recurring, 'payment_method' => $payment_method, 'category' => $category]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $this->validate($request, [
                'transaction_date' => 'required',
                'amount' => 'required',
                'customer_id' => 'required',
                'category' => 'required',
                'payment_method' => 'required',
                'approver_id' => 'required',
                'attachment' => 'mimes:pdf,xlsx,doc,docx,jpg,jpeg,ppt,bip',
//                'coa_account'=>'required'
            ]);

            try {
                $reginal_acc = Account::where('emp_id', $request->approver_id)->first()->id;
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
                $new_revenue->regional_cashier = $request->approver_id;
                $new_revenue->advance_pay_id = $request->advance_id ?? null;
                $employee = Employee::where('office_branch_id', Auth::guard('employee')->user()->office_branch_id)->get();
                foreach ($employee as $emp) {
                    if ($emp->role->name == 'Branch Cashier') {
                        $new_revenue->branch_account = Account::where('enabled', 1)->where('emp_id', $emp->id)->first()->id;
                        $new_revenue->branch_cashier = $emp->id;
                    }
                }
                $new_revenue->regional_account = $reginal_acc;
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
                if (isset($request->invoice_id)) {
                    $inv = Invoice::where('id', $request->invoice_id)->first();
                    $employee = Employee::where('id', $inv->emp_id)->first();
                    $employee->amount_in_hand += $request->amount;
                    $employee->update();
                }
            } catch (\Exception $e) {
                return response()->json(['error'=> $e->getMessage()]);
            }
//            if (isset($request->invoice_id)) {
//                $delivery = DeliveryOrder::where('invoice_id', $request->invoice_id)->first();
//                if ($delivery != null) {
//                    $deli_pay = DeliveryPay::where('delivery_id', $delivery->id)->first();
//                    $deli_pay->receiver_invoice_amount = 1;
//                    $deli_pay->update();
//                }
//            }
            $this->transaction_add($reginal_acc, $request->type, null, $new_revenue->id);
            $this->addnotify($request->approver_id, 'noti', 'Add new revenue', 'revenue', Auth::guard('api')->user()->id);
            if ($new_revenue->is_cashintransit) {
                $this->addnotify($new_revenue->branch_cashier, 'noti', 'Add new revenue', 'revenue', Auth::guard('api')->user()->id);

            }
            if (isset($request->invoice_id)) {
                $inv = Invoice::where('id', $request->invoice_id)->first();
                $inv->due_amount = $inv->due_amount - $request->amount;
                $inv->update();
            }
              return response()->json(['success'=>'Add New Revenue Successful']);


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
        //
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
