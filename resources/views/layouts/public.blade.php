<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job4U</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-slate-900">

    {{-- Navigation --}}
    @include('layouts.navigation')

    {{-- Page Content --}}
    <main>
        @yield('content')
    </main>

    @include('layouts.footer')

    @include('layouts.partials.loading-overlay')

</body>
</html>
