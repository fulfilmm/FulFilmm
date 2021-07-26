@extends('layout.mainlayout')

@section('styles')
@livewireStyles
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center mb-3">
        <div class="col">
            @include('layout.partials.breadcrumb',['header'=>'Companies Table'])
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="{{route('companies.create')}}" class="btn add-btn"><i class="fa fa-plus"></i> Add Customer</a>


            <div class="view-icons">
                <a href="{{route('companies.cards')}}" class="grid-view btn btn-link"><i class="fa fa-th"></i></a>
                <a href="{{route('companies.index')}}" class="list-view btn btn-link active"><i class="fa fa-bars"></i></a>
            </div>
        </div>
    </div>
    <div class="row align-items-center">
        <div class="col-auto float-right ml-auto">
            <a href="#" data-toggle="modal" data-target="#customer-import" class="btn btn-primary rounded mr-3">Import</a>
            <a href="{{route('companies.export')}}"  class="btn btn-primary rounded mr-3">Export</a>
        </div>
    </div>
</div>

<div class="row staff-grid-row">
    @foreach($companies as $company)
    <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
        <div class="profile-widget">
            <div class="profile-img">
                <a href="{{route('companies.show',$company->id)}}" class="avatar"><img src="img/profiles/avatar-02.jpg" alt=""></a>
            </div>
            <div class="dropdown profile-action">
                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{route('companies.edit',$company->id)}}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                    <form action="{{route('companies.destroy',$company->id)}}" id="del-company{{$company->id}}" method="POST">
                        @method('delete')
                        @csrf
                        <a class="dropdown-item" href="#"onclick="deleteRecord({{$company->id}})"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </form>

                </div>
            </div>
            <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="profile">{{$company->name}}</a></h4>
            <div class="small text-muted">{{$company->business_type}}</div>
        </div>
    </div>
    @endforeach
</div>

@endsection

@push('scripts')
<script>
    function deleteRecord(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You cannot retrieve data back!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff9b44',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                'Deleted!',
                'Record has been deleted.',
                'success'
                ).then(() => {
                    document.getElementById("del-company"+id).submit();
                })

            }
        })
    }
</script>
@endpush
