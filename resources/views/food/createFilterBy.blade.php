@extends('layouts.app', ['title' => 'Menu'])

@section('content')

<div class="container-md mb-5">
    <!-- Menu Editor -->
    <div class="row mt-3">
        <h1 class="text-center title-fitur">Menu <strong>Editor</strong></h1>
    </div>

    <!-- Create Button -->
    <div class="row my-2">
        <div class="col d-flex justify-content-start">
            <form class="d-flex" action="{{ route('food.search') }}" method="GET">
                <input class="form-control me-2 search-menu rounded" type="search" placeholder="Search" aria-label="Search" name="query">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            <a class="nav-link dropdown-toggle filter-menu ml-2" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Filter
            </a>
            <ul class="dropdown-menu filter-menu" aria-labelledby="navbarDropdown">
                @forelse($categories as $category)
                <li><a class="dropdown-item" href="{{ route('food.filter', ['category' => $category->id ]) }}">{{ ucfirst($category->category_name) }}</a></li>
                @empty
                <li><a class="dropdown-item" href="#">Category is empty</a></li>
                @endforelse
                <li><a class="dropdown-item" href="{{ route('food.filter', ['category' => 'hidden']) }}">Hidden Menu</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="{{ route('food.index') }}">Reset All Filter</a></li>
            </ul>
        </div>
        <div class="col d-flex justify-content-end">
            <a href="{{ route('food.create') }}" class="btn btn-success">Create</a>
        </div>
    </div>

    <div class="row">
        <h1 class="my-2 menu-category">{{ucfirst($categoryTitle)}}</h1>
        @forelse($foods as $food)
        <div class="card mb-3 w-100 h-100">
            <div class="row g-0">
                <div class="col-md-3 d-flex align-self-center">
                    <img src="{{ asset($food->takeImage()) }}" class="img-menu">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h4 class="card-title">{{ $food->name }}</h4>
                        <div class="row menu-desc">
                            <div class="container">
                                <div class="row">
                                    <p class="col-sm-2 lh-sm">Description</p>
                                    <p class="col-sm-10 lh-sm">{{Str::limit($food->description, 150)}}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-2 lh-sm">Ingredients</p>
                                    <p class="col-sm-10 lh-sm">{{Str::limit($food->ingredients, 150)}}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-2 lh-lg">Category</p>
                                    <p class="col-sm-10 lh-lg">{{ $food->category->category_name }}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-2 lh-sm">Price</p>
                                    <p class="col-sm-10 lh-sm">Rp. @money($food->price)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 text-center d-flex">
                    <div class="align-self-center d-grid gap-2">
                        <a href="{{ route('food.edit', $food->id) }}" class="btn btn-primary">Edit</a>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletemodal{{$food->id}}">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="deletemodal{{$food->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body rounded">
                        <div class="row mb-2">
                            <img src="{{ asset("img/icon/delete-account.svg") }}" class="delete-icon mx-auto">
                        </div>
                        <div class="row text-center mb-4">
                            <h1 class="delete-message">Apakah anda yakin ingin menghapus menu <span class="deleted-item">{{$food->name}}</span>?</h1>
                        </div>
                        <div class="row">
                            <div class="col text-right">
                                <form action="{{route('food.destroy', $food->id)}}" method="post">
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
        @empty
        <h1 class="text-muted text-center mt-2"><i>Tidak ada menu yang tersedia</i></h1>
        @endforelse
    </div>
</div>

@endsection