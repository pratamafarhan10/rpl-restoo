@foreach($paymentLists as $key => $paymentlist)
<div class="row">
    <div class="card card-category card-list-pembayaran mb-2">
        <div class="row my-auto fw-bold">
            <div class="col d-flex align-items-center">
                <p>{{ $paymentlist->first()->customer_name }}</p>
            </div>
            <div class="col d-flex align-items-center">
                <p>{{ $paymentlist->first()->table_number }}</p>
            </div>
            <div class="col d-flex align-items-center">
                <p>{{ $key }}</p>
            </div>
            <div class="col d-flex justify-content-end">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#paymentModal{{$key}}">
                    Bayar
                </button>
                <!-- Modal -->
                <div class="modal fade autoModal" id="paymentModal{{$key}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog rounded ">
                        <div class="modal-content">
                            <div class="modal-body" style="color: white;">
                                <div class="row mb-3">
                                    <p class="text-center payment-detail-title"><span class="light-font">Detail</span> Pembayaran</p>
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
                                    <P class="light-font">Metode pembayaran : Cash </P>
                                    <p class="light-font">Kode pembayaran : {{ $key }}</p>
                                    <p class="light-font">Tanggal pembayaran : {{ $paymentlist->first()->updated_at->format('d-F-Y, H:i:s') }}</p>
                                    <p class="light-font">Status : <span style="color: red;">Not Paid</span></p>
                                </div>
                                <div class="row">
                                    <div class="col text-right">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                    <div class="col">
                                        <form action="{{ route('payment.cash', $key) }}" method="post">
                                            @csrf
                                            @method('patch')
                                            <button class="btn btn-success" type="submit">Bayar</button>
                                        </form>
                                    </div>
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