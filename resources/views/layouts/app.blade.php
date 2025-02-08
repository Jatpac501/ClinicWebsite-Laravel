<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex flex-col">
        <header>
            <h1 class="">Мед Клиника</h1>
            <div class="">
                <input type="text" name="search" id="search" placeholder="Поиск">
            </div>  
        </header>
        <main class="flex flex-col items-center justify-between"> 
            @yield('content')
        </main>
        <footer></footer>
    </body>
    @yield('scripts')
</html>
