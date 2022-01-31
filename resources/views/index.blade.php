@extends('layouts.master')

@section('title', 'Dress Shop')

@section('content')
<section class="product-categories text-light text-center my-5">
    @foreach($categories as $cid => $cname)
        <a href="#" class="bg-cover product-category" style="background-image: url(img/{{ $cid }}_card.jpg);">
            <h1 style="margin: 9rem auto;">{{ $cname }}</h1>
        </a>
    @endforeach
</section>

<section class="row g-2">
    <div class="col-xl-6 text-center">
        <h3>Contact Info</h3>
        <ul class="list-group list-group-flush my-5 lead">
            <li class="list-group-item"><span class="fw-bold">Main Location:</span> Via IV Novembre, 37/H, Castel Mella (BS)</li>
            <li class="list-group-item"><span class="fw-bold">CEO telephone number:</span> +39 340 456 4897</li>
            <li class="list-group-item"><span class="fw-bold">CEO email:</span> a.fiori001@studenti.unibs.it</li>
            <li class="list-group-item"><span class="fw-bold">Refound telephone number:</span> +39 123 456 7890</li>
            <li class="list-group-item"><span class="fw-bold">Refound email:</span> dress.shop.refound@shop.com</li>
        </ul>
    </div>
    <div class="col-xl-6">
        <img class="col img-fluid" src="img/contact-us.png">
    </div>
</section>
@endsection