
<div class="row g-3 col-md-8 offset-md-2 col-sm-8 offset-md-2 col-12 offset-0 my-3 justify-content-center">
    <div class="col-6 col-sm-3 col-md-4 my-2">
        <div class="alert-light alert mb-0 shadow">
            <a href="{{route('invoices.create')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-dollar fa-lg"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Whole Sale</div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-6 col-sm-3 col-md-4 my-2">
        <div class="alert-light alert mb-0 shadow">
            <a href="{{url('retail/invoice/create')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-warning text-light shadow"><i class="fa fa-dollar fa-lg"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Retail Sale</div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
<hr>
<div class="row g-3 row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-4 my-3">
    <div class="col-6 col-sm-3 col-md-4 my-2">
        <div class="alert-success alert mb-0 shadow">
            <a href="{{route('invoices.index')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-success text-light shadow"><i class="fa fa-file-text fa-lg"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Invoice</div>
                        <span class="small">{{$items['invoice']}}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-6 col-sm-3 col-md-4 my-2">
        <div class="alert-success alert mb-0 shadow">
            <a href="{{route('employees.index')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-success text-light shadow"><i class="fa fa-money fa-lg"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">In Hand Amount</div>
                        <span class="small">{{\Illuminate\Support\Facades\Auth::guard('employee')->user()->amount_in_hand}}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-6 col-sm-3 col-md-4 my-2">
        <div class="alert-success alert mb-0 shadow">
            <a href="{{route('employees.index')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-success text-light shadow"><i class="fa fa-retweet fa-lg"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Transferred Amount</div>
                        <span class="small">{{$items['transferred_amount']??0}}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-6 col-sm-3 col-md-4 my-2">
        <div class="alert-success alert mb-0 shadow">
            <a href="{{route('employees.index')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-success text-light shadow"><i class="fa fa-credit-card fa-lg"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Receivable</div>
                        <span class="small">{{$items['receivable']??0}}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-6 col-sm-3 col-md-4 my-2">
        <div class="alert-success alert mb-0 shadow">
            <a href="{{route('expense_record.index')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-success text-light shadow"><i class="fa fa-dollar fa-lg"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Expense</div>
                        <span class="small">{{$items['expense']??0}}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-6 col-sm-3 col-md-4 my-2">
        <div class="alert-success alert mb-0 shadow">
            <a href="{{route('warehouses.index')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-success text-light shadow"><i class="fa fa-puzzle-piece fa-lg"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Stock Balance</div>
                        <span class="small">{{$items['stock_balance']??0}}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-6 col-sm-3 col-md-4 my-2">
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
    <div class="col-6 col-sm-3 col-md-4 my-2">
        <div class="alert-success alert mb-0 shadow">
            <a href="{{route('customers.index')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-success text-light shadow"><i class="fa fa-users fa-lg"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Customer</div>
                        <span class="small">{{$items['customer']}}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-6 col-sm-3 col-md-4 my-2">
        <div class="alert-success alert mb-0 shadow">
            <a href="{{url('sale/activity')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-success text-light shadow"><i class="fa fa-list-ol fa-lg"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Sale Activities</div>
                        <span class="small">{{$items['saleactivity']}}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-6 col-sm-3 col-md-4 my-2">
        <div class="alert-success alert mb-0 shadow">
            <a href="{{route('meetings.index')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-success text-light shadow"><i class="fa fa-list-ul" aria-hidden="true"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Assignment</div>
                        <span class="small">{{$items['assignment']}}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-6 col-sm-3 col-md-4 my-2">
        <div class="alert-success alert mb-0 shadow">
            <a href="{{route('groups.index')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-success text-light shadow"><i class="fa fa-users" aria-hidden="true"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Group</div>
                        <span class="small">{{$items['my_groups']}}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-6 col-sm-3 col-md-4 my-2">
        <div class="alert-success alert mb-0 shadow">
            <a href="{{route('tickets.index')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-success text-light shadow"><i class="la la-ticket la-lg"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Total Tickets</div>
                        <span class="small">{{$items['all_ticket']}}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-6 col-sm-3 col-md-4 my-2">
        <div class="alert-success alert mb-0 shadow">
            <a href="{{route('meetings.index')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-success text-light shadow"><i class="fa fa-calendar fa-lg"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Meeting</div>
                        <span class="small">{{$items['meeting']}}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
