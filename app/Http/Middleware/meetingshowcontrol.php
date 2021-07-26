<?php

namespace App\Http\Middleware;

use App\Models\Meeting;
use App\Models\Meetingmember;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class meetingshowcontrol
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $current_user=Auth::guard('employee')->user()->id;
        $is_member=Meetingmember::where('meeting_id',$request->meeting)->where("member_id",$current_user)->first();
        $is_creater=Meeting::where("meeting_creater",$current_user)->where("id",$request->meeting)->first();
        if($is_creater==null && $is_member==null){
            abort(403, 'You do not have permission to access requested record!');
        }else{
                    return $next($request);
        }

    }
}
