@extends('employee.index')

@section('data')
    <div class="row staff-grid-row">
        @foreach($employees as $employee)
            <x-partials.card
                route="customers"
                id="{{$employee->id}}"
                title="{{$employee->name}}"
                subtitle="{{$employee->email}}">

            </x-partials.card>
        @endforeach
    </div>
    {{$employees->links()}}

@endsection
