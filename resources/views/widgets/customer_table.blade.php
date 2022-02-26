<div class="row mt-5">
    <h1 class="greet-order">{{ $sapa }}, <strong>{{$table->customer_name == null ? 'pelanggan' : $table->customer_name}}</strong></h1>
</div>
<div class="row mt-3">
    <h1 class="mejano text-center">Meja No.</h1>
</div>
<div class="row">
    <h1 class="text-center"><span class="waiter-seat-number">{{ $table->table_number }}</span></h1>
</div>
@if($table->customer_name !== null)
<div class="row">
    <a href="{{ route('order.create') }}" class="btn btn-success order-button mx-auto">Pesan Menu</a>
</div>
<div class="row mt-3">
    <a href="{{ route('order.edit') }}" class="btn btn-primary order-button mx-auto">Delivery Menu</a>
</div>
<div class="row">
    <p class="text-muted text-center">*hanya boleh diakses waiter</p>
</div>
@else
<div class="row">
    <p class="text-muted text-center">Anda harus didaftarkan oleh waiter terlebih dahulu sebelum memesan</p>
</div>
@endif