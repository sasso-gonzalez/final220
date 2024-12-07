<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Silver Cross Medical Center</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('CSS/app.css') }}">


    </head>
    <body>
        <div class="navbar">
            @if (Route::has('login'))
                <div class="navbar_items">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="word">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="word">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="word">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>

        <!-- <div class="">
            <div class="">
                <div class="mainlogo">
                    <img src="{{ asset('images/medical_logo.png') }}" alt="Medical Logo">
                </div>
            </div>
        </div> -->

    </body>
</html>