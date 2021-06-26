@extends('company.index')

@section('data')
    <div class="row staff-grid-row">
        @forelse($companies as $company)
            <x-partials.card
                route="customers"
                id="{{$company->id}}"
                title="{{$company->name}}"
                subtitle="{{$company->business_type}}">

            </x-partials.card>
            @empty
            <div class="col-12 text-center">
                <span class="text-center">@lang('messages.no-item-pls-add', ['name' => 'company'])</span> 
            </div>
            @endforelse
    </div>
    {{$companies->links()}}

@endsection
