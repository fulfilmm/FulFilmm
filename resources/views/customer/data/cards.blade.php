@extends('customer.index')
@section('data')
<div class="row staff-grid-row">
    @forelse($customers as $customer)
    <x-partials.card route="customers" image="{{$customer->profile!=null? url(asset('img/profiles/'.$customer->profile)):url(asset('img/profiles/avatar-01.jpg'))}}"  id="{{$customer->id}}" title="{{$customer->name}}"  subtitle="{{$customer->email}}">  </x-partials.card>
    @empty
    <div class="col-12 text-center">
        <span class="text-center">@lang('messages.no-item-pls-add', ['name' => 'Contact'])</span>
    </div>
    @endforelse
</div>
{{$customers->links()}}

@endsection
