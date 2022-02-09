@extends('layouts.master')

@section('title', $product->name)

@section('content')
<section class="product-page-main">
    @if($product->images->count() > 0)
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
    @endif

    <div>
        <h1 class="display-4">{{ $product->name }}</h1>
        <h3 class="small fw-light text-muted">{{ $product->short_description }}</h3>
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
        <form method="post" action="{{ route('add_to_cart') }}">
            <select name="quantity" id="size-number-select" class="form-select"></select>
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="size" id="size-form">
            @csrf
            <button {{ (auth()->user() == null || !auth()->user()->isAdmin()) ? '' : 'hidden' }} id="add-to-cart" type="submit" class="disabled btn btn-outline-success w-100">Add to cart</button>
        </form>
    </div>

</section>

<section class="mt-5">
    <h1 class="mb-3">Related products that you might like</h1>
    <div class="d-flex flex-nowrap" style="overflow-y: hidden; overflow-x: scroll">
        @foreach($related as $rp)
        <!-- use product_list_card.blade.php -->
        @section('product-li-content')
            <p class="h1">EUR {{ $rp->price }}</p>
            <p class="small m-0" data-available="{{ $rp->sizes() }}"></p>
            <p class="small m-0" data-shipping="{{ $rp->shipping }}"></p>
        @overwrite
        @include('product_list_card', ['product' => $rp, 'inslider' => true])
        @endforeach
    </div>
</section>

<section class="my-5">
    <h1>Reviews Section</h1>
    @auth
    @if(!auth()->user()->isAdmin())
    <form method="post" action="{{ auth()->user()->hasReviewed($product->id) ? route('update_review', ['id' => $product->id]) : route('add_review', ['id' => $product->id]) }}">
        @csrf
        <p class="lead">
            <a class="stars review-stars" data-reviewstars="1">
                <i class="bi bi-star"></i>
                <i class="bi bi-star"></i>
                <i class="bi bi-star"></i>
                <i class="bi bi-star"></i>
                <i class="bi bi-star"></i>
            </a>
        </p>
        <input type="hidden" name="stars" id="stars-hidden">
        <div class="form-group">
            <label for="review-text-area">{{ auth()->user()->hasReviewed($product->id) ? 'Update the review of the product' :  'Write here your review of the product' }}</label>
            <textarea class="form-control" id="review-text-area" rows="3" name="text" minlength="5" required></textarea>
            <button type="submit" class="btn btn-outline-success my-2 w-100">{{ auth()->user()->hasReviewed($product->id) ? 'Update Review' : 'Add Review' }}</button>
        </div>
    </form>
    @endif
    @endauth
    <hr>

    <ul class="list-group">
        @foreach($product->reviews as $review)
        <li class="list-group-item">
            <h3>{{ $review->user->name }}</h3>
            <p class="small">
                Reviewed on <span class="text-muted">{{ $review->review_date }}</span>
            </p>
            <a class="stars mb-3">
                @for($i = 0; $i < round($review->rating); $i++)
                    <i class="bi bi-star checked"></i>
                @endfor
                @for($i = round($review->rating); $i < 5; $i++)
                    <i class="bi bi-star"></i>
                @endfor
            </a>
            <p class="lead">
                {{ $review->text }}
            </p>
            @if(auth()->user() && (auth()->user()->isAdmin() || auth()->user()->id == $review->user_id))
                <form method="post" action="{{ route('delete_review', ['id' => $review->id]) }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-trash"></i>
                        Delete Review
                    </button>
                </form>
            @endif
        </li>
        @endforeach
    </ul>
</section>

@endsection
@section('after')
<script>
    const sizeSelectHandler = () => {
        const addToCart = document.querySelector("#add-to-cart");
        addToCart.classList.remove("disabled");
        const product = @json($product);
        const size = document.querySelector("#size-select").value;
        const available = product[size]; 
        const availableElem = document.querySelector("#available");
        setAvailableParagraph(availableElem, available);
        if (available === 0) {
            addToCart.classList.add("disabled");
        }
        document.querySelector("#size-form").value = size;
        const sizeNumberSelect = document.querySelector("#size-number-select");
        sizeNumberSelect.hidden = false;
        sizeNumberSelect.innerHTML = "";
        for (let i = 0; i <= available; i++) {
            const option = document.createElement("option");
            if (i === 0) {
                // hide option
                option.hidden = true;
            } else if (i === 1) {
                option.selected = true;
            }
            option.value = i;
            option.innerText = i;
            sizeNumberSelect.appendChild(option);
        }
        if (available <= 1) {
            // hide select
            sizeNumberSelect.hidden = true;
        }
    };
    sizeSelectHandler();
    document.querySelector("#size-select").addEventListener("change", sizeSelectHandler);

    makeReviewStars(document.querySelector("[data-reviewstars]"), document.querySelector("#stars-hidden"));
</script>
@endsection