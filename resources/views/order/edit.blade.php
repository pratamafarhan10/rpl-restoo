@extends('layouts.nonav', ['title' => 'Delivery Menu'])

@section('content')

<div class="container left-order-content">
    <div class="row">
        <a href="{{ route('order.index') }}">
            <img src="{{ asset("img/icon/logo waiter.png") }}" class="logo-waiter-seat">
        </a>
        <h1 class="text-center title-fitur">Delivery <strong>Menu</strong></h1>
    </div>

    <div class="row">
        <div class="d-flex justify-content-between my-2">
            <a href="{{ route('order.index') }}" class="btn btn-danger">Back</a>

            <form action="{{ route('order.update') }}" method="POST">
                @csrf
                @method('patch')
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateMenu1">
                    Delivered
                </button>
        </div>
    </div>

    <div class="row">
        @include('layouts.alert')
    </div>

    <div class="row">
        <div class="card card-category mb-2">
            <div class="row my-auto fw-bold">
                <div class="col-md-3 d-flex align-items-center">
                    <p>No</p>
                </div>
                <div class="col-md-3 d-flex align-items-center">
                    <p>Nama Menu</p>
                </div>
                <div class="col-md-3 d-flex align-items-center">
                    <p>Qty</p>
                </div>
                <div class="col-md-3 text-center">
                    <p>Delivered</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach($orders as $index => $order)
        <!-- List Pesanan -->
        <div class="card card-category card-list-pembayaran mb-2">
            <div class="row my-auto fw-bold">
                <div class="col-md-3 d-flex align-items-center">
                    <p>{{ $index + 1 }}</p>
                </div>
                <div class="col-md-3 d-flex align-items-center">
                    <p>{{ $order->food->name }}</p>
                </div>
                <div class="col-md-3 d-flex align-items-center">
                    <p>{{ $order->total_order - $order->total_delivered }}</p>
                </div>
                <div class="col-md-3 d-flex justify-content-center">
                    @if($order->total_order - $order->total_delivered == 0)
                    <p>All Delivered</p>
                    @else
                    <div class="row">
                        <div class="input-group d-flex align-items-center">
                            <span class="input-group-btn mx-auto text-center">
                                <button type="button" class="btn btn-secondary btn-number btn-pesan-number" disabled="disabled" data-type="minus" data-field="total[{{$order->id }}]">-</button>
                            </span>
                            <input type="text" name="total[{{ $order->id }}]" class="form-control input-number my-2 text-center pesan-number plus-minus-update-pemesanan" value="0" min="0" max="{{$order->total_order - $order->total_delivered}}">
                            <span class="input-group-btn mx-auto text-center">
                                <button type="button" class="btn btn-secondary btn-number btn-pesan-number" data-type="plus" data-field="total[{{ $order->id }}]">+</button>
                            </span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="updateMenu1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content navres">
            <div class="modal-header">
                <h5 class="modal-title-payment" id="exampleModalLabel">Delivery Menu</h5>
            </div>
            <div class="modal-body">
                <div class="row text-center mb-4">
                    <h1 class="payment-check-message">Masukkan kode untuk update menu yang dikirimkan</h1>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="input-form mx-auto">
                        <input type="password" class="form-control rounded" placeholder="Kode" name="code" id="code">
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col text-right">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                    <div class="col">
                        <button class="btn btn-primary" type="submit">Ok</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection