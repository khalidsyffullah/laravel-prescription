<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel App')</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Assuming you have CSS --> --}}

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>


</head>

<body>

    <!-- Header Section -->
    @include('layouts.partials.header')

    <div class="container">
        <!-- Dynamic Content Section -->
        @yield('content')
    </div>

    <!-- Footer Section -->
    @include('layouts.partials.footer')

    {{-- <script src="{{ asset('js/app.js') }}"></script> <!-- Assuming you have JS --> --}}
</body>

</html>
