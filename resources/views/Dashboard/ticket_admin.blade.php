<style>
    .scroll{
        height: 600px;
        overflow: scroll;
    }
</style>
<div class="row g-3 mb-3 row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-4">
    <div class="col">
        <div class="alert-secondary alert mb-0 shadow">
            <a href="{{route('tickets.index')}}">
            <div class="d-flex align-items-center">
                <div class="avatar rounded no-thumbnail bg-light text-dark shadow"><i class="fa fa-bell fa-lg"></i></div>
                <div class="flex-fill ms-3 text-truncate">
                    <div class="h6 mb-0">New</div>
                    <span class="small">{{$status_report['New']}}</span>
                </div>
            </div>
            </a>
        </div>
    </div>
    <div class="col">
        <div class="alert-danger alert mb-0 shadow">
            <a href="{{route('tickets.index')}}">
            <div class="d-flex align-items-center">
                <div class="avatar rounded no-thumbnail bg-danger text-light shadow"><i class="fa fa-envelope-open fa-lg"></i></div>
                <div class="flex-fill ms-3 text-truncate">
                    <div class="h6 mb-0">Open</div>
                    <span class="small">{{$status_report['Open']}}</span>
                </div>
            </div>
            </a>
        </div>
    </div>
    <div class="col">
        <div class="alert-warning alert mb-0 shadow">
            <a href="{{route('tickets.index')}}">
            <div class="d-flex align-items-center">
                <div class="avatar rounded no-thumbnail bg-warning text-light shadow"><i class="fa fa-cogs fa-lg"></i></div>
                <div class="flex-fill ms-3 text-truncate">
                    <div class="h6 mb-0">In Progress</div>
                    <span class="small">{{$status_report['In Progress']}}</span>
                </div>
            </div>
            </a>
        </div>
    </div>
    <div class="col">
        <div class="alert-info alert mb-0 shadow">
            <a href="{{route('tickets.index')}}">
            <div class="d-flex align-items-center">
                <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-hourglass" aria-hidden="true"></i></div>
                <div class="flex-fill ms-3 text-truncate">
                    <div class="h6 mb-0">Pending</div>
                    <span class="small">{{$status_report['Pending']}}</span>
                </div>
            </div>
            </a>
        </div>
    </div>
    <div class="col">
        <div class="alert-success alert mb-0 shadow">
            <a href="{{route('tickets.index')}}">
            <div class="d-flex align-items-center">
                <div class="avatar rounded no-thumbnail bg-success text-light shadow"><i class="fa fa-check" aria-hidden="true"></i></div>
                <div class="flex-fill ms-3 text-truncate">
                    <div class="h6 mb-0">Solved</div>
                    <span class="small">{{$status_report['Complete']+$status_report['Close']}}</span>
                </div>
            </div>
            </a>
        </div>
    </div>
    <div class="col">
        <div class="alert-danger alert mb-0 shadow">
            <a href="{{route('tickets.index')}}">
            <div class="d-flex align-items-center">
                <div class="avatar rounded no-thumbnail bg-danger text-light shadow"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                <div class="flex-fill ms-3 text-truncate">
                    <div class="h6 mb-0">Over Due</div>
                    <span class="small">{{$status_report['Overdue']}}</span>
                </div>
            </div>
            </a>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-6">
        <h4>Agent Performance</h4>
       <div class="col-12 scroll">
           <div class="row">

               @foreach($agents as $agent)
                   @php $agent_ticket=[];
                                            $solved_ticket=0;
                                            $overdue_status=\App\Models\status::where('name','Overdue')->first();
                                            $overdue=0;
                                        foreach ($assign_ticket as $item) {
                                             if($item->agent_id==$agent->id ){
                                                 array_push($agent_ticket,$item);
                                                 foreach ($status as $st){
                                                    if($st->id==$item->ticket->status){
                                                        $solved_ticket ++;
                                                    }
                                                }
                                                foreach ($status as $st){
                                                    if($item->dept_id==$agent->department_id){
                                                        $solved_with_dept ++;
                                                    }
                                                }
                                                if($item->ticket->status==$overdue_status->id){
                                                     $overdue ++;
                                                    }

                                             }
                                        }
                   @endphp
                   <div class="card col-12 shadow">
                       <div class="row mt-3">
                           <div class="col-md-2 col-3">
                               <img
                                       src="{{$agent->profile_img!=null? url(asset('img/profiles/'.$agent->profile_img)):url(asset('img/profiles/avatar-01.jpg'))}}"
                                       alt="" class="avatar chat-avatar-sm">
                           </div>
                           <div class="col-md-8 col-8">{{$agent->name}}</div>
                       </div>
                       <div class="row mb-3">
                           <div class="col-md-10 offset-md-2 offset-3 col-9">
                               <div class="row">
                                   <div class="col-md-4 col-4">
                                       <span class="text-muted">All Tickets :</span><span> {{count($agent_ticket)}}</span>
                                   </div>
                                   <div class="col-md-4 col-4">
                                       <span class="text-muted">Solved :</span><span> {{$solved_ticket}}</span>
                                   </div>
                                   <div class="col-md-4 col-4">
                                       <span class="text-muted">Overdue :</span><span> {{$overdue}}</span>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               @endforeach
           </div>
       </div>
    </div>
    <div class="col-md-6 ">
        <h4>Department Performance</h4>
        <div class="col-12 scroll">
            <div class="row">
                @foreach($depts as $dept)
                    @php $dept_ticket=0;
                                            $solved_with_dept=0;
                                            $overdue_status=\App\Models\status::where('name','Overdue')->first();
                                            $overdue=0;
                                        foreach ($assign_ticket as $item) {
                                             if($item->dept_id==$dept->id ){
                                                 $dept_ticket ++;
                                                 foreach ($status as $st){
                                                    if($st->id==$item->ticket->status){
                                                        $solved_with_dept ++;
                                                    }
                                                        }
                                                if($item->ticket->status==$overdue_status->id){
                                                     $overdue ++;
                                                    }

                                             }
                                        }
                    @endphp
                    <div class="card col-12 shadow">
                        <div class="row mt-3">
                            <div class="col-md-12 col-12">{{$dept->name}}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4 col-4">
                                        <span class="text-muted">All Tickets :</span><span> {{$dept_ticket}}</span>
                                    </div>
                                    <div class="col-md-4 col-4">
                                        <span class="text-muted">Solved :</span><span> {{$solved_with_dept}}</span>
                                    </div>
                                    <div class="col-md-4 col-4">
                                        <span class="text-muted">Overdue :</span><span> {{$overdue}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>