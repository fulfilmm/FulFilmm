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
                    <th>Customer Email</th>
                    <th>Phone</th>
                    <th>Lead Title</th>
                    <th>Sale Person</th>
                    <th>Followed Staff</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Industry</th>
                    <th>Created</th>
                    <th class="text-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($all_leads as $lead)
                    <tr>
                        <td>{{$lead->id}}</td>
                        <td>{{$lead->lead_id}}</td>
                        <td>
                            <h2 class="table-avatar">
                                @if($lead->customer->profile==null)
                                    <a href="#" class="avatar"><img alt="" src="img/profiles/avatar-11.jpg"></a>
                                    <a href="#">{{$lead->customer->customer_name}}</a>
                                @else
                                    <a href="{{url("/profile/".$lead->customer->id)}}" ><img alt="" class="avatar" src="{{asset("/profile/".$lead->customer->profile)}}"></a>
                                    <a href="{{url("/profile/".$lead->customer->id)}}">{{$lead->customer->customer_name}}</a>
                                @endif
                            </h2>
                        </td>
                        <td>{{$lead->customer->email}}</td>
                        <td>{{$lead->customer->phone}}</td>
                        <td><a href="{{route('leads.show',$lead->id)}}">{{$lead->title}}</a></td>
                        <td><a href="">
                                @if($lead->customer->profile==null)
                                    <a href="{{url("/emp/profile/$lead->sale_man_id")}}" class="avatar"><img alt="" src="img/profiles/avatar-11.jpg"></a>
                                    {{$lead->saleMan->name}}
                                @else
                                    <a href="{{url("/emp/profile/$lead->sale_man_id")}}" >
                                        <img alt="" class="avatar" src="{{asset("/profile/".$lead->saleMan->emp_profile)}}"></a>
                                    {{$lead->saleMan->name}}
                            </a>
                            @endif
                            </a>
                        </td>
                        <td>
                            @php
                            $i=0;
                            @endphp
                            <ul class="team-members">
                                <li class="dropdown avatar-dropdown">
                                    <a href="#" class="all-users dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="la la-user-plus" style="font-size: 16px;"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <div class="avatar-group">
{{--                                            @dd($followers)--}}
                                            @foreach($followers as $follower)
                                                @if($follower->lead_id==$lead->id)
                                                    <a  href="" title="{{$follower->user->name}}">
                                                        <span class="avatar"><img alt="" src="img/profiles/avatar-01.jpg"></span>
                                                    </a>
                                                    @php
                                                    $i ++;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="avatar-pagination">
                                            <ul class="pagination">
                                                <li class="page-item">
                                                    <a class="page-link" href="#" aria-label="Previous">
                                                        <span aria-hidden="true">«</span>
                                                        <span class="sr-only">Previous</span>
                                                    </a>
                                                </li>
                                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                <li class="page-item">
                                                    <a class="page-link" href="#" aria-label="Next">
                                                        <span aria-hidden="true">»</span>
                                                        <span class="sr-only">Next</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <span  style="font-size: 10px;color: red">{{$i}} Employee Followed</span>
                                </li>
                            </ul>
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
                        <td>{{$lead->created_at->toFormattedDateString()}}</td>
                        <td class="text-right">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{route('leads.edit',$lead->id)}}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                    <a class="dropdown-item" href="{{url("/lead/delete/$lead->id")}}"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
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
