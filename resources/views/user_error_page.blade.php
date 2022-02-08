@extends('layouts.error')

@section('buttons')
<!-- back to home button with icon -->
<a href="{{ route('index') }}" class="btn btn-outline-success">
    <i class="bi bi-arrow-left"></i>
    Back to home
</a>
<!-- go to profile button with icon -->
<a href="{{ route('profile') }}" class="btn btn-outline-success">
    <i class="bi bi-person"></i>
    Go to profile
</a>
<!-- go to cart button with icon -->
<a href="{{ route('cart') }}" class="btn btn-outline-success">
    <i class="bi bi-cart"></i>
    Go to cart
</a>
<!-- go to orders button with icon -->
<a href="{{ route('orders') }}" class="btn btn-outline-success">
    <i class="bi bi-person"></i>
    Go to orders
</a>
@endsection