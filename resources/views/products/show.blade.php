@extends('layouts/main')

@section('content')
    <div class="container mb-5">
        <h1>
            {{ $product->name }}
        </h1>
        <div>
            Last update: {{ $product->updated_at->diffForHumans() }}
        </div>
        <div>
            Product availability : {{ $stockpile->available }}
        </div>
        <div>
            Products in stock : {{ $stockpile->stockpile }}
        </div>
        <div class="actions mt-2 mb-5">
            <a class="btn btn-secondary" href="{{ route('products.edit' , $product->slug) }}">Edit</a>
            <form class='d-inline' action="{{ route('products.destroy' , $product->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <input class="btn btn-danger" type="submit" value="Delete">
            </form>
        </div>

        {{-- PRODUCT SIZE --}}
        <section class="size">
            <h4>PRODUCT SIZE</h4>
            @forelse ($product->sizes as $size)
                <span class="badge badge-secondary">{{ $size->size }}</span>
            @empty
                <p>No Size for this product.</p>
            @endforelse
        </section>

        @if (!empty($product->path_img))
            <img src="{{ asset('storage/' . $product->path_img) }}" alt="{{ $product->name }}">
        @else
            <img src="{{ asset('img/no-image.png') }}" alt="no image available">
        @endif
        <div class="text mb-5 mt-5">
            {{ $product->description }}
        </div>
        <div class="text-center">
            <h3>The price is : {{ $product->price }} €</h3>
        </div>
    </div>
@endsection