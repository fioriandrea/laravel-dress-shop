@extends('layouts.master')

@section('title', $product->name)

@section('content')
<section class="product-page-main">
    <div id="productCarouselControls" class="carousel carousel-dark slide" data-bs-ride="carousel">
        <div class="carousel-inner h-100">
            @foreach($product->images()->get() as $picture)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }} product-main-carousel-image img-thumbnail" style="background-image: url({{ asset('storage/img/' . $picture->url) }});">
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#productCarouselControls"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#productCarouselControls"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div>
        <h1 class="display-4">{{ $product->name }}</h1>
        <p class="lead">
            <a class="stars">
                @for($i = 0; $i < round($rating); $i++)
                    <i class="bi bi-star checked"></i>
                @endfor
                @for($i = round($rating); $i < 5; $i++)
                    <i class="bi bi-star"></i>
                @endfor
            </a>
            <span class="text-muted">({{ $rating }}/5)</span>
        </p>
        <p class="h1">EUR {{ $product->price }}</p>
        <p class="lead" data-shipping="{{ $product->shipping }}"></p>
        <p class="lead" id="available"></p>
        <p class="lead text-muted">
            Description: {{ $product->description }}
        </p>
        <p class="lead text-muted">
            Brand: {{ $product->brand }}
        </p>
        <p class="lead text-muted">
            Category: {{ $product->category }}
        </p>
        <select id="size-select" class="form-select">
            @foreach($sizes as $size)
                <option value="{{ $size }}">{{ $size }}</option>
            @endforeach
        </select>
        <form method="POST" action="{{ route('add_to_cart') }}">
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="size" id="size-form">
                @csrf
                <button id="add-to-cart" type="submit" class="disabled btn btn-outline-success w-100">Add to cart</button>
        </form>
    </div>

</section>

<section class="mt-5">
    <h1 class="mb-3">Related products that you might like</h1>
    <div class="d-flex flex-nowrap" style="overflow-y: hidden; overflow-x: scroll">
        @foreach($related as $rp)
        <!-- use product_list_card.blade.php -->
        @include('product_list_card', ['product' => $rp, 'inslider' => true])
        @endforeach
    </div>
</section>

