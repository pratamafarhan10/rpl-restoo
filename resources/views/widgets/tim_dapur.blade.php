<div class="row">
    <table class="table">
        <thead class="table-dark">
            <tr class="text-center">
                <th scope="col">No. Meja</th>
                <th scope="col">Makanan</th>
                <th scope="col">Jumlah Pesanan</th>
                <th scope="col">Waktu Pemesanan</th>
            </tr>
        </thead>
        <tbody style="background-color: white;">
            @foreach($orders as $order)
            @if($order->total_order - $order->total_delivered !== 0)
            <tr style="color: black;" class="text-center">
                <th scope="row">{{ $order->table_number }}</th>
                <td>{{ $order->food->name}}</td>
                <td>{{ $order->total_order - $order->total_delivered}}</td>
                <td>{{ $order->created_at->diffForHumans() }}</td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>