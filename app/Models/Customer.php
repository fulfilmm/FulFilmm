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
    protected $fillable = [
        'name', 'phone', 'email', 'company_id',
        'address','gender','emp_id','customer_type',
        'password','profile','bio','can_login','facebook',
        'linkedin','dob','report_to','position_of_report_to',
        'priority','is_qualified','tags_id',''
    ];


    //relations
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
