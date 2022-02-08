@extends('employee.index')
<style>
    svg {
        height: 20px;
    }

</style>

@section('data')

    <form action="{{url('employee/search')}}" method="GET">
        @csrf
        <div class="row">
            <div class="col-md-3 offset-md-9 float-right">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control form-control-sm float-right rounded-pill" placeholder="Search">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-white rounded-pill"><i class="la la-search "></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

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
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end">
                {{$employees->links()}}
            </ul>
        </nav>
    </div>

@endsection
