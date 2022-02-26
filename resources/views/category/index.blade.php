@extends('layouts.app', ['title' => 'Category'])

@section('content')
<div class="container-md">
    <!-- Menu Editor -->
    <div class="row mt-3">
        <h1 class="text-center title-fitur">Category <strong>Editor</strong></h1>
    </div>

    <!-- Create Button -->
    <div class="row justify-content-end my-2">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createcategory">
            Create
        </button>
    </div>

    <!-- Category -->
    <div class="row">
        @forelse($categories as $category)
        <div class="card card-category mb-2">
            <div class="row my-auto">
                <div class="col d-flex align-items-center">
                    <p>{{ ucfirst($category->category_name) }}</p>
                </div>
                <div class="col d-flex justify-content-end">
                    <a href="{{ route('category.edit', $category->id) }}" class="btn btn-primary">Edit</a>
                    <button type="button" class="btn btn-danger ml-2" data-bs-toggle="modal" data-bs-target="#deletemodal{{$category->id}}">
                        Delete
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="deletemodal{{$category->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body rounded">
                                    <div class="row mb-2">
                                        <img src="{{ asset("img/icon/delete-account.svg") }}" class="delete-icon mx-auto">
                                    </div>
                                    <div class="row text-center mb-4">
                                        <h1 class="delete-message">Apakah anda yakin ingin menghapus category <span class="deleted-item">{{$category->category_name}}</span>?</h1>
                                    </div>
                                    <div class="row">
                                        <div class="col text-right">
                                            <form action="{{route('category.destroy', $category->id)}}" method="post">
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
        @empty
        <h1 class="text-muted text-center mt-2"><i>Tidak ada category</i></h1>
        @endforelse
    </div>
</div>

<!-- Modal Create -->
<div class="modal fade" id="createcategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content navres">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create <strong>New Category</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('category.store') }}" method="POST">
                    @csrf
                    <div class="input-form mx-auto">
                        <label for="category_name" class="form-label">Category Name</label>
                        <input type="text" class="form-control rounded" placeholder="Category Name" name="category_name" id="category_name">
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