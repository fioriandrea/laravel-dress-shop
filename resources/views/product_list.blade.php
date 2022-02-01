@extends('layouts.master')

@section('title', 'Product List')

@section('content')
@foreach($products as $product)
    @include('product_list_card', ['product' => $product])
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