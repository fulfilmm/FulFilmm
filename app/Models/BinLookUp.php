<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BinLookUp extends Model
{
    use HasFactory;
protected $fillable=['bin_no','description','location','width',
    'height','length'];
}
