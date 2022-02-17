<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;
    protected $fillable=['vendor_id','ordered_date','deadline','po_id',
        'purchase_type','vendor_reference','description','subtotal','discount',
        'tax_amount','tax_id','grand_total','pr_id','emp_id','receipt_date','paid_bill','is_receipt','attach'
    ];
    public function vendor(){
        return $this->belongsTo(Customer::class,'vendor_id','id');

    }
    public function tax(){
        return $this->belongsTo(products_tax::class,'tax_id','id');
    }
    public function pr(){
        return $this->belongsTo(PurchaseRequest::class,'pr_id','id');
    }
    public function employee(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
}
