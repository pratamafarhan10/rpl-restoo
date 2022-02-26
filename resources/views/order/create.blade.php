@extends('layouts.nonav', ['title' => 'Order Menu'])

@section('content')

<div class="container left-order-content">
    <div class="row">
        <a href="{{ route('order.index') }}">
            <img src="{{ asset("img/icon/logo waiter.png") }}" class="logo-waiter-seat">
        </a>
        <h1 class="text-center title-fitur">Menu <strong>Makanan</strong></h1>
    </div>

    <div class="row">
        <div class="d-flex justify-content-between my-2">
            <a href="{{ route('order.index') }}" class="btn btn-danger">Back</a>
            <form class="d-flex" action="{{ route('order.search') }}" method="GET">
                <input class="form-control me-2 search-menu rounded" type="search" placeholder="Search" aria-label="Search" name="query">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            <a class="nav-link dropdown-toggle filter-menu" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Filter
            </a>
            <ul class="dropdown-menu filter-menu" aria-labelledby="navbarDropdown">
                @forelse($categories as $category)
                <li><a class="dropdown-item" href="{{ route('order.filter', ['category' => $category->id ]) }}">{{ ucfirst($category->category_name) }}</a></li>
                @empty
                <li>Category is empty</li>
                @endforelse
                <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="{{ route('order.create') }}">Reset All Filter</a></li>
            </ul>
            <form action="{{ route('order.store') }}" method="POST">
                @csrf
                <button class="btn btn-success" type="submit">Pesan</button>
        </div>
    </div>

    <div class="row">
        @forelse($categories as $category)
        <h1 class="my-2 menu-category">{{ ucfirst($category->category_name) }}</h1>
        @foreach($foods as $food)
        @if($food->category_id == $category->id)
        <div class="card mb-3 w-100 h-100">
            <div class="row g-0">
                <div class="col-md-1 d-flex align-self-center">
                    <div class="form-check">
                        <input class="form-check-input mx-auto" type="checkbox" value="{{ $food->id }}" id="flexCheckDefault" name="food_id[]">
                    </div>
                </div>
                <div class="col-md-3 d-flex align-items-center">
                    <img src="{{ asset($food->takeImage()) }}" class="img-menu">
                </div>
                <div class="col-md-7">
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
                <div class="col-md-1 d-flex">
                    <div class="align-self-center mx-auto">
                        <div class="container">
                            <div class="input-group d-grid gap-2">
                                <span class="input-group-btn mx-auto text-center">
                                    <button type="button" class="btn btn-secondary btn-number btn-pesan-number" data-type="plus" data-field="total[{{ $food->id }}]">+</button>
                                </span>
                                <input type="text" name="total[{{ $food->id }}]" class="form-control input-number my-2 text-center pesan-number" value="0" min="0" max="100">
                                <span class="input-group-btn mx-auto text-center">
                                    <button type="button" class="btn btn-secondary btn-number btn-pesan-number" disabled="disabled" data-type="minus" data-field="total[{{ $food->id }}]">-</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @endforeach

        @if(in_array($category->id, array_column($foods->toArray(), 'category_id'), true) == false)
        <h1 class="text-muted text-center mt-2"><i>Tidak ada menu yang tersedia</i></h1>
        @endif

        @empty
        <h1 class="text-muted text-center mt-2"><i>Tidak ada category yang tersedia</i></h1>
        @endforelse
        </form>

    </div>
</div>

@endsection