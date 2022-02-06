@extends('layouts.master')

@section('title', 'Product List')

@section('content')
@foreach($products as $product)
    @section('product-li-content')
        <p class="h1">EUR {{ $product->price }}</p>
        <p class="small m-0" data-available="{{ $product->sizes() }}"></p>
        <p class="small m-0" data-shipping="{{ $product->shipping }}"></p>
    @endsection
    @include('product_list_card', ['product' => $product])
@endforeach
@endsection