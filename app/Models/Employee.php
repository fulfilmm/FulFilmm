<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Employee extends Authenticatable implements JWTSubject
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
        'work_phone', 'can_login','can_post_assignments', 'password', 'join_date','office_branch_id','empid'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

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
    public function branch(){
        return $this->belongsTo(OfficeBranch::class,'office_branch_id','id');
    }

//    public function assignments()
//    {
//        return $this->belongsToMany(Assignment::class, 'assignment_employee');
//    }
    public function assign_ticket(){
        return $this->hasMany(assign_ticket::class);
    }
    public function ticket(){
        return $this->hasMany(ticket::class);
    }
    public function ticket_comment(){
        return $this->hasMany(ticket_comments::class);
    }
    public function followed()
    {
        return $this->hasMany(ticket_follower::class);
    }
    public function reportperson(){
        return $this->belongsTo(Employee::class,'report_to','id');
    }
//    public function project_tasks()
//    {
//        return $this->belongsToMany(ProjectTask::class, 'project_task_employee');
//    }
}
