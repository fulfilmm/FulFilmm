<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Authenticatable
{
    use HasFactory, SoftDeletes;
    use HasRoles;

    protected $guarded = [];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $fillable = [
        'name', 'department_id', 'role_id', 'phone', 'email',
        'work_phone', 'can_login','can_post_assignments', 'password', 'join_date'
    ];



    //relations
    public function department_name()
    {
        return $this->department()->first()->name;
    }
    public  function getRoleAttribute()
    {
        return $this->roles[0] ?? null;
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function assignments()
    {
        return $this->belongsToMany(Assignment::class, 'assignment_employee');
    }
<<<<<<< HEAD
    public function assign_ticket(){
        return $this->hasMany(assign_ticket::class);
    }
    public function ticket(){
        return $this->hasMany(ticket::class);
    }
    public function ticket_comment(){
        return $this->hasMany(ticket_comments::class);
    }
    public function followed(){
        return $this->hasMany(ticket_follower::class);
=======

    public function project_tasks()
    {
        return $this->belongsToMany(ProjectTask::class, 'project_task_employee');
>>>>>>> origin/develop
    }
}
