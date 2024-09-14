<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 dark:bg-gray-900">
    @include('layouts.navigation')

    <main>
        <div class="max-w-7xl mx-auto sm:px-6 lg-px-8">
            @yield('content')

        </div>
    </main>
</body>

</html>