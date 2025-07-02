<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @include('partials.links')
    <!-- Bootstrap CDN (optional, you can use your own CSS) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-black text-white">
    <!-- Flex wrapper to hold sidebar and content -->
    <div class="d-flex" style="min-height: 100vh;">
        @include('admin.partials.sidebar')

        <div class="flex-grow-1 p-4">
            @yield('content')
        </div>
        @yield('scripts')
    </div>
</body>

</html>