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
            @include('layout.partials.breadcrumb',['header'=> ucfirst($name)])
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="{{route($route.'.create')}}" class="btn add-btn"><i class="fa fa-plus"></i>
                Add {{ucfirst($name)}}</a>
            <div class="view-icons">
                @if($import === true)
                    <a href="{{route($route.'.import')}}" data-toggle="modal" data-target="#import"
                       class="btn btn-white rounded mr-3">Import</a>
                @endif
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

            @if($export === true)
                <a href="{{route($route.'.export')}}" data-toggle="modal" data-target="#export"
                   class="btn btn-outline-info rounded mr-3"><i class="fa fa-download mr-1"></i>Export</a>
            @endif
        </div>
    </div>
</div>
