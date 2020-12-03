<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Company extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'name',
        'business_type',
        'address',
        'phone',
        'logo',
        'data',
        'user_company',
        'mission',
        'vision',
        'email',
        'ceo_name',
        'web_link',
        'linkedin',
        'facebook_page',
        'company_registry',
        'parent_company',
        'parent_company_2'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    //relations
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    //scopes
    public function scopeUserCompany($query)
    {
        return $query->where('user_company', 1);
    }

    public function scopeUserCompanyName($query)
    {
        return $query->where('user_company', 1)->first()->name ?? '';
    }

    public function parentCompany()
    {
        return $this->belongsTo(Company::class, 'parent_company');
    }

    public function parentCompany2()
    {
        return $this->belongsTo(Company::class, 'parent_company_2');
    }
}
