@extends('layouts.master')

@section('title', $add ? 'Add Product' : 'Edit Product')

@section('content')
    <form method="post" action="{{ $add ? route('post_add_product') : route('post_edit_product', ['id' => $product->id]) }}" class="mt-3 form-horizontal user-form" enctype="multipart/form-data">
        @csrf
        <!-- checkbox list with current images. Those images will be deleted if the user unchecks the checkbox -->
        @if((!isset($add) || !$add) && $product->images->count() > 0)
        <div class="form-group">
            <label for="images">@lang('labels.Images') (@lang('labels.check_those_you_want_to_delete'))</label>
            @foreach ($product->images as $image)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="todelete_images[]" value="{{ $image->id }}">
                    <a href="{{ asset('storage/img/' . $image->url) }}">{{ $image->url }}</a>
                </div>
            @endforeach
        </div>
        @endif
        <!-- add multiple images -->
        <div class="form-group">
            <label for="new_images">@lang('labels.Images') (@lang('labels.add_multiple_images'))</label>
            <input type="file" id="new_images" name="new_images[]" accept="image/*" multiple>
        </div>
        <div class="form-group">
            <label for="name">@lang('labels.Name')</label>
            <input required type="text" class="form-control" id="name" name="name" maxlength="30" value="{{ $product->name }}">
        </div>
        <div class="form-group">
            <label for="short_description">@lang('labels.Short_Description')</label>
            <input required type="text" class="form-control" id="short_description" name="short_description" value="{{ $product->short_description }}">
        </div>
        <div class="form-group">
            <label for="description">@lang('labels.Description')</label>
            <textarea required class="form-control" id="description" name="description" rows="3">{{ $product->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="category">@lang('labels.Category')</label>
            <select required class="form-select" name="category">
            @foreach($categories as $category)
                <option value="{{ $category }}" {{ $product->category == $category ? 'selected' : '' }}>{{ trans('labels.' . $category) }}</option>
            @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="brand">@lang('labels.Brand')</label>
            <input required type="text" class="form-control" id="brand" name="brand" maxlength="20" value="{{ $product->brand }}">
        </div>
        <div class="form-group">
            <label for="price">@lang('labels.Price') (EUR)</label>
            <input required type="number" class="form-control" id="price" name="price" min="1" value="{{ $product->price }}">
        </div>
        <div class="form-group">
            <label for="shipping">@lang('labels.Shipping') (EUR)</label>
            <input required type="number" class="form-control" id="shipping" name="shipping" min="0" value="{{ $product->shipping }}">
        </div>
        @foreach($sizes as $size)
            <div class="form-group">
                <label for="{{ $size }}">{{ $size }} @lang('labels.Quantity')</label>
                <input required type="number" class="form-control" id="{{ $size }}" name="{{ $size }}" min="0" value="{{ $product->$size }}">
            </div>
        @endforeach
        <button type="submit" class="w-100 btn btn-outline-primary">@lang('labels.Submit')</button>
    </form>
@endsection
