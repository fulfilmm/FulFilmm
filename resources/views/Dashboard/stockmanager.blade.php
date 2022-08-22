<div class="row g-3 row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-4">
    <div class="col  my-2">
        <div class="alert-success alert mb-0 shadow">
            <a href="{{route('warehouses.index')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-success text-light shadow"><i class="fa fa-home fa-lg"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Total Warehouses</div>
                        <span class="small">{{$items['warehouse']}}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col  my-2">
        <div class="alert-success alert mb-0 shadow">
            <a href="{{route('approvals.index')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-success text-light shadow"><i class="fa fa-check-circle-o fa-lg"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Requestation</div>
                        <span class="small">{{$items['requestation']}}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col  my-2">
        <div class="alert-success alert mb-0 shadow">
            <a href="{{route('products.index')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-success text-light shadow"><i class="fa fa-cube fa-lg"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Total Items</div>
                        <span class="small">{{$items['no_product_item']}}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col  my-2">
        <div class="alert-success alert mb-0 shadow">
            <a href="{{route('warehouses.index')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-success text-light shadow"><i class="fa fa-dollar fa-lg"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Stock Valuation</div>
                        <span class="small">{{$items['valuation']}}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>


</div>
<div class="row g-3 row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-4">
    <div class="col my-2">
        <div class="alert-warning alert mb-0 shadow">
            <a href="{{route('meetings.index')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-warning text-light shadow"><i class="fa fa-calendar fa-lg"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Meeting</div>
                        <span class="small">{{$items['meeting']}}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col my-2">
        <div class="alert-info alert mb-0 shadow">
            <a href="{{route('meetings.index')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-list-ul" aria-hidden="true"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Assignment</div>
                        <span class="small">{{$items['assignment']}}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col my-2">
        <div class="alert-info alert mb-0 shadow">
            <a href="{{route('groups.index')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-users" aria-hidden="true"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Group</div>
                        <span class="small">{{$items['my_groups']}}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col my-2">
        <div class="alert-danger alert mb-0 shadow">
            <a href="{{route('tickets.index')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-danger text-light shadow"><i class="la la-ticket la-lg"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Total Tickets</div>
                        <span class="small">{{$items['all_ticket']}}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col my-2">
        <div class="alert-info alert mb-0 shadow">
            <a href="{{route('schedule.index')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-list" aria-hidden="true"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Upcoming Schedule</div>
                        <span class="small">{{$items['upcoming_schedule']}}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col my-2">
        <div class="alert-info alert mb-0 shadow">
            <a href="{{route('assignments.index')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-list" aria-hidden="true"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Upcoming Task</div>
                        <span class="small">{{$items['upcoming_task']}}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>