<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeBranch extends Model
{
    use HasFactory;
    protected $fillable=['name','address','type','parent_branch','head_office'];
    public function parent(){
        return $this->belongsTo(OfficeBranch::class,'parent_branch','id');
    }
}