<section class="my-5">
    <h1>Reviews Section</h1>
    <form>
        <p class="lead">
            <a class="stars review-stars" data-reviewstars="1">
                <i class="bi bi-star"></i>
                <i class="bi bi-star"></i>
                <i class="bi bi-star"></i>
                <i class="bi bi-star"></i>
                <i class="bi bi-star"></i>
            </a>
        </p>
        <div class="form-group">
            <label for="review-text-area">Write here your review of the product</label>
            <textarea class="form-control" id="review-text-area" rows="3"></textarea>
            <button type="submit" class="btn btn-outline-success my-2 w-100">Submit</button>
        </div>
    </form>

    <hr>

    <ul class="list-group">
        <li class="list-group-item">
            <h3>Username</h3>
            <p class="small">
                Reviewed on <span class="text-muted">12/12/2019</span>
            </p>
            <a class="stars mb-3">
                <i class="bi bi-star checked"></i>
                <i class="bi bi-star checked"></i>
                <i class="bi bi-star"></i>
                <i class="bi bi-star"></i>
                <i class="bi bi-star"></i>
            </a>
            <p class="lead">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec velit ipsum, egestas eget nisi
                eu, consectetur vehicula nisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec
                velit ipsum, egestas eget nisi eu, consectetur vehicula nisi. Lorem ipsum dolor sit amet,
                consectetur adipiscing elit. Donec velit ipsum, egestas eget nisi eu, consectetur vehicula nisi.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec velit ipsum, egestas eget nisi
                eu, consectetur vehicula nisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec
                velit ipsum, egestas eget nisi eu, consectetur vehicula nisi. Lorem ipsum dolor sit amet,
                consectetur adipiscing elit. Donec velit ipsum, egestas eget nisi eu, consectetur vehicula nisi.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec velit ipsum, egestas eget nisi
                eu, consectetur vehicula nisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec
                velit ipsum, egestas eget nisi eu, consectetur vehicula nisi.
            </p>
        </li>
        <li class="list-group-item">
            <h3>Username</h3>
            <p class="small">
                Reviewed on <span class="text-muted">12/12/2019</span>
            </p>
            <a class="stars mb-3">
                <i class="bi bi-star checked"></i>
                <i class="bi bi-star checked"></i>
                <i class="bi bi-star"></i>
                <i class="bi bi-star"></i>
                <i class="bi bi-star"></i>
            </a>
            <p class="lead">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec velit ipsum, egestas eget nisi
                eu, consectetur vehicula nisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec
                velit ipsum, egestas eget nisi eu, consectetur vehicula nisi. Lorem ipsum dolor sit amet,
                consectetur adipiscing elit. Donec velit ipsum, egestas eget nisi eu, consectetur vehicula nisi.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec velit ipsum, egestas eget nisi
                eu, consectetur vehicula nisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec
                velit ipsum, egestas eget nisi eu, consectetur vehicula nisi. Lorem ipsum dolor sit amet,
                consectetur adipiscing elit. Donec velit ipsum, egestas eget nisi eu, consectetur vehicula nisi.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec velit ipsum, egestas eget nisi
                eu, consectetur vehicula nisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec
                velit ipsum, egestas eget nisi eu, consectetur vehicula nisi.
            </p>
        </li>
        <li class="list-group-item">
            <h3>Username</h3>
            <p class="small">
                Reviewed on <span class="text-muted">12/12/2019</span>
            </p>
            <a class="stars mb-3">
                <i class="bi bi-star checked"></i>
                <i class="bi bi-star checked"></i>
                <i class="bi bi-star"></i>
                <i class="bi bi-star"></i>
                <i class="bi bi-star"></i>
            </a>
            <p class="lead">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec velit ipsum, egestas eget nisi
                eu, consectetur vehicula nisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec
                velit ipsum, egestas eget nisi eu, consectetur vehicula nisi. Lorem ipsum dolor sit amet,
                consectetur adipiscing elit. Donec velit ipsum, egestas eget nisi eu, consectetur vehicula nisi.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec velit ipsum, egestas eget nisi
                eu, consectetur vehicula nisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec
                velit ipsum, egestas eget nisi eu, consectetur vehicula nisi. Lorem ipsum dolor sit amet,
                consectetur adipiscing elit. Donec velit ipsum, egestas eget nisi eu, consectetur vehicula nisi.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec velit ipsum, egestas eget nisi
                eu, consectetur vehicula nisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec
                velit ipsum, egestas eget nisi eu, consectetur vehicula nisi.
            </p>
        </li>
        <li class="list-group-item">
            <h3>Username</h3>
            <p class="small">
                Reviewed on <span class="text-muted">12/12/2019</span>
            </p>
            <a class="stars mb-3">
                <i class="bi bi-star checked"></i>
                <i class="bi bi-star checked"></i>
                <i class="bi bi-star"></i>
                <i class="bi bi-star"></i>
                <i class="bi bi-star"></i>
            </a>
            <p class="lead">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec velit ipsum, egestas eget nisi
                eu, consectetur vehicula nisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec
                velit ipsum, egestas eget nisi eu, consectetur vehicula nisi. Lorem ipsum dolor sit amet,
                consectetur adipiscing elit. Donec velit ipsum, egestas eget nisi eu, consectetur vehicula nisi.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec velit ipsum, egestas eget nisi
                eu, consectetur vehicula nisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec
                velit ipsum, egestas eget nisi eu, consectetur vehicula nisi. Lorem ipsum dolor sit amet,
                consectetur adipiscing elit. Donec velit ipsum, egestas eget nisi eu, consectetur vehicula nisi.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec velit ipsum, egestas eget nisi
                eu, consectetur vehicula nisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec
                velit ipsum, egestas eget nisi eu, consectetur vehicula nisi.
            </p>
        </li>
    </ul>

    <nav class="d-flex justify-content-center align-items-center mt-5">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
    </nav>
</section>

@endsection
@section('after')
<script>
    const sizeSelectHandler = () => {
        document.querySelector("#add-to-cart").classList.remove("disabled");
        const product = @json($product);
        const size = document.querySelector("#size-select").value;
        const available = product[size]; 
        const availableElem = document.querySelector("#available");
        setAvailableParagraph(availableElem, available);
        if (available === 0) {
            document.querySelector("#add-to-cart").classList.add("disabled");
        }
        document.querySelector("#size-form").value = size;
    };
    sizeSelectHandler();
    document.querySelector("#size-select").addEventListener("change", sizeSelectHandler);
</script>
@endsection