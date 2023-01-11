<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="@yield('description', 'Easily make and customize your class note according to subject and chapter wise') - {{config('app.name')}}">

        <meta property="og:title" content="@yield('title', 'Home Page') - {{config('app.name')}}" />
        <meta property="og:description" content="@yield('description', 'Easily make and customize your class note according to subject and chapter wise') - {{config('app.name')}}" />
        <meta property="og:url" content="@yield('url', config('app.url'))" />
        <meta property="og:image" content="{{ url(asset('icon.jpg')) }}" />
        <meta property="og:image:secure_url" content="{{ url(asset('icon.jpg')) }}" />
        <meta property="og:site_name" content="{{config('app.name')}}" />
        <meta property="og:image:width" content="1536" />
        <meta property="og:image:height" content="1024" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:description" content="@yield('description', 'Easily make and customize your class note according to subject and chapter wise') - {{config('app.name')}}" />
        <meta name="twitter:title" content="@yield('title', 'Home Page') - {{config('app.name')}}" />
        <meta name="twitter:image" content="{{ url(asset('icon.jpg')) }}" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        @hasSection('title')

            <title>@yield('title') - {{ config('app.name') }}</title>
        @else
            <title>{{ config('app.name') }}</title>
        @endif
        <link rel="shortcut icon" href="{{ url(asset('favicon.ico')) }}">
{{--        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">--}}
        <style>
            [x-cloak] {
                display: none;
            }

            @media print {
                #header, #footer, #url {
                    display: none;
                }
            }
        </style>
        @vite(['resources/sass/app.scss'])
        @livewireStyles
                @vite(['resources/js/app.js'])
        @stack('js')
        @laravelPWA
    </head>

    <body class="dark:bg-darkBg text-tahiti scrollbar-none" x-data="{nav: false, dark: $persist(false)}" :class="{'dark': dark}">
        @yield('body')
        @livewireScripts

        <script src="{{ asset('js/sa.js') }}"></script>
        <x-livewire-alert::scripts />
        <script src="{{ asset('js/spa.js') }}" data-turbolinks-eval="false"></script>
    </body>
</html>
