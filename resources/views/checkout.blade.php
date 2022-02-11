@extends('layouts.master')

@section('title', 'Checkout')

@section('content')
<form method="post" action="{{ route('post_checkout') }}" class="container border my-5 py-3">
    @csrf
    <h3>@lang('labels.Select_Address')</h3>
    <!--add address button with plus icon-->
    <div class="row g-3 lead mt-3">
        @foreach($addresses as $address)
        <label class="checkout-radio border p-3 m-3 col-lg-4">
            <!-- if first, check radio button -->
            <input type="radio" name="address_id" value="{{ $address->id }}" {{ $loop->first ? 'checked' : '' }}>
            @include('address_card_content', ['address' => $address])
        </label>
        @endforeach
    </div>
    <hr>
    <h3>@lang('labels.Select_Payment_Method')</h3>
    <div class="row g-3 lead mt-3">
        @foreach($payments as $payment)
        <label class="checkout-radio border p-3 m-3 col-lg-4">
            <input type="radio" name="payment_method_id" value="{{ $payment->id }}" {{ $loop->first ? 'checked' : '' }}>
            @include('payment_card_content', ['payment' => $payment])
        </label>
        @endforeach
    </div>
    <hr>
    <button type="submit" class="btn btn-outline-success">
        @lang('labels.Checkout')
        <i class="bi bi-check"></i>
    </button>
</div>
@endsection
@section('after')
<script>
    const radios = document.querySelectorAll("input[type=radio]");
    radios.forEach((radio) => {
        const handler = () => {
            radios.forEach((radio) => {
                if (radio.checked) {
                    radio.parentElement.classList.add("checkout-radio-active");
                } else {
                    radio.parentElement.classList.remove("checkout-radio-active");
                }
            })
        };
        radio.addEventListener("change", handler);
        handler();
    });
</script>
@endsection