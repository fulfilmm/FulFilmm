<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    protected $fillable=['name','branch_id','description'];
    public function branch(){
        return $this->belongsTo(OfficeBranch::class);
    }

}
