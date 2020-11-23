<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $guarded= [];

    protected $fillable = [
        'name', 'parent_department', 'address'
    ];


    //relations

    public function employees() {
        return $this->hasMany(Employee::class, 'department_id');
    }

    public function department() {
        return $this->belongsTo(Department::class, 'parent_department');
    }
}
