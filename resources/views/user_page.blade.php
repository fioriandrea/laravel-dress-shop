@extends('layouts.master')

@section('title', auth()->user()->name . trans('labels.s_Page'))

@section('content')

<h1 class="mt-3">{{ auth()->user()->name }}@lang('labels.s_Page')</h1>

<hr>

<div class="container border my-5 py-3">
    <h3>@lang('labels.Addresses')</h3>
    <!--add address button with plus icon-->
    <a href="{{ route('get_add_address') }}" class="btn btn-outline-success">
        @lang('labels.Add_Address')
        <i class="bi bi-plus"></i>
    </a>
    <div class="row g-3 lead mt-3">
        @foreach($addresses as $address)
        <div class="border p-3 col-lg-4" data-card-address="{{ $address->id }}">
            @include('address_card_content', ['address' => $address])
            <div class="d-flex justify-content-between">
                <!--remove address button-->
                <form method="post" action="{{ route('remove_address', ['id' => $address->id]) }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger" data-remove-address="{{ $address->id }}">
                        @lang('labels.Remove_Address')
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
                <!--modify address button-->
                <a href="{{ route('get_modify_address', ['id' => $address->id]) }}" class="btn btn-outline-primary">
                    @lang('labels.Modify_Address')
                    <i class="bi bi-pencil"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="container border my-5 py-3">
    <h3>@lang('labels.Payment_Methods')</h3>
    <!--add payment method button with plus icon-->
    <a href="{{ route('get_add_payment_method') }}" class="btn btn-outline-success">
        @lang('labels.Add_Payment_Method')
        <i class="bi bi-plus"></i>
    </a>
    <div class="row g-3 lead mt-3">
        @foreach($payments as $payment)
        <div class="border p-3 col-lg-4" data-card-payment="{{ $payment->id }}">
            @include('payment_card_content', ['payment' => $payment])
            <div class="d-flex justify-content-between">
                <form method="post" action="{{ route('remove_payment_method', ['id' => $payment->id]) }}">
                    @csrf
                    <button data-remove-payment="{{ $payment->id }}" type="submit" class="btn btn-outline-danger">
                        @lang('labels.Remove_Payment')
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
                <a href="{{ route('get_modify_payment_method', ['id' => $payment->id]) }}" class="btn btn-outline-primary">
                    @lang('labels.Modify_Payment')
                    <i class="bi bi-pencil"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('after')
<script>
    createAjaxDelete("remove-payment", "card-payment")();
    createAjaxDelete("remove-address", "card-address")();
</script>
@endsection