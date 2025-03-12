
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>uhub - Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>{{ config('app.name', 'Laravel') }}</title>

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

<!-- Scripts -->
@vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- Styles -->
@livewireStyles


</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen">
        <!-- Left side - Form -->
        <div class="w-full md:w-1/2 p-4 md:p-8 flex items-center justify-center">
            <div class="w-full max-w-md">
                <!-- Logo -->
                <div class="flex items-start mb-2">
                    <img src="{{ asset('/dashboard/mainLogo.png') }}"  class=" h-16"/>
                   
                </div>
                {{ $slot }}
            </div>
        </div>

        <!-- Right side - Image Placeholder -->
        <div class="hidden md:block md:w-1/2 bg-gray-100">
            <!-- You'll replace this div with your image -->
            <div class="h-full flex items-center justify-center">
                <img src="{{ asset('/dashboard/loginImage.svg') }}" />  
            </div>
        </div>
    </div>

    @livewireScripts

</body>
</html>

