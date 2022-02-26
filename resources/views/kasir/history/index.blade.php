@extends('layouts.kasir.app', ['title' => 'History'])

@section('content')

<div class="container-md mt-3">

    <!-- History title -->
    <div class="row my-3">
        <h1 class="text-center title-fitur"><strong>History</strong></h1>
    </div>

    <div class="row mb-2">
        <form class="d-flex justify-content-end" action="{{ route('history.search') }}" method="GET">
            <input class="form-control me-2 search-menu rounded" type="search" placeholder="Search" aria-label="Search" name="query">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </div>

    <div class="row">
        <div class="card card-category mb-2">
            <div class="row my-auto fw-bold">
                <div class="col text-center">
                    <p>Nama Customer</p>
                </div>
                <div class="col text-center">
                    <p>Nomor Meja</p>
                </div>
                <div class="col text-center">
                    <p>Kode Pembayaran</p>
                </div>
                <div class="col text-center">
                    <p>Tanggal Pembayaran</p>
                </div>
                <div class="col text-center">
                    <p>Action</p>
                </div>
            </div>
        </div>
    </div>

    <!-- List Pembayaran -->
    @foreach($paymentLists as $key => $paymentlist)
    <div class="row">
        <div class="card card-category card-list-pembayaran mb-2">
            <div class="row my-auto fw-bold">
                <div class="col d-flex align-items-center justify-content-center">
                    <p>{{ $paymentlist->first()->customer_name }}</p>
                </div>
                <div class="col d-flex align-items-center justify-content-center">
                    <p>{{ $paymentlist->first()->table_number }}</p>
                </div>
                <div class="col d-flex align-items-center justify-content-center">
                    <p>{{ $key }}</p>
                </div>
                <div class="col d-flex align-items-center justify-content-center">
                    <p>{{ $paymentlist->first()->updated_at->format('d-F-Y') }}</p>
                </div>
                <div class="col d-flex justify-content-center">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal{{$key}}">
                        Detail
                    </button>
                    <!-- Modal -->
                    <div class="modal fade autoModal" id="paymentModal{{$key}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog rounded ">
                            <div class="modal-content">
                                <div class="modal-body" style="color: white;">
                                    <div class="row mb-3">
                                        <p class="text-center payment-detail-title"><span class="light-font">History</span> Pembayaran</p>
                                    </div>
                                    <div class="row mb-1">
                                        <P class="light-font">Nama : {{ $paymentlist->first()->customer_name }}</P>
                                        <p class="light-font">Nomor Meja : {{ $paymentlist->first()->table_number }}</p>
                                    </div>
                                    <div class="row mb-2">
                                        <p>Pesanan</p>
                                        <div class="container px-3">
                                            @foreach($paymentlist as $order)
                                            <div class="row light-font">
                                                <div class="col">
                                                    <p>{{ $order->total_delivered }}</p>
                                                </div>
                                                <div class="col">
                                                    <p>{{ $order->food->name }}</p>
                                                </div>
                                                <div class="col text-end">
                                                    <p>Rp. @money($order->price_qty)</p>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <p>Total</p>
                                        </div>
                                        <div class="col text-end">
                                            <p>Rp. @money(array_sum(array_column($paymentlist->toArray(), 'total_price')))</p>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <P class="light-font">Metode pembayaran : {{$paymentlist->first()->payment_type}} </P>
                                        <p class="light-font">Kode pembayaran : {{ $key }}</p>
                                        <p class="light-font">Tanggal pembayaran : {{ $paymentlist->first()->updated_at->format('d-F-Y, H:i:s') }}</p>
                                        <p class="light-font">Status : <span style="color: #0DF900;">Paid</span></p>
                                    </div>
                                    <div class="row">
                                        <button type="button" class="btn btn-secondary mx-auto" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection