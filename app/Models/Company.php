<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $guarded=[];

    protected $fillable=[
        'name', 'business_type', 'address', 'phone', 'mission',
        'vision', 'email', 'ceo_name', 'web_link', 'linkedin',
        'facebook_page', 'company_registry', 'parent_company', 'parent_company_2'
    ];

    //relations
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
