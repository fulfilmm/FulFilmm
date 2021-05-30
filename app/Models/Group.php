<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'created_by'
    ];

    public function created_employee()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }
    public function employees(){
        return $this->belongsToMany(Employee::class, 'groups_employees', 'group_id', 'employee_id');
    }
}
