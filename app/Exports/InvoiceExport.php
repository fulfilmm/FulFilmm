<?php

namespace App\Exports;

use App\Models\Invoice;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InvoiceExport implements FromCollection,WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $data;
    public function __construct($start_date,$end_date,$type)
    {
        $start=Carbon::parse($start_date)->startOfDay();
        $end=Carbon::parse($end_date)->endOfDay();
        if($type=='Whole Sale'){
            $this->data=Invoice::with('customer','employee','branch','region','zone')->whereBetween('created_at',[$start,$end])->where('inv_type','Whole Sale')->get();
        }elseif ($type=='Retail Sale'){
            $this->data=Invoice::with('customer','employee','branch','region','zone')->whereBetween('created_at',[$start,$end])->where('inv_type','Retail Sale')->get();

        }elseif ($type=='Due'){
            $this->data=Invoice::with('customer','employee','branch','region','zone')->whereBetween('created_at',[$start,$end])->where('due_amount','!=',0)->get();

        }else{
            $this->data=Invoice::with('customer','employee','branch','region','zone')->whereBetween('created_at',[$start,$end])->get();
        }

    }
    public function collection()
    {

        return $this->data;
    }
    public function headings(): array
    {
        $head=['Invoice Number','Sale Type','Invoice Type','Customer','Sale Man','Date','Due Date','Amount','Due Amount','Status','Branch','Region','Zone'];
        return $head;
    }
    public function map($inv): array
    {
        return [
            $inv->invoice_id,
            $inv->inv_type,
            $inv->invoice_type,
            $inv->customer->name,
            $inv->employee->name,
            $inv->created_at->toFormattedDateString(),
            Carbon::parse($inv->due_date)->toFormattedDateString(),
            $inv->grand_total,
            $inv->due_amount,
            $inv->status,
            $inv->branch->name,
            $inv->region->name,
            $inv->zone->name

        ];
    }
}
