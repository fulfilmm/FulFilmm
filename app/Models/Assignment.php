<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'emp_id',
        'assignee_id',
        'description',
        'priority',
        'status',
        'end_date',
        'attach'
    ];
    public function owner(){
        return $this->belongsTo(Employee::class,'assignee_id','id');
    }
    public function responsible_emp(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
}
