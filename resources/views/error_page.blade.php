<html>
    <head>
        @include('header_content')
        <title>Error</title>
        <style>
            .buttons a {
                margin-right: 10px;
            }

            .buttons a:last-child {
                margin-right: 0;
            }
        </style>
    </head>
    <body>
        <div class="h-100 d-flex flex-column  justify-content-center align-items-center">
            <h1 class="card-title">Error</h1>
            @foreach($messages as $message)
                <h2 class="card-subtitle {{ $loop->last ? 'mb-4' : '' }} m-2">{{ $message }}</h2>
            @endforeach
            <div class="buttons d-flex justify-content-center align-items-center w-100">
                <!-- back to home button with icon -->
                <a href="{{ route('index') }}" class="btn btn-outline-success">
                    <i class="bi bi-arrow-left"></i>
                    Back to home
                </a>
                <!-- go to profile button with icon -->
                <a href="{{ route('profile') }}" class="btn btn-outline-success">
                    <i class="bi bi-person"></i>
                    Go to profile
                </a>
                <!-- go to cart button with icon -->
                <a href="{{ route('cart') }}" class="btn btn-outline-success">
                    <i class="bi bi-cart"></i>
                    Go to cart
                </a>
                <!-- go to orders button with icon -->
                <a href="{{ route('orders') }}" class="btn btn-outline-success">
                    <i class="bi bi-person"></i>
                    Go to orders
                </a>
            </div>
        </div>
    </body>
</html>