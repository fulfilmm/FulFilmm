<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarData extends Model
{
    use HasFactory;

    protected $fillable = ['license_no' , 'brand', 'model', 'manufacture','engine','horsepower','chassis','kilometer', 'upd_kilometer' ,
                            'license_issue_date' , 'license_renew_date', 'status', 'fuel_type', 'seat', 
                            'purchase_value', 'car_type', 'contract_date','org_owner_name' ,'renew_date', 'contract','attach', 
                            'description'];
} 
