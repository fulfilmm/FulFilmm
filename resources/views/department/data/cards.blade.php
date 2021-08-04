@extends('department.index')

@section('data')
    <div class="row staff-grid-row">
        @foreach($departments as $department)
            <x-partials.card
                route="customers"
                id="{{$department->id}}"
                title="{{$department->name}}">

            </x-partials.card>
        @endforeach
    </div>
    {{$departments->links()}}

@endsection
