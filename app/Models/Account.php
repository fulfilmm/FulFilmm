<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=['company_id','name','number','currency','opening_balance',
        'bank_name','bank_phone','bank_address','enabled','balance'
    ];
}
