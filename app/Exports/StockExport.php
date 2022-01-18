<?php

namespace App\Exports;

use App\Models\Stock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StockExport implements FromCollection,WithMapping,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $data;
    public $exceptKeys = ['variant','warehouse'];
    public function __construct($start_date,$end_date,$warehouse)
    {
      if($warehouse!=null){
          $this->data = Stock::with('warehouse','variant')
              ->select('product_name','stock_balance','available','created_at','variant_id','warehouse_id')
              ->whereBetween('created_at',[$start_date,$end_date])
              ->where('warehouse_id',$warehouse)
              ->get();
      }else{
          $this->data = Stock::with('warehouse','variant')
              ->select('product_name','stock_balance','available','created_at','variant_id','warehouse_id')
              ->whereBetween('created_at',[$start_date,$end_date])
              ->get();
      }
    }
    public function collection()
    {
        return $this->data;
    }
    public function headings(): array
    {
        $head=['Product Code','Product Name','Variants','Warehouse','Stock Balance','Available Stock','Created Date'];
        return $head;
    }
    public function map($stock): array
    {
        return [
            $stock->variant->product_code,
            $stock->product_name,
            $stock->variant->variant,
            $stock->warehouse->name,
            $stock->stock_balance,
            $stock->available,
            $stock->created_at->toFormattedDateString(),

        ];
    }
}
