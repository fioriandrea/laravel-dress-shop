@extends('layouts.master')

@section('title', auth()->user()->name . '\'s Page')

@section('content')
<div class="container border my-5 py-3">
    <h3>Addresses</h3>
    <!--add address button with plus icon-->
    <a href="{{ route('get_add_address') }}" class="btn btn-outline-success">
        Add Address
        <i class="bi bi-plus"></i>
    </a>
    <div class="row g-3 lead mt-3">
        @foreach($addresses as $address)
        <div class="border p-3 col-lg-4">
            <p>{{ $address->street }}</p>
            <p>{{ $address->city }}, {{ $address->province }}</p>
            <p>ZIP {{ $address->zip }}</p>
            <p>{{ $address->country }}</p>
            <div class="d-flex">
                <!--remove address button-->
                <form method="post" action="{{ route('remove_address') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $address->id }}">
                    <button type="submit" class="btn btn-outline-danger">
                        Remove Address
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
                <!--modify address button-->
                <a href="{{ route('get_modify_address', ['id' => $address->id]) }}" class="btn btn-outline-primary">
                    Modify Address
                    <i class="bi bi-pencil"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="container border my-5 py-3">
    <h3>Payment Methods</h3>
    <!--add payment method button with plus icon-->
    <button class="btn btn-outline-success" type="button" data-bs-toggle="modal" data-bs-target="#addPayment">
        Add Payment Method
        <i class="bi bi-plus"></i>
    </button>
    <div class="row g-3 lead mt-3">
        <div class="border p-3 col-lg-4">
            <p>VISA **** **** **** 1234</p>
            <p>Expires: 12/20</p>
            <button class="btn btn-outline-danger" type="button">
                Remove Address
                <i class="bi bi-trash"></i>
            </button>
            <button class="btn btn-outline-primary" type="button" data-bs-toggle="modal"
                data-bs-target="#modifyAddress">
                Modify Address
                <i class="bi bi-pencil"></i>
            </button>
        </div>
    </div>
</div>
@endsection