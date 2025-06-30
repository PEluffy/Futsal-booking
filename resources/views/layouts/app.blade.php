<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>PK FUTSAL</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/custom.scss', 'resources/js/app.js'])

    @include('partials.links')
</head>

<body class="bg-light">
    @include('partials.header') {{-- Your header.php --}}

    <main>
        @yield('content') <!-- Dynamic section changes page to page -->
    </main>
    @include('partials.footer') {{-- Your footer.php --}}

    @yield('scripts')
</body>

</html>