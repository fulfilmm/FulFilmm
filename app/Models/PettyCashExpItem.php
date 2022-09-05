<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PettyCashExpItem extends Model
{
    use HasFactory;
    protected $fillable=['date','purpose','amount','petty_cash_id'];
}
