<div class="row g-3 row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-4">
    <div class="col my-2">
        <div class="alert-secondary alert mb-0 shadow">
            <a href="{{route('tickets.index')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-warning text-light shadow"><i class="fa fa-ticket fa-lg"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Total Ticket</div>
                        <span class="small">{{$items['all_ticket']}}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col my-2">
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
    <div class="col my-2">
        <div class="alert-secondary alert mb-0 shadow">
            <a href="{{route('tickets.index')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-primary text-light shadow"><i class="fa fa-envelope-open fa-lg"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Open</div>
                        <span class="small">{{$status_report['Open']}}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col my-2">
        <div class="alert-secondary alert mb-0 shadow">
            <a href="{{route('tickets.index')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-cogs fa-lg"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">In Progress</div>
                        <span class="small">{{$status_report['In Progress']}}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>


</div>
<div class="row g-3  row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-4">
    <div class="col my-2">
        <div class="alert-warning alert mb-0 shadow">
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
    <div class="col my-2">
        <div class="alert-warning alert mb-0 shadow">
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
    <div class="col my-2">
        <div class="alert-warning alert mb-0 shadow">
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


    <div class="col my-2">
        <div class="alert-warning alert mb-0 shadow">
            <a href="{{route('meetings.index')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-warning text-light shadow"><i class="fa fa-th-list fa-lg"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Assigment</div>
                        <span class="small">{{$items['assignment']}}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
<div class="row g-3 row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-4">

    <div class="col my-2">
        <div class="alert-success alert mb-0 shadow">
            <a href="{{route('meetings.index')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-calendar fa-lg"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Meetings</div>
                        <span class="small">{{$items['meeting']}}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col my-2">
        <div class="alert-success alert mb-0 shadow">
            <a href="{{route('tickets.index')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-warning text-light shadow"><i class="fa fa-group" aria-hidden="true"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Group</div>
                        <span class="small">{{$items['my_groups']}}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col my-2">
        <div class="alert-success alert mb-0 shadow">
            <a href="{{route('customers.index')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-light text-dark shadow"><i class="la la-users la-lg" aria-hidden="true"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Customer</div>
                        <span class="small">{{$items['customer']}}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col my-2">
        <div class="alert-success alert mb-0 shadow">
            <a href="{{route('approvals.index')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-danger text-light shadow"><i class="fa fa-check-circle-o fa-lg" aria-hidden="true"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Requestation</div>
                        <span class="small">{{$items['requestation']}}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>