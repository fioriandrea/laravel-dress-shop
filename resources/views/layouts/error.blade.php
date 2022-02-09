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
            <h1 class="card-title">Error ({{ $status }})</h1>
            @foreach($messages as $message)
                <h2 class="card-subtitle {{ $loop->last ? 'mb-4' : '' }} m-2">{{ $message }}</h2>
            @endforeach
            <div class="buttons d-flex justify-content-center align-items-center w-100">
                @yield('buttons')
            </div>
        </div>
    </body>
</html>