@extends('layouts.master')

@section('title', 'Dress Shop')

@section('content')
<section class="product-categories text-light text-center my-5">
    @foreach($categories as $category)
        <a href="{{ action('ProductController@getProductList', ['category' => $category]) }}" class="bg-cover product-category" style="background-image: url({{ asset('storage/img/' . strtolower($category) . '_card.jpg') }});">
            <h1 style="margin: 9rem auto;">{{ trans('labels.' . $category) }}</h1>
        </a>
    @endforeach
</section>

<section class="row g-2">
    <div class="col-xl-6 text-center">
        <h3>Contact Info</h3>
        <ul class="list-group list-group-flush my-5 lead">
            <li class="list-group-item"><span class="fw-bold">@lang('labels.Main_Location'):</span> Via IV Novembre, 37/H, Castel Mella (BS)</li>
            <li class="list-group-item"><span class="fw-bold">@lang('labels.CEO_telephone_number'):</span> +39 340 456 4897</li>
            <li class="list-group-item"><span class="fw-bold">@lang('labels.CEO_email'):</span> a.fiori001@studenti.unibs.it</li>
            <li class="list-group-item"><span class="fw-bold">@lang('labels.Refound_telephone_number'):</span> +39 123 456 7890</li>
            <li class="list-group-item"><span class="fw-bold">@lang('labels.Refound_email'):</span> dress.shop.refound@shop.com</li>
        </ul>
    </div>
    <div class="col-xl-6">
        <img class="col img-fluid" src="{{ asset('storage/img/' . 'contact-us.png') }}">
    </div>
</section>
@endsection