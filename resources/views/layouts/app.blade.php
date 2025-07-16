<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>PK FUTSAL</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/custom.css', 'resources/js/app.js','resources/css/app.css'])

    @include('partials.links')
</head>

<body class="bg-light">
    @include('partials.header')

    <main>
        @yield('content')
    </main>
    @include('partials.footer', ['contact' => \App\Models\Contact::first()])

    @yield('scripts')
</body>

</html>