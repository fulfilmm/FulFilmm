<style>
    .scroll{
        height: 600px;
        overflow: scroll;
    }
</style>
<div class="row">
    <div class="col-md-4 col-sm-4 col-6">
        <div class="card shadow bg-white">
            <div class="card-body text-dark">
                <div class="d-flex justify-content-between">
                    <div>
                        <span class="d-block">New </span>
                    </div>

                </div>
                <h3 class="mb-3">{{$status_report['New']}}</h3>
                <div class="progress mb-2" style="height: 5px;">
                    <div class="progress-bar bg-dark" role="progressbar"
                         style="width: {{$report_percentage['New']}}%;"
                         aria-valuenow="{{$report_percentage['New']}}" aria-valuemin="0"
                         aria-valuemax="100"></div>
                </div>
                <div>
                    <span class="text-dark">{{$report_percentage['New']}}%</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-4 col-6">
        <div class="card shadow bg-warning">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between">
                    <div>
                        <span class="d-block">Open </span>
                    </div>

                </div>
                <h3 class="mb-3">{{$status_report['Open']}}</h3>

                <div class="progress mb-2" style="height: 5px;">
                    <div class="progress-bar bg-dark" role="progressbar"
                         style="width: {{$report_percentage['Open']}}%;"
                         aria-valuenow="{{$report_percentage['Open']}}" aria-valuemin="0"
                         aria-valuemax="100"></div>

                </div>
                <div>
                    <span class="text-white">{{$report_percentage['Open']}}%</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-4 col-6">
        <div class="card shadow bg-gradient-purple">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between">
                    <div>
                        <span class="d-block">In-progress </span>
                    </div>

                </div>
                <h3 class="mb-3">{{$status_report['In Progress']}}</h3>
                <div class="progress mb-2" style="height: 5px;">
                    <div class="progress-bar bg-dark" role="progressbar"
                         style="width: {{$report_percentage['In-progress']}}%;"
                         aria-valuenow="{{$report_percentage['In-progress']}}" aria-valuemin="0"
                         aria-valuemax="100"></div>
                </div>
                <div>
                    <span class="text-white">{{$report_percentage['Overdue']}}%</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-4 col-6">
        <div class="card shadow bg-info">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between">
                    <div>
                        <span class="d-block">Pending </span>
                    </div>

                </div>
                <h3 class="mb-3">{{$status_report['Pending']}}</h3>
                <div class="progress mb-2" style="height: 5px;">
                    <div class="progress-bar bg-dark" role="progressbar"
                         style="width: {{$report_percentage['Pending']}}%;"
                         aria-valuenow="{{$report_percentage['Pending']}}" aria-valuemin="0"
                         aria-valuemax="100"></div>
                </div>
                <div>
                    <span class="text-white">{{$report_percentage['Pending']}}%</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-4 col-6">
        <div class="card shadow bg-gradient-success">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between ">
                    <div>
                        <span class="d-block">Solved </span>
                    </div>
                </div>
                <h3 class="mb-3">{{$status_report['Complete']+$status_report['Close']}}</h3>
                <div class="progress mb-2" style="height: 5px;">
                    <div class="progress-bar bg-dark" role="progressbar"
                         style="width: {{$report_percentage['Solve']}}%;"
                         aria-valuenow="{{$report_percentage['Solve']}}" aria-valuemin="0"
                         aria-valuemax="100"></div>
                </div>
                <div>
                    <span class="text-white">{{$report_percentage['Solve']}}%</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-4 col-6">
        <div class="card shadow bg-gradient-danger">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between">
                    <div>
                        <span class="d-block">Overdue </span>
                    </div>

                </div>
                <h3 class="mb-3">{{$status_report['Overdue']}}</h3>
                <div class="progress mb-2" style="height: 5px;">
                    <div class="progress-bar bg-primary" role="progressbar"
                         style="width: {{$report_percentage['Overdue']}}%;"
                         aria-valuenow="{{$report_percentage['Overdue']}}" aria-valuemin="0"
                         aria-valuemax="100"></div>
                </div>
                <div>
                    <span class="text-white">{{$report_percentage['Overdue']}}%</span>
                </div>
            </div>
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