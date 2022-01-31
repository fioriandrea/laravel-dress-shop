@extends('layouts.master')

@section('title', 'Product List')

@section('content')
@foreach($products as $product)
<a href="{{ route('product', ['id' => $product->id]) }}" class="border mb-1 product-li">
    <div class="product-li-image" style="background-image: url({{ url('/') }}/img/{{ $product->firstImage() }});"></div>
    <div>
        <h2>{{ $product->name }}</h2>
        <h3 class="small fw-light">{{ $product->short_description }}</h3>
        <div class="d-flex justify-content-center flex-column align-items-start">
            <p class="h1">EUR {{ $product->price }}</p>
            <p class="small m-0" data-shipping="{{ $product->shipping }}"></p>
            <p class="small m-0" data-available="{{ $product->sizes() }}"></p>
        </div>
    </div>
</a>
@endforeach
<nav class="d-flex justify-content-center align-items-center mt-5">
    <ul class="pagination">
        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">Next</a></li>
    </ul>
</nav>
@endsection