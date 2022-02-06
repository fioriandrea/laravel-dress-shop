@extends('layouts.master')

@section('title', 'Product List')

@section('content')
@foreach($products as $product)
    @include('product_list_card', ['product' => $product])
@endforeach
@endsection