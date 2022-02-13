@extends('layouts.error')

@section('buttons')
<!-- go to profile button with icon -->
<a href="{{ route('profile') }}" class="btn btn-outline-success">
    <i class="bi bi-person"></i>
    @lang('labels.Go_to_profile')
</a>
<!-- go to cart button with icon -->
<a href="{{ route('cart') }}" class="btn btn-outline-success">
    <i class="bi bi-cart"></i>
    @lang('labels.Go_to_cart')
</a>
<!-- go to orders button with icon -->
<a href="{{ route('orders') }}" class="btn btn-outline-success">
    <i class="bi bi-person"></i>
    @lang('labels.Go_to_orders')
</a>
<!-- back to home button with icon -->
<a href="{{ route('index') }}" class="btn btn-outline-success">
    <i class="bi bi-arrow-left"></i>
    @lang('labels.Back_to_home')
</a>
@endsection