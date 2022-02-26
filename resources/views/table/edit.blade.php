@extends('layouts.app', ['title' => 'Edit Seat'])

@section('content')

<div class="container-md">
    <div class="row my-4">
        <div class="card mx-auto dashboard-card" style="width: 650px;">
            <div class="card-body">
                <h4 class="title-fitur text-center">Update <strong>Seat</strong></h4>
                <form action="{{ route('table.update', $table->id) }}" method="POST" class="mt-4">
                    @csrf
                    @method('patch')
                    <div class="mb-3 input-form mx-auto">
                        <label for="table_number" class="form-label">Table Number</label>
                        <input type="number" class="form-control rounded @error('table_number') is-invalid @enderror" placeholder="Table Number" name="table_number" value="{{$table->table_number}}" id="table_number" min="1">
                        @error('table_number')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success btn-create">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
