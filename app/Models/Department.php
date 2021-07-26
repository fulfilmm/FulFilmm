<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded= [];

    protected $fillable = [
        'name', 'parent_department', 'address'
    ];


    //relations

    public function employees() {
        return $this->hasMany(Employee::class, 'department_id');
    }

    public function parent_dept() {
        return $this->belongsTo(Department::class, 'parent_department');
    }

    public function departmentHeads()
    {
        return $this->hasMany(DepartmentHead::class, 'department_id')->orderBy('id', 'DESC');
    }
}
