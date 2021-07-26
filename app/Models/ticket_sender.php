<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ticket_sender extends Model
{
    use HasFactory;
    public function ticket_sender(){
        return $this->hasMany(ticket::class);
    }
}
