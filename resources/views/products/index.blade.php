@extends('layouts.main')

@section('content')
    @if (session('product-deleted'))
        <div class="alert alert-success">
            Product '{{ session('product-deleted') }}' has been deleted successfully.
        </div>
    @endif
    <div class="container text-center mb-5">
        <h2>
            THE WARDROBE
        </h2>
    </div>
    <div class="container mb-5 d-flex flex-wrap justify-content-center">
        @forelse ($products as $product)
            <div class="mr-5 w-25">
                <a href='{{ route('products.show' , $product->slug) }}' class="text-center">
                    <h2 class="mb-2">{{ $product->name }}</h2>
                </a>   
                    @if (!empty($product->path_img))
                        <img src="{{ $product->path_img }}" alt="{{ $product->name }}">                       
                    @endif
                    <p class="mb-2">{{ $product->description }}</p>
                    <h4 class="mb-2">{{ $product->price }}</h4>
            </div>
        @empty
            <p>No products found. Go and <a href="{{ route('products.create') }}">create a new one.</a></p>
        @endforelse
    </div>
@endsection

