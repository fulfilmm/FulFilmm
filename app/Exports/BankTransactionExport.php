<?php

namespace App\Exports;

use App\Models\Bill;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BankTransactionExport implements FromCollection,WithHeadings,WithMapping
{
    protected $data;

    public function __construct($start_date, $end_date)
    {
        $this->data = Transaction::with('expense', 'revenue', 'account')
            ->whereBetween('created_at', [$start_date, $end_date])
            ->get();
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        $heading = ['Date', 'Refrence Id', 'Title', 'Amount', 'Type', 'Category', 'Account', 'Status', 'Approver Name', 'Receiver/Issuer'];
        return $heading;
    }

    public function map($transaction): array
    {

        $employees = Employee::all()->pluck('name', 'id')->all();
        $invoice = Invoice::all()->pluck('invoice_id', 'id')->all();
        $bill = Bill::all()->pluck('bill_id', 'id')->all();
       if($transaction->type=='Revenue'){
           foreach ($employees as $key => $val) {
               if($transaction->revenue->approver_id==$key){
                   $approver_name = $val;
               }
               if($transaction->revenue->emp_id==$key){
                   $casher =$val;
               }

           }
           if ($transaction->revenue->invoice_id != null) {
               foreach ($invoice as $key => $val) {
                   if ($key == $transaction->revenue->invoice_id){
                       $ref_id=$val;
                   }
               }
           }else{
               $ref_id='N/A';
           }
           return [
               $transaction->created_at,
               $ref_id,
               $transaction->revenue->title,
               $transaction->revenue->amount,
               $transaction->type,
               $transaction->revenue->category,
               $transaction->account->name,
               $transaction->revenue->approve == 0 ? 'Pending' : 'Approve',
               $approver_name,
               $casher,


           ];
       }else{
           foreach ($employees as $key => $val) {
               if($key == $transaction->expense->approver_id){
                   $approver_name =$val;
               }
               if($key == $transaction->expense->emp_id){
                   $casher =$val;
               }

           }
           if ($transaction->revenue->invoice_id != null) {
               foreach ($bill as $key => $val) {
                   if ($key == $transaction->expense->bill_id){
                       $ref_id=$val;
                   }
               }
           }else{
               $ref_id='N/A';
           }
       }
        return [
            $transaction->created_at,
            $ref_id,
            $transaction->expense->title,
            $transaction->expense->amount,
            $transaction->type,
            $transaction->expense->category,
            $transaction->account->name,
            $transaction->expense->approve == 0 ? 'Pending' : 'Approve',
            $approver_name,
            $casher,


        ];

    }
}
