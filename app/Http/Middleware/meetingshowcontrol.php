<?php

namespace App\Http\Middleware;

use App\Models\Approvalrequest;
use App\Models\assign_ticket;
use App\Models\Cc_of_approval;
use App\Models\deal;
use App\Models\lead_follower;
use App\Models\leadModel;
use App\Models\Meeting;
use App\Models\Meetingmember;
use App\Models\ticket;
use App\Models\ticket_follower;
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
        $current_user=Auth::guard('employee')->user();
        if(isset($request->meeting)){
            $is_member=Meetingmember::where('meeting_id',$request->meeting)->where("member_id",$current_user->id)->first();
            $is_creater=Meeting::where("meeting_creater",$current_user->id)->where("id",$request->meeting)->first();
            if($is_creater==null && $is_member==null){
                abort(403, 'You do not have permission to access requested record!');
            }else{
                return $next($request);
            }
        }elseif (isset($request->approval)){
            $approvals=Approvalrequest::where('emp_id',$current_user->id)->where('id',$request->approval)->first();
            $cc_approvals=Cc_of_approval::where('emp_id',$current_user->id)->where('approval_id',$request->approval)->first();
            if($approvals==null && $cc_approvals==null){

                abort(403, 'You do not have permission to access requested record!');
            }else{
                return $next($request);
            }
        }elseif (isset($request->ticket)){
            if(Auth::user()->role->name=="Employee"||Auth::user()->role->name=="Agent"){
                $ticket=ticket::where('id',$request->ticket)->where('created_emp_id',$current_user->id)->first();
                $aticket=assign_ticket::where("ticket_id",$request->ticket)->first();
                if($aticket!=null){
                    if($aticket->type_of_assign==0 && $aticket->agent_id==$current_user->id){
                        $is_has=false;
                    }elseif ($aticket->dept_id==$current_user->department_id){
                        $is_has=false;
                    }else{
                        $is_has=true;
                    }
                }else{
                    $is_has=false;
                }
                $is_followed=ticket_follower::where("ticket_id",$request->ticket)->where("emp_id",$current_user->id)->first();

                if($ticket==null && $is_has && $is_followed==null){
                    abort(403, 'You do not have permission to access requested record!');
                }else{
                    return $next($request);
                }
            }else{
                return $next($request);
            }
        }elseif (isset($request->lead)){
            $lead=leadModel::where('id',$request->lead)->where('created_id',$current_user->id)->first();
            $is_sale_man=leadModel::where('id',$request->lead)->where('sale_man_id',$current_user->id)->first();
            $lead_follow=lead_follower::where('lead_id',$request->lead)->where('follower_id',$current_user->id)->first();
            if ($current_user->role->name!="Super Admin" && $lead==null && $is_sale_man==null && $lead_follow==null) {
                abort(403, 'You do not have permission to access this lead view!');
             }else{
                return $next($request);
            }
        }elseif (isset($request->deal)){
                $created_deal=deal::where('id',$request->deal)->where("created_id",$current_user->id)->first();
                $assigned_deal=deal::where('id',$request->deal)->where("assign_to",$current_user->id)->first();
            if ($current_user->role->name=="Employee" || $current_user->role->name=="TicketAdmin") {
                if ($created_deal==null && $assigned_deal==null){
                    abort(403, 'You do not have permission to access this deal view!');
                }else{
                    return $next($request);
                }
            }else{
                return $next($request);
            }
        }


    }
}
