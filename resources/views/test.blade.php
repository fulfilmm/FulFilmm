@extends('layout.mainlayout')
@section('title','')
@section('content')
    <div class="container-fluid">
        <form action="{{url('oauth/clients')}}" method="POST">
            @csrf
            <input type="text" name="name">
            <input type="text" name="url">
    <button type="submit">Submit</button>
        </form>
    </div>
    @endsection