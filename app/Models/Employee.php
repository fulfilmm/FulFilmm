<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use HasFactory;

    protected $guarded = [];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $fillable = [
        'name', 'department_id', 'role_id', 'phone', 'email',
        'work_phone', 'can_login', 'password', 'join_date'
    ];



    //relations
    public function department_name()
    {
        return $this->department()->first()->name;
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
