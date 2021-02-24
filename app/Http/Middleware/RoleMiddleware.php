<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class RoleMiddleware
{
    private $authorized_roles = ['Super Admin', 'CEO'];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('employee')->user();
        try {
            $role = $user->role;
        }catch (Exception $e){
            throw UnauthorizedException::notLoggedIn();
        }
        $requested_route_name = $request->route()->getName();
        if ($role->hasPermissionTo($requested_route_name, 'employee') || in_array($role->name, $this->authorized_roles)) {
            return $next($request);
        }
        abort(403, "Sorry, You do not have enough position to perform this action!");
    }
}
