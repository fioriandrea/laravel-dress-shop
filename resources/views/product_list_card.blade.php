<a href="{{ route('product', ['id' => $product->id]) }}" class="border mb-1 product-li {{ isset($inslider) && $inslider  ? 'product-li-in-slider' : '' }}">
    <div class="product-li-image" style="background-image: url({{ asset('storage/img/' . $product->firstImage()->url) }});"></div>
    <div>
        <h2>{{ $product->name }}</h2>
        <h3 class="small fw-light">{{ $product->short_description }}</h3>
        <div class="d-flex justify-content-center flex-column align-items-start">
            <p class="h1">EUR {{ $product->price }}</p>
            <p class="small m-0" data-available="{{ $product->sizes() }}"></p>
            <p class="small m-0" data-shipping="{{ $product->shipping }}"></p>
        </div>
    </div>
</a>