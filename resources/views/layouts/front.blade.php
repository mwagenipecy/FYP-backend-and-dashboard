<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css"  rel="stylesheet" />

        <script src="https://cdn.tailwindcss.com"></script>
        <script src="http://127.0.0.1/wizara/livewire/livewire.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://unpkg.com/@tailwindcss/browser@4"></script>


  <link rel="icon" href="favicon.ico"><link href="{{ asset('assets/hub.css') }}" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    {{-- <body class="font-sans antialiased"> --}}
        <body x-data="{ page: 'home', 'darkMode': true, 'stickyMenu': false, 'navigationOpen': false, 'scrollTop': false }" x-init="  darkMode = JSON.parse(localStorage.getItem('darkMode'));   $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" :class="{'b eh': darkMode === true}" >


            {{-- include project header  --}}
            {{-- ` header start # --}}

         @include('components.front.header')


              {{-- header end  --}}


               {{-- start main  --}}
              <main>


         @yield('front-end')

        @stack('modals')

              </main>

              @include('components.front.footer')

              {{-- end main  --}}

        @livewireScripts
    </body>
</html>
