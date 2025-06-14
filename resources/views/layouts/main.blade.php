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


    <script src="https://cdn.tiny.cloud/1/to56akp6ay2eqwul1pcclvaz04sti76oxkmrl8tllpna0k5m/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

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
