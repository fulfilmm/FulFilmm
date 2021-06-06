<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'message', 'target_id', 'target_keyword', 'employee_id'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
