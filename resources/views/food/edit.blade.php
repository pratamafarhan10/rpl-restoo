@extends('layouts.app', ['title' => 'Edit Menu'])

@section('content')

<div class="container-md">
    <div class="row my-4">
        <div class="card mx-auto dashboard-card" style="width: 650px;">
            <div class="card-body">
                <h4 class="title-fitur text-center">Update <strong>Menu</strong></h4>
                <form action="{{ route('food.update', $food->id) }}" method="POST" class="mt-4" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="mb-3 input-form mx-auto">
                        <input type="text" class="form-control rounded @error('name') is-invalid @enderror" placeholder="Menu Name" name="name" value="{{$food->name}}" id="name">
                        @error('name')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3 input-form mx-auto">
                        <textarea class="form-control rounded @error('description') is-invalid @enderror" rows="3" name="description" placeholder="Description" id="description">{{ $food->description }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3 input-form mx-auto">
                        <input type="text" class="form-control rounded @error('ingredients') is-invalid @enderror" placeholder="Ingredients" name="ingredients" value="{{$food->ingredients}}" id="ingredients">
                        @error('ingredients')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                     <div class="mb-3 input-form mx-auto">
                        <select class="form-select form-control rounded @error('category_id') is-invalid @enderror" aria-label="Default select example" name="category_id" value="{{ old('category_id') }}">
                            <option disabled selected>Choose category</option>
                            @forelse($categories as $category)
                            <option value="{{ $category->id }}" {{$food->category->category_name == $category->category_name ? 'selected' : ' '}}>{{ ucfirst($category->category_name) }}</option>
                            @empty
                            <option disabled selected>There is no categories yet</option>
                            @endforelse
                        </select>
                        @error('category_id')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3 input-form mx-auto">
                        <label for="formFile" class="form-label">Menu Image</label>
                        <input class="form-control form-file @error('image') is-invalid @enderror" type="file" id="image" name="image">
                        @error('image')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3 input-form mx-auto">
                        <input type="number" class="form-control rounded @error('price') is-invalid @enderror" placeholder="Price" name="price" value="{{$food->price}}" id="price">
                        @error('price')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="input-form mx-auto">
                        <label class="form-label">Sembunyikan menu?</label>
                    </div>
                    <div class="mb-3 input-form mx-auto">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('is_hidden') is-invalid @enderror" type="radio" name="is_hidden" id="is_hidden" value="1" {{$food->is_hidden == 1 ? 'checked' : ''}}>
                            <label class="form-check-label" for="inlineRadio1">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('is_hidden') is-invalid @enderror" type="radio" name="is_hidden" id="is_hidden" value="0" {{$food->is_hidden == 0 ? 'checked' : ''}}>
                            <label class="form-check-label" for="inlineRadio2">No</label>
                        </div>
                        @error('is_hidden')
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
