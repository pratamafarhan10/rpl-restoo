@extends('layouts.app', ['title' => 'User'])

@section('content')
<div class="container-md">
    <!-- Menu Editor -->
    <div class="row mt-3">
        <h1 class="text-center title-fitur">Daftar <strong>User</strong></h1>
    </div>

    <!-- Create Button -->
    <div class="row justify-content-end my-2">
        <a href="{{ route('user.create') }}" class="btn btn-success">Create</a>
    </div>

    <!-- Card Menu -->
    <div class="row">
        <table class="table table-dark table-hover">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $index => $user)
                <tr>
                    <th scope="row" class="text-center">{{ $index + 1 }}</th>
                    <th>{{ $user->email }}</th>
                    <th>{{ $user->category }}</th>
                    <th>
                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletemodal{{$user->id}}">
                            Delete
                        </button>
                    </th>
                </tr>
            </tbody>
            <!-- Modal -->
            <div class="modal fade" id="deletemodal{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body rounded">
                            <div class="row mb-2">
                                <img src="{{ asset("img/icon/delete-account.svg") }}" class="delete-icon mx-auto">
                            </div>
                            <div class="row text-center mb-4">
                                <h1 class="delete-message">Apakah anda yakin ingin menghapus user <span class="deleted-item">{{$user->email}}</span>?</h1>
                            </div>
                            <div class="row">
                                <div class="col text-right">
                                    <form action="{{route('user.destroy', $user->id)}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger" type="submit">Ya</button>
                                    </form>
                                </div>
                                <div class="col">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </table>
    </div>
</div>




@endsection
