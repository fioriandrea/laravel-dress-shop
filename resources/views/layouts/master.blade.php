<!doctype html>
<html>

<head>
    @include('header_content')
    <title>@yield('title')</title>
    @yield('before')
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('index') }}">Dress Shop</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <form class="d-flex w-100 pe-2" method="get" action="{{ action('ProductController@getProductList') }}">
                        <select class="form-select w-auto" name="category">
                            <option value="all" selected>@lang('labels.All_Categories')</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}">{{ trans('labels.' . $category) }}</option>
                            @endforeach
                        </select>
                        <input class="form-control me-2" type="search" placeholder="{{ trans('labels.Search') }}" name="keyword">
                        <button class="btn btn-outline-success" type="submit">@lang('labels.Search')</button>
                    </form>
                    <ul class="navbar-nav mb-2 mb-lg-0 d-flex justify-content-center align-items-center">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('product_list') }}">@lang('labels.Products')</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown">
                                @lang('labels.Catalog')
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ action('ProductController@getProductList', ['category' => 'all']) }}">@lang('labels.All_Categories')</a></li>
                                @foreach($categories as $category)
                                    <li><a class="dropdown-item" href="{{ action('ProductController@getProductList', ['category' => $category]) }}">{{ trans('labels.' . $category) }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown">
                                @lang('labels.Language')
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('lang.change', ['lang' => 'en']) }}">
                                    @lang('labels.English')
                                    <i>
                                        <img src="{{ asset('storage/img/us.svg') }}" alt="American flag" width="20px" height="20px">
                                    </i>
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('lang.change', ['lang' => 'it']) }}">
                                    @lang('labels.Italian')
                                    <i>
                                        <img src="{{ asset('storage/img/it.svg') }}" alt="Italian flag" width="20px" height="20px">
                                    </i>
                                </a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="i" role="button"
                                data-bs-toggle="dropdown">
                                <i class="bi bi-person h3"></i>
                            </a>
                            <ul class="dropdown-menu">
                                @auth
                                    @if(Auth::user()->isAdmin())
                                    <li><a class="dropdown-item" href="{{ route('admin_orders') }}">@lang('labels.Manage_Orders')</a></li>
                                    <li><a class="dropdown-item" href="{{ route('product_list') }}">@lang('labels.Manage_Products')</a></li>
                                    @else
                                    <li><a class="dropdown-item" href="{{ route('orders') }}">@lang('labels.Orders')</a></li>
                                    <li><a class="dropdown-item" href="{{ route('profile') }}">@lang('labels.Profile')</a></li>
                                    @endif
                                    <li><a class="dropdown-item" href="{{ route('logout') }}">@lang('labels.Logout')</a></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('login') }}">@lang('labels.Login')</a></li>
                                    <li><a class="dropdown-item" href="{{ route('register') }}">@lang('labels.Register')</a></li>
                                @endif
                            </ul>
                        </li>
                        @auth
                        @if(!Auth::user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link h3" href="{{ route('cart') }}"><i class="bi bi-cart"></i></a>
                        </li>
                        @endif
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
        <div id="alert-ajax">
        @if(session('error'))
            <div class="alert alert-danger text-center msg">
                <strong>{{ session('error') }}</strong>
            </div>
        @elseif(session('success'))
            <div class="alert alert-success text-center msg" id="success">
                <strong>{{ session('success') }}</strong>
            </div>
        @endif
        </div>

        @yield('content')

        <nav id="pagination-nav" class="d-flex justify-content-center align-items-center mt-5"></nav>

        <footer class="bg-dark text-light text-center p-3 d-flex mt-5">
            <p class="lead m-auto">Copyright &copy; 2021 Dress Shop</p>
            <a href="#"><i class="bi bi-arrow-up-circle h1 d-block"></i></a>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
    <script src="{{ url('/') }}/js/script.js"></script>
    @yield('after')
</body>

</html>
