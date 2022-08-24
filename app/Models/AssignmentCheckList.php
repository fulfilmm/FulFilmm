<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentCheckList extends Model
{
    use HasFactory;
    protected $fillable=[
      'description','emp_id','assignment_id','remark','done'
    ];
}
