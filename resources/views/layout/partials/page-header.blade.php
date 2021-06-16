{{-- Modals --}}
@if($import === true)
    <x-partials.modal id="import" title="Customer Import">
        <x-forms.import route="{{$route. '.import'}}"></x-forms.import>
    </x-partials.modal>
@endif

@if($export === true)
    <x-partials.modal id="export" title="Export">
        <x-forms.export route="{{$route. '.export'}}"></x-forms.export>
    </x-partials.modal>
@endif


<div class="page-header">
    <div class="row align-items-center mb-3">
        <div class="col">
            @include('layout.partials.breadcrumb',['header'=> ucfirst($route).'Table'])
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="{{route('customers.create')}}" class="btn add-btn"><i class="fa fa-plus"></i>
                Add {{ucfirst($route)}}</a>
            <div class="view-icons">
                @if($card === true)
                    <a href="{{route($route.'.cards')}}" class="grid-view btn btn-link"><i class="fa fa-th"></i></a>
                @endif
                @if($list === true)
                    <a href="{{route($route.'.index')}}" class="list-view btn btn-link active"><i
                            class="fa fa-bars"></i></a>
                @endif
            </div>
        </div>
    </div>
    <div class="row align-items-center">
        <div class="col-auto float-right ml-auto">
            @if($import === true)
                <a href="{{route($route.'.import')}}" data-toggle="modal" data-target="#import"
                   class="btn btn-primary rounded mr-3">Import</a>
            @endif
            @if($export === true)
                <a href="{{route($route.'.export')}}" data-toggle="modal" data-target="#export"
                   class="btn btn-primary rounded mr-3">Export</a>
            @endif
        </div>
    </div>
</div>
