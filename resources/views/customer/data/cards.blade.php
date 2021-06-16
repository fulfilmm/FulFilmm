@extends('customer.index')


@section('data')
    <div class="row staff-grid-row">
        @foreach($customers as $customer)
            <x-partials.card
                route="customers"
                id="{{$customer->id}}"
                title="{{$customer->name}}"
                subtitle="{{$customer->email}}">

            </x-partials.card>
        @endforeach
    </div>
    {{$customers->links()}}

@endsection
