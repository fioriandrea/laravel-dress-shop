@extends('layouts.master')

@section('title', 'Product List')

@section('content')
<div class="d-flex justify-content-between">
@auth
@if(auth()->user()->isAdmin())
<!-- use icon-plus to add product -->
<a href="{{ route('get_add_product') }}" class="btn btn-outline-success my-2 me-2">
    <i class="bi bi-plus"></i>
    Add Product
</a> 
@endif
@endauth
@include('pagination_select')
</div>
<div id="products">
@foreach($products as $product)
    @section('product-li-content')
        <p class="h1">EUR {{ $product->price }}</p>
        <p class="small m-0" data-available="{{ $product->sizes() }}"></p>
        <p class="small m-0" data-shipping="{{ $product->shipping }}"></p>
        @auth
        @if(Auth::user()->isAdmin())
            <div class="d-flex justify-content-between my-2">
                <form method="get" action="{{ route('get_edit_product', $product->id) }}">
                    @csrf
                    <button class="me-2 btn btn-outline-success">Edit</button>
                </form>
                <form method="post" action="{{ route('post_unlist_product', $product->id) }}">
                    @csrf
                    <button data-remove-product="{{ $product->id }}" class="me-2 btn btn-outline-danger">Unlist</button>
                </form>
            </div>
        @endif
        @endauth
    @overwrite
    @include('product_list_card', ['product' => $product])
@endforeach
</div>
@endsection

@section('after')
<script>
    createAjaxDelete("remove-product", "card-product")();
    const sizeSelect = document.querySelector("#pagination-select");
    const paginator = paginate(document.getElementById("products"), +sizeSelect.value);
    sizeSelect.addEventListener("change", (event) => {
        paginator.itemsPerPage = +event.target.value;
    });
</script>
@endsection