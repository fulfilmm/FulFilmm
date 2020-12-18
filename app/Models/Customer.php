<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $fillable = [
        'name', 'phone', 'email', 'company_id', 'address'
    ];


    //relations
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
