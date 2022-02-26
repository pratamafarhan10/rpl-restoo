@extends('layouts.app', ['title' => 'Seat'])

@section('content')
<div class="container-md">

    <!-- Title -->
    <div class="row mt-3">
        <h1 class="text-center title-fitur">Seat <strong>Editor</strong></h1>
    </div>

    <!-- Create Button -->
    <div class="row justify-content-end my-2">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createseat">
            Create
        </button>
    </div>

    @if(!$tables->isEmpty())
    <div class="row row-cols-1 row-cols-md-3 g-4 mt-3">
        @foreach($tables as $table)
        <div class="col">
            <div class="card h-100 mx-auto" style="width: 250px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            No. <span class="seat-number">{{ $table->table_number }}</span>
                        </div>
                        <div class="col text-center d-flex">
                            <div class="align-self-center d-grid gap-2">
                                <a href="{{ route('table.edit', $table->id) }}" class="btn btn-primary">Edit</a>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletemodal{{$table->id}}">
                                    Delete
                                </button>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="deletemodal{{$table->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body rounded">
                                            <div class="row mb-2">
                                                <img src="{{ asset("img/icon/delete-account.svg") }}" class="delete-icon mx-auto">
                                            </div>
                                            <div class="row text-center mb-4">
                                                <h1 class="delete-message">Apakah anda yakin ingin menghapus meja nomor <span class="deleted-item">{{$table->table_number}}</span>?</h1>
                                            </div>
                                            <div class="row">
                                                <div class="col text-right">
                                                    <form action="{{route('table.destroy', $table->id)}}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger" type="submit">Ya</button>
                                                    </form>
                                                </div>
                                                <div class="col text-left">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
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
        </div>
        @endforeach
    </div>

    @else
    <div class="row">
        <h1 class="text-muted text-center mt-2"><i>Tidak ada meja yang tersedia</i></h1>
    </div>

    @endif
</div>

<!-- Modal -->
<div class="modal fade" id="createseat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content navres">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create <strong>New Seat</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('table.store') }}" method="POST">
                    @csrf
                    <div class="input-form mx-auto">
                        <label for="table_number" class="form-label">Table Number</label>
                        <input type="number" class="form-control rounded" placeholder="Table Number" name="table_number" id="table_number" min="1">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
