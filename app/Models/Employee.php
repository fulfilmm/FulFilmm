<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $guarded= [];

    protected $fillable= [
        'name', 'department_id', 'role_id', 'phone', 'email',
        'work_phone', 'can_login', 'password', 'join_date'
    ];



    //relations

    public function department() {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
