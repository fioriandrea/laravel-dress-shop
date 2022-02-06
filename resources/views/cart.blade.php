@extends('layouts.master')

@section('title', $user->name . '\'s Cart')

@section('content')
<div class="cart-page-main">
    <div class="m-3">
        @foreach($cartProducts as $cp)
            @section('product-li-content')
                <p class="h1">EUR {{ $cp->product->price }}</p>
                <p class="small m-0" data-shipping="{{ $cp->product->shipping }}"></p>
                <p class="small m-0">Quantity: {{ $cp->quantity }}</p>
                <p class="small m-0">Size: {{ $cp->size }}</p>
                <form class="d-flex" action="{{ route('remove_from_cart', ['id' => $cp->id]) }}" method="POST">
                    <input type="hidden" name="product_id" value="{{ $cp->product->id }}">
                    <input type="hidden" name="size" value="{{ $cp->size }}">
                    @csrf
                    <button class="btn btn-outline-danger btn-sm" type="submit">Remove</button>
                </form>
            @endsection
            @include('product_list_card', ['product' => $cp->product, 'inslider' => false])
        @endforeach
    </div>
    <div class="border m-3 p-3 h-auto">
        @if($cartCount > 0)
        <h1>Total</h1>
        <p class="lead">Total: <span class="text-muted float-end">EUR {{ $total }}</span></p>
        <p class="lead">Shipping: <span class="text-muted float-end">EUR {{ $totalShipping }}</span></p>
        <hr>
        <p class="lead">Total: <span class="text-muted float-end">EUR {{ $total + $totalShipping }}</span></p>
        <a href="{{ route('get_checkout') }}" class="btn btn-outline-success btn-lg btn-block w-100">Checkout</a>
        @else
        <h1 class="lead m-auto">Your cart is empty.</h1>
        @endif
    </div>
    @if($cartCount > 0)
    <div class="m-3 border p-3 h-auto">
        <h1>Estimated Delivery Date</h1>
        <p class="lead">
            <!-- get current date + 2 weeks -->
            <span class="text-muted">{{ date('d.m.Y', strtotime('+2 weeks')) }}</span>
        </p>
    </div>
    @endif
</div>
@endsection