<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emailsetting extends Model
{
    use HasFactory;
    protected $fillable=['from_address','from_name','mail_server','host','port','password','security','auth_domain','isactive'];
}
