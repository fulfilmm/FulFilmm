@extends('employee.index')

@section('data')
    <div class="row staff-grid-row">
        @forelse($employees as $employee)
            <x-partials.card
                route="customers"
                id="{{$employee->id}}"
                title="{{$employee->name}}"
                subtitle="{{$employee->email}}"
                route='employees'
                id="{{$employee->id}}"
            image="{{asset('img/profiles/'.$employee->profile_img)}}">

            </x-partials.card>
            @empty
            <div class="col-12 text-center">
                <span class="text-center">@lang('messages.no-item-pls-add', ['name' => 'employee'])</span> 
            </div>
            @endforelse
    </div>
    {{$employees->links()}}

@endsection
