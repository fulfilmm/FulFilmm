<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssginmentComment extends Model
{
    use HasFactory;
    protected $fillable=['assignment_id','emp_id','comment','attach'];
    public function employee(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }

}
