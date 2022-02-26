<div class="row row-cols-1 row-cols-md-3 g-4 mt-2">
    @foreach($tables as $table)
    @if($table->customer_name)
    <div class="col">
        <div class="card rounded mx-auto waiter-seat-assigned" style="width: 15rem; height: 180px;">
            <div class="card-body">
                <h1 class="waiter-seat-number text-center my-auto">{{ $table->table_number}}</h1>
            </div>
        </div>
    </div>
    @else
    <div class="col">
        <div class="card rounded mx-auto waiter-seat" style="width: 15rem; height: 180px;">
            <a href="{{ route('waiter.create', $table->id) }}" class="waiter-seat">
                <div class="card-body">
                    <h1 class="waiter-seat-number text-center my-auto">{{ $table->table_number}}</h1>
                </div>
            </a>
        </div>
    </div>
    @endif
    @endforeach
</div>