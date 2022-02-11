@extends('layouts.error')

@section('buttons')
<a href="{{ route('index') }}" class="btn btn-outline-success">
    <i class="bi bi-arrow-left"></i>
    @lang('labels.Back_to_home')
</a>
<a href="{{ route('product_list') }}" class="btn btn-outline-success">
    @lang('labels.Edit_Products')
</a>
<a href="{{ route('admin_orders') }}" class="btn btn-outline-success">
    @lang('labels.Manage_Orders')
</a>
@endsection