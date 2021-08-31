<div class="col-md-12">
    <div class="table-responsive">
        <div style="overflow-x: auto">
            {{--            @dd($followers)--}}
            <table id="lead" class="table  table-nowrap custom-table mb-0 ">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Lead ID</th>
                    <th>Customer Name</th>
                    <th>Lead Title</th>
                    <th>Sale Person</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Industry</th>
                    <th>Lead Or Inquery</th>
                    <th>Created</th>
                    <th class="text-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($all_leads as $lead)
                    <tr>
                        <td>{{$lead->id}}</td>
                        <td><a href="{{route('leads.show',$lead->id)}}">#{{$lead->lead_id}}</a></td>
                        <td>
                            <h2 class="table-avatar">

                                <a href="{{url("/profile/".$lead->customer->id)}}">
                                    <img alt="" class="avatar" src="{{asset("/profile/".$lead->customer->profile)}}">
                                    {{$lead->customer->customer_name}}</a>
                            </h2>
                        </td>
                        <td><a href="{{route('leads.show',$lead->id)}}">{{$lead->title}}</a></td>
                        <td>
                            <a href="{{route("employees.show",$lead->sale_man_id)}}">
                                <img alt="" class="avatar"
                                     src="{{$lead->saleMan->profile_img?url(asset('img/profiles/'.$lead->saleMan->profile_img)):url(asset('img/profiles/avatar-11.jpg'))}}">
                                {{$lead->saleMan->name}}</a>
                        </td>
                        <td>
                            {{$lead->priority}}
                        </td>
                        <td>@if($lead->is_qulified==1)
                                <span class="badge bg-inverse-success">Qualified</span>
                            @else
                                <span class="badge bg-inverse-danger">Unqualified</span>
                            @endif
                        </td>
                        <td>{{$lead->tags->tag_industry}}
                        </td>
                        <td>{{$lead->type==1?'Lead':'Inquery'}}</td>
                        <td>{{$lead->created_at->toFormattedDateString()}}</td>
                        <td class="text-right">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                   aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{route('leads.edit',$lead->id)}}"><i
                                                class="fa fa-pencil m-r-5"></i> Edit</a>
                                    <a class="dropdown-item" href="{{url("/lead/delete/$lead->id")}}"><i
                                                class="fa fa-trash-o m-r-5"></i> Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
