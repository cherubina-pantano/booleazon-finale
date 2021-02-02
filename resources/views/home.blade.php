@extends('layouts.main')

@section('content')
    <div class="container container-home">
       <section class="box-info">
           
            <a href="{{ route('products.index') }}"> 
               Click here for shop!
            </a>
       </section>
    </div>
@endsection
