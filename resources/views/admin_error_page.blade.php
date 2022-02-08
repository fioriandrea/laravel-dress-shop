@extends('layouts.error')

@section('buttons')
<a href="{{ route('index') }}" class="btn btn-outline-success">
    <i class="bi bi-arrow-left"></i>
    Back to home
</a>
<a href="{{ route('product_list') }}" class="btn btn-outline-success">
    Edit Products
</a>
<a href="{{ route('admin_orders') }}" class="btn btn-outline-success">
    Manage Orders
</a>
@endsection