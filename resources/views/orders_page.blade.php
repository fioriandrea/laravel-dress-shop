@extends('layouts.master')

@section('title', auth()->user()->isAdmin() ? 'Admin Order Page' : auth()->user()->name . '\'s Orders')

@section('content')
<section class="mt-3">
        <h1>{{ auth()->user()->isAdmin() ? 'Admin Order Page' : auth()->user()->name . '\'s Orders' }}</h1>

        <hr>

        @foreach($orders as $order)
        <div class="border p-3 my-3 {{ $order->status == 'refused' ? 'border-danger' : '' }} {{ $order->status == 'confirmed' ? 'border-success' : '' }} {{ $order->status == 'pending' ? 'border-warning' : '' }}" data-card-order="{{ $order->id }}">
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
                    @if($order->status == 'pending' || $order->status == 'refused')
                        <form action="{{ route($order->status == 'pending' ? 'delete_order' : 'delete_refused_order', ['id' => $order->id]) }}" method="post">
                            @csrf
                            <button class="btn btn-outline-danger" type="submit" data-remove-order="{{ $order->id }}">{{ $order->status == 'pending' ? 'Cancel Order' : 'Remove From List' }}</button>
                        </form>
                    @endif
                @else
                    <div class="d-flex">
                        <form action="{{ route('confirm_order', ['id' => $order->id]) }}" method="post" class="me-2">
                            @csrf
                            <button class="btn btn-outline-success" type="submit" data-confirm-order="{{ $order->id }}">Confirm Order</button>
                        </form>
                        <form action="{{ route('refuse_order', ['id' => $order->id]) }}" method="post">
                            @csrf
                            <button class="btn btn-outline-danger" type="submit" data-refuse-order="{{ $order->id }}">Refuse Order</button>
                        </form>
                    </div>
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
        </div>
        @endforeach
</section>
@endsection

@section('after')
<script>
    createAjaxDelete("remove-order", "card-order")();
    createAjaxDelete("confirm-order", "card-order")();
    createAjaxDelete("refuse-order", "card-order")();
</script>
@endsection