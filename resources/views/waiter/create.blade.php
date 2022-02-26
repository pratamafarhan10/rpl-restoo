@extends('layouts.nonav', ['title' => 'Assign Seat'])

@section('content')

<div class="container left-order-content">
    <div class="row">
        <a href="{{ route('waiter.index') }}">
            <img src="{{ asset("img/icon/logo waiter.png") }}" class="logo-waiter-seat">
        </a>
    </div>


    <div class="row">
        <div class="card mx-auto" style="width: 600px; height: 380px">
            <div class="card-body">
                <div class="row">
                    <form action="{{ route('waiter.store', $table->id) }}" method="POST" class="mt-4" enctype="multipart/form-data">
                        @csrf
                        <div class="input-form mx-auto">
                            <h1 class="mejano">Meja No.</h1>
                        </div>
                        <div class="input-form mx-auto text-center">
                            <h1><span class="waiter-seat-number">{{$table->table_number}}</span></h1>
                        </div>
                        <div class="mb-3 input-form mx-auto">
                            <label for="customer_name" class="form-label">Nama Customer</label>
                            <input type="text" class="form-control rounded @error('customer_name') is-invalid @enderror" placeholder="Customer Name" name="customer_name" id="customer_name">
                            @error('customer_name')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-create">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection