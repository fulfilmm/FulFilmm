<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleWay extends Model
{
    use HasFactory;
    protected $fillable=['way_id','name','branch_id'];
}
