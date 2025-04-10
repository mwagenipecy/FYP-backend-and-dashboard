<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Uhub</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

    @livewireStyles


    {{-- <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet" /> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    @yield('styles')
</head>


<body>
    @yield('layout')

    @livewireScripts

    <!-- Alert Scripts -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Chart Scripts -->


    <script src="{{ asset('js/apexcharts.js') }}"></script>
     <script src="{{ asset('js/flowbite.min.js') }}"></script> 
</body>
    @yield('scripts')
</html>
