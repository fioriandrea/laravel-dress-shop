<!doctype html>
<html>

<head>
    @include('header_content')
    <title>@yield('title')</title>
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
                            <option value="all" selected>All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                        </select>
                        <input class="form-control me-2" type="search" placeholder="Search" name="keyword">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                    <ul class="navbar-nav mb-2 mb-lg-0 d-flex justify-content-center align-items-center">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown">
                                Catalogue
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ action('ProductController@getProductList', ['category' => 'all']) }}">All Categories</a></li>
                                @foreach($categories as $category)
                                    <li><a class="dropdown-item" href="{{ action('ProductController@getProductList', ['category' => $category]) }}">{{ $category }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="i" role="button"
                                data-bs-toggle="dropdown">
                                <i class="bi bi-person h3"></i>
                            </a>
                            <ul class="dropdown-menu">
                                @auth
                                    <li><a class="dropdown-item" href="{{ route('orders') }}">Orders</a></li>
                                    <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li>
                                    <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                                    <li><a class="dropdown-item" href="{{ route('register') }}">Register</a></li>
                                @endif
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link h3" href="{{ route('cart') }}"><i class="bi bi-cart"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')

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
