@extends('layouts.nonav', ['title' => 'Available Seat'])

@section('content')

<div class="container left-order-content">
    <div class="row">
        <div class="col">
            <a href="{{ route('waiter.index') }}">
                <img src="{{ asset("img/icon/logo waiter.png") }}" class="logo-waiter-seat">
            </a>
        </div>
        <div class="col d-flex align-items-center justify-content-end">
            <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
        </div>
    </div>

    <div class="row">
        <h1 class="text-center title-fitur">Available <strong>Seat</strong></h1>
    </div>

    
        @asyncWidget('waiter_seat')
    
</div>

@endsection