@extends('layouts.nonav', ['title' => 'Order'])

@section('content')
<div class="container-fluid vh-100">
    <div class="row vh-100">

        <div class="col-7 left-order-content">
            <div class="row">
                <a href="{{ route('order.index') }}">
                    <img src="{{ asset("img/icon/logo waiter.png") }}" class="logo-waiter-seat">
                </a>
            </div>
            @asyncWidget('customer_table')
        </div>

        <div class="col-5 right-order-content mh-100">
            <div class="row right-order-content-title d-flex align-items-end mb-3">
                <h1 class="">Pesanan</h1>
            </div>

            <div class="row right-order-content-pesanan overflow-auto">
                <div class="container">
                    <div class="row listOrder fw-bold">
                        <div class="col-md-6">
                            <p>Nama Makanan</p>
                        </div>
                        <div class="col-md-1">
                            <p>O</p>
                        </div>
                        <div class="col-md-1">
                            <p>D</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <p>Price</p>
                        </div>
                    </div>
                    @forelse($orders as $order)
                    <div class="row {{ $order->is_delivered == 0 ? 'text-muted' : null }} listOrder">
                        <div class="col-md-6">
                            <p>{{ $order->food->name }}</p>
                        </div>
                        <div class="col-md-1">
                            <p>{{ $order->total_order}}</p>
                        </div>
                        <div class="col-md-1">
                            <p>{{ $order->total_delivered }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="text-end">@money($order->price_qty)</p>
                        </div>
                    </div>
                    @empty
                    <div class="row">
                        <h1 class="text-muted text-center"><i>Belum ada pesanan</i></h1>
                    </div>
                    @endforelse
                </div>

            </div>

            <div class="row right-order-content-price">
                <div class="col">
                    <p><strong>Total</strong></p>
                </div>
                <div class="col">
                    <p class="text-end"><strong>Rp. @money($totalOrderPrice->total)</strong></p>
                </div>
            </div>

            <div class="row">
                <!-- <a href="" class="btn btn-success order-button mx-auto mt-2 ">Bayar</a> -->
                <button type="button" class="btn btn-success order-button mx-auto mt-2" data-bs-toggle="modal" data-bs-target="#paymentModal1">
                    Bayar
                </button>
            </div>
        </div>
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="paymentModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-payment">
            <div class="modal-header">
                <h5 class="modal-title-payment" id="exampleModalLabel">Meja No. {{ $table->table_number }}</h5>
            </div>
            <div class="modal-body">
                <div class="row text-center mb-4">
                    <h1 class="payment-check-message">Pilih metode pembayaran</h1>
                </div>
                <form action="{{ route('order.payment') }}" method="post">
                    @csrf
                    @method('patch')
                    <!-- Cash/online -->
                    <div class="d-flex justify-content-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="payment_type" id="inlineRadio1" value="cash">
                            <label class="form-check-label" for="inlineRadio1">Cash</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="payment_type" id="inlineRadio2" value="online">
                            <label class="form-check-label" for="inlineRadio2">Online</label>
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