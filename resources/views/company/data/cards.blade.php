@extends('company.index')

@section('data')
    <div class="row staff-grid-row">
        @foreach($companies as $company)
            <x-partials.card
                route="customers"
                id="{{$company->id}}"
                title="{{$company->name}}"
                subtitle="{{$company->business_type}}">

            </x-partials.card>
        @endforeach
    </div>
    {{$companies->links()}}

@endsection
