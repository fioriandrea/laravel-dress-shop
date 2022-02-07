@extends('layouts.master')

@section('title', $add ? 'Add Product' : 'Edit Product')

@section('content')
    <form method="post" action="{{ $add ? route('post_add_product') : route('post_edit_product', ['id' => $product->id]) }}" class="mt-3 form-horizontal user-form">
        @csrf
        <!-- checkbox list with current images. Those images will be deleted if the user unchecks the checkbox -->
        @if((!isset($add) || !$add) && $product->images->count() > 0)
        <div class="form-group">
            <label for="images">Images (uncheck those you want to delete)</label>
            @foreach ($product->images as $image)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="images[]" value="{{ $image->id }}" checked>
                    <a href="{{ asset('storage/img/' . $image->url) }}">{{ $image->url }}</a>
                </div>
            @endforeach
        </div>
        @endif
        <!-- add multiple images -->
        <div class="form-group">
            <label for="images">Images (add multiple images)</label>
            <input type="file" name="images[]" multiple>
        </div>
        <div class="form-group">
            <label for="name">Name</label>
            <input required type="text" class="form-control" id="name" name="name" maxlength="30" value="{{ $product->name }}">
        </div>
        <div class="form-group">
            <label for="short_description">Short Description</label>
            <input required type="text" class="form-control" id="short_description" name="short_description" value="{{ $product->short_description }}">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea required class="form-control" id="description" name="description" rows="3">{{ $product->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <select required class="form-select">
            @foreach($categories as $category)
                <option value="{{ $category }}">{{ $category }}</option>
            @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="brand">Brand</label>
            <input required type="text" class="form-control" id="brand" name="brand" maxlength="20" value="{{ $product->brand }}">
        </div>
        <div class="form-group">
            <label for="price">Price (EUR)</label>
            <input required type="number" class="form-control" id="price" name="price" min="1" value="{{ $product->price }}">
        </div>
        <div class="form-group">
            <label for="shipping">Shipping (EUR)</label>
            <input required type="number" class="form-control" id="shipping" name="shipping" min="0" value="{{ $product->shipping }}">
        </div>
        @foreach($sizes as $size)
            <div class="form-group">
                <label for="{{ $size }}">{{ $size }} Quantity</label>
                <input required type="number" class="form-control" id="{{ $size }}" name="{{ $size }}" min="0" value="{{ $product->$size }}">
            </div>
        @endforeach
        <button type="submit" class="w-100 btn btn-outline-primary">Submit</button>
    </form>
@endsection
