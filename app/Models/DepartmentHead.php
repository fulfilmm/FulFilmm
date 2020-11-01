<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentHead extends Model
{
    use HasFactory;

    protected $guarded= [];

    protected $fillable=[
        'department_id', 'employee_id'
    ];


    //relations

    public function employee() {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function department() {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
