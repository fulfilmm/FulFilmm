<?php

namespace App\Http\Middleware;

use App\Models\Activity;
use App\Models\Employee;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnershipMiddleware
{

    protected $routes_required_ownerships = ['activities.show'];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $requested_route = $request->route()->getName();
        //check requested route is required to check ownership
        if(in_array($requested_route, $this->routes_required_ownerships))
        {
            //check it is activity
            if (!is_null($request->route('activity'))) {
                $record = Activity::findOrFail($request->route()->activity);
            }

            $logged_in_user = Auth::guard('employee')->user();
            //check requested data owner is logged in
            if ($logged_in_user->id == $record->employee_id) {
                return $next($request);
            }elseif ($logged_in_user->role->name == 'Manager') {
                $logged_in_user_department = Employee::find($logged_in_user->id)->department;
                $owner_department = Employee::find($record->employee_id)->department;
                //same department from manager check record
                if ($logged_in_user_department->id == $owner_department->id) {
                    return $next($request);
                }
            }elseif ($logged_in_user->role->name == 'CEO') {
                return $next($request);
            }
            else {
                abort(403, 'You do not have permission to access requested record!');
            }
        } else{
            //routes do not need to check ownership
            return $next($request);
        }

    }
}
