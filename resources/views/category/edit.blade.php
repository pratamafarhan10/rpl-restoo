@extends('layouts.app', ['title' => 'Edit Category'])

@section('content')

<div class="container-md">
    <div class="row my-4">
        <div class="card mx-auto" style="width: 650px; height: 250px">
            <div class="card-body">
                <h4 class="title-fitur text-center">Update <strong>Category</strong></h4>
                <form action="{{ route('category.update', $category->id) }}" method="POST" class="mt-4">
                    @csrf
                    @method('patch')
                    <div class="mb-3 input-form mx-auto">
                        <label for="category_name" class="form-label">Category Name</label>
                        <input type="text" class="form-control rounded @error('category_name') is-invalid @enderror" placeholder="Category Name" name="category_name" value="{{$category->category_name}}" id="category_name">
                        @error('category_name')
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