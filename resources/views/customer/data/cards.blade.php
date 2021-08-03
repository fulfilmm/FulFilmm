@extends('customer.index')
@section('data')
<div class="row staff-grid-row">
    @forelse($customers as $customer)
    <x-partials.card route="customers"  id="{{$customer->id}}" title="{{$customer->name}}"  subtitle="{{$customer->email}}">  </x-partials.card>
    @empty
    <div class="col-12 text-center">
        <span class="text-center">@lang('messages.no-item-pls-add', ['name' => 'customer'])</span> 
    </div>
    @endforelse
</div>
{{$customers->links()}}

@endsection
