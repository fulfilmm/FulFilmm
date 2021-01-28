<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function employees(){
        return $this->belongsToMany(Employee::class, 'groups_employees', 'group_id', 'employee_id');
    }
}
