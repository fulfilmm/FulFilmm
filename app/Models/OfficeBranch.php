<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeBranch extends Model
{
    use HasFactory;
    protected $fillable=['name','address','type','parent_branch','head_office'];
    public function head(){
        return $this->belongsTo(HeadOffice::class,'head_office','id');
    }
}