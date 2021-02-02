@extends('layouts.main')

@section('content')
    <div class="container mb-5">
        <h2>EDIT: {{ $product->name }}</h2>
        {{-- Show errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.update' , $product->id) }}" method="POST" enctype="multipart/form-data"> {{-- ENCTYPE FOR UPLOAD FILES --}}
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="name">Name</label>
                <input class='form-control' type="text" name="name" id="name" value="{{ old('name' , $product->name) }}">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class='form-control' name="description" id="description">{{ old('description' , $product->description) }}</textarea>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input class='form-control' type='numeric' name="price" id="price" value="{{ old('price' , $product->price) }}">
            </div>
            <div class="form-group">
                <label for="stockpile">Stockpile</label>
                <input class='form-control' type='numeric' name="stockpile" id="stockpile" value="{{ old('stockpile' , $stockpile->stockpile) }}">
            </div>
            <div class="form-group">
                <label for="path_img">Product Image</label>
                @isset($product->path_img)
                    <div class="wrap-image">
                        <img width="200" src="{{ asset('storage/' . $product->path_img) }}" alt="{{ $product->name }}">
                    </div>
                    <h6>Change: </h6>
                @endisset
                <input class="form-control" type="file" name="path_img" id="path_img" accept="image/*"> {{-- ACCEPT FOR RESTRICT UPLOAD TO IMAGE TYPES --}}
            </div>
            {{-- PRODUCT SIZE--}}
            <div class="form-group">
                @foreach ($sizes as $size)
                    <div class="form-check">
                        <input class='form-check-input' type="checkbox" name="sizes[]" id="size-{{ $size->id }}" value="{{ $size->id }}"
                        @if ($product->sizes->contains($size->id)) checked @endif
                        >
                        <label for="size-{{ $size->id }}">
                            {{ $size->size }}
                        </label>
                    </div>
                @endforeach
            </div>
            {{-- PRODUCT AVAILABILITY--}}
            <div class="form-group">
                <label for="available">Product availability : </label>
                <select name="available" id="available">
                    <option value="not available" 
                        {{ old('available' , $stockpile->available) == 'not available' ? 'selected' : ''}}
                    >Not available</option>
                    <option value="available"
                        {{ old('available' , $stockpile->available) == 'available' ? 'selected' : ''}}
                    >Available</option>
                    <option value="in arrive"
                        {{ old('available' , $stockpile->available) == 'in arrive' ? 'selected' : ''}}
                    >In arrive</option>
                </select>
            </div>
            
            <div class="form-group">
                <input class="btn btn-secondary" type="submit" value="Edit Product">
            </div>
        </form>
    </div>
@endsection