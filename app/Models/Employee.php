<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Authenticatable
{
    use HasFactory, SoftDeletes;
    use HasRoles;

    protected $guarded = [];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $fillable = [
        'name', 'department_id', 'role_id', 'phone', 'email',
        'work_phone', 'can_login','can_post_assignments', 'password', 'join_date'
    ];



    //relations
    public function department_name()
    {
        return $this->department()->first()->name;
    }
    public  function getRoleAttribute()
    {
        return $this->roles[0] ?? null;
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function assignments()
    {
        return $this->belongsToMany(Assignment::class, 'assignment_employee');
    }
}
