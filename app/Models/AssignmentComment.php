<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentComment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'commenter_id', 'assignment_id', 'is_read', 'file', 'file_name', 'message'
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'assignment_id');
    }


    public function user()
    {
        return $this->belongsTo(Employee::class, 'commenter_id');
    }
}