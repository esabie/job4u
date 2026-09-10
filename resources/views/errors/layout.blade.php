<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ config('app.name', 'Job4U') }}</title>
    @include('layouts.partials.favicon')
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased text-slate-900" style="font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;">
    <div class="min-h-screen bg-[#eef7f2] flex items-center justify-center px-5 py-12">
        <div class="w-full max-w-md rounded-2xl border border-slate-200 bg-white p-8 shadow-sm text-center">
            <a href="{{ url('/') }}" class="inline-flex justify-center">
                <img
                    src="{{ asset('images/logo.jpg') }}"
                    alt="{{ config('app.name', 'Job4U') }}"
                    class="h-14 w-auto object-contain rounded-lg bg-white"
                >
            </a>

            <p class="mt-8 text-sm font-semibold uppercase tracking-wide text-[#55B84D]">@yield('eyebrow')</p>
            <h1 class="mt-2 text-2xl font-extrabold text-[#1E3A6D]">@yield('heading')</h1>
            <p class="mt-3 text-sm text-slate-600 leading-relaxed">@yield('message')</p>

            <div class="mt-6 flex flex-col gap-3">
                @yield('actions')
            </div>
        </div>
    </div>
</body>
</html>
