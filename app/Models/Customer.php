<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use SoftDeletes,Notifiable;

    protected $guarded = [];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $fillable = ['customer_id',
        'name',
        'phone',
        'email',
        'company_id',
        'address',
        'gender',
        'emp_id',
        'customer_type',
        'password',
        'profile',
        'bio',
        'can_login',
        'facebook',
        'linkedin',
        'dob',
        'report_to',
        'position_of_report_to',
        'priority',
        'is_qualified',
        'tags_id',
        'lead_title',
        'department',
        'position',
        'status',
        'lead_title',
        'credit_limit',
        'current_credit',
        'region_id',
        'zone_id',
        'branch_id'
    ];


    //relations
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function branch(){
        return $this->belongsTo(OfficeBranch::class);
    }
    public function zone(){
        return $this->belongsTo(SaleZone::class);
    }
    public function region(){
        return $this->belongsTo(Region::class);
    }
}
