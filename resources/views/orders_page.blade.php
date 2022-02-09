@extends('layouts.master')

@section('title', auth()->user()->isAdmin() ? 'Admin Order Page' : auth()->user()->name . '\'s Orders')

@section('content')
<section class="mt-3">
        <h1>{{ auth()->user()->isAdmin() ? 'Admin Order Page' : auth()->user()->name . '\'s Orders' }}</h1>

        <hr>

        @foreach($orders as $order)
        <div class="border p-3 my-3">
            <div class="pb-3">
                <h2 class="fw-bold">Order Number: {{ $order->id }}</span></h2>
                <!-- format order created_at date -->
                <p>Order Date: <span class="fw-bold">{{ date('d/m/Y', strtotime($order->created_at)) }}</span></p>
                <!-- Estimate delivery date is created_at + 2 weeks -->
                <p>Estimated Delivery Date: <span class="fw-bold">{{ date('d/m/Y', strtotime($order->created_at . ' + 2 weeks')) }}</span></p>
                <!-- status capitalized -->
                <p>Order Status: <span class="fw-bold">{{ ucfirst($order->status) }}</span></p>
                <p>Order Total: <span class="fw-bold">EUR {{ $order->total }}</span></p>
                <!-- address -->
                @include('address_card_content', ['address' => $order->address])
                @if(!auth()->user()->isAdmin())
                    <!--cancel order button-->
                    @if($order->status == 'pending')
                        <form action="{{ route('delete_order', ['id' => $order->id]) }}" method="post">
                            @csrf
                            <button class="btn btn-outline-danger" type="submit">Cancel Order</button>
                        </form>
                    @endif
                @else
                    <form action="{{ route('confirm_order', ['id' => $order->id]) }}" method="post">
                        @csrf
                        <button class="btn btn-outline-success" type="submit">Confirm Order</button>
                    </form>
                @endif
            </div>
            @foreach($order->orderProducts as $op)
                @section('product-li-content')
                    <p class="h1">EUR {{ $op->price }}</p>
                    <p class="small m-0" data-shipping="{{ $op->shipping }}"></p>
                    <p class="small m-0">Size: <span class="fw-bold">{{ $op->size }}</span></p>
                    <p class="small m-0">Quantity: <span class="fw-bold">{{ $op->quantity }}</span></p>
                @overwrite
                @include('product_list_card', ['product' => $op->product, 'inslider' => false])
            @endforeach
        @endforeach
</section>
@endsection