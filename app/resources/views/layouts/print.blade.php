<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
        @vite(['resources/css/app.css'])
        <style>
            body { background-color: white !important; }
            @page { margin: 0; }
        </style>
    </head>
    <body class="font-sans antialiased">
        @yield('content')
    </body>
</html>