@extends('layouts.app', ['title' => 'Update User'])

@section('content')
<div class="container-md">
    <div class="row my-4">
        <div class="card mx-auto dashboard-card" style="width: 650px;">
            <div class="card-body">
                <h4 class="title-fitur text-center">Update <strong>User</strong></h4>
                <form action="{{ route('user.update', $user->id) }}" method="POST" class="mt-4">
                    @csrf
                    @method('patch')
                    <div class="mb-3 input-form mx-auto">
                        <input type="text" class="form-control rounded @error('name') is-invalid @enderror" placeholder="Name" name="name" value="{{ $user->name }}">
                        @error('name')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3 input-form mx-auto">
                        <input type="text" class="form-control rounded @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ $user->email }}">
                        @error('email')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3 input-form mx-auto">
                        <select class="form-select form-control rounded @error('category') is-invalid @enderror" aria-label="Default select example" name="category">
                            <option disabled selected>Choose category</option>
                            <option value="manajer" {{$user->category == 'manajer' ? 'selected' : ''}}>Manajer</option>
                            <option value="tempat duduk" {{$user->category == 'tempat duduk' ? 'selected' : ''}}>Tempat Duduk</option>
                            <option value="kasir" {{$user->category == 'kasir' ? 'selected' : ''}}>Cashier</option>
                            <option value="dapur" {{$user->category == 'dapur' ? 'selected' : ''}}>Tim Dapur</option>
                            <option value="waiter" {{$user->category == 'waiter' ? 'selected' : ''}}>Waiter</option>

                        </select>
                        @error('category')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3 input-form mx-auto">
                        <input type="number" class="form-control rounded @error('table_number') is-invalid @enderror" placeholder="Table Number" name="table_number" value="{{ $user->table_number }}">
                        @error('table_number')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3 input-form mx-auto">
                        <input type="password" class="form-control rounded @error('password') is-invalid @enderror" placeholder="Password" name="password">
                        @error('password')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3 input-form mx-auto">
                        <input type="password" class="form-control rounded @error('password_confirmation') is-invalid @enderror" placeholder="Confirmation Password" name="password_confirmation">
                        @error('password_confirmation')
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
