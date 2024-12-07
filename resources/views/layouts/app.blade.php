<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Silver Cross Medical Center</title><!-- { config('app.name', 'Laravel') } -->

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('CSS/app.css') }}">
        <!-- Scripts -->
        <!-- vite(['public/CSS/app.css', 'resources/js/app.js']) -->
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            
            <!-- include('layouts navigation ignore this i did this on purpose -serena-->

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif
            <!-- Page Content -->
            <main>
                
           <!-- 'content needs called here' -->
            <br><br><br><br>
            <div class="container">
                @yield('content')
            </div>




            </main>
        </div>
    </body>
</html>
