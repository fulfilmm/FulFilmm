<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintainCheck extends Model
{
    use HasFactory;

    protected $fillable = ['car_id', 'case', 'driver', 'workshop','kilometer','attaches','total','check', 'note'];
} 
