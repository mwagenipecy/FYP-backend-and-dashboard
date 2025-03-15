<x-guest-layout>
    <x-authentication-card>
        <x-validation-errors class="" />

        <h1 class="text-2xl font-bold ">Welcome back</h1>
                <p class="text-gray-600 mb-6">Do you have an account? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Sign in</a></p>

                <!-- Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Your email</label>
                        <input name="email" type="email" id="email" placeholder="name@company.com" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="mb-4">
                        <label for="fullname" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input name="name" type="text" id="fullname" placeholder="e.g. Bonnie Green" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="mb-4">
                        <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Student Registration Number </label>
                        <input  name="regno" type="text" id="regno" placeholder="2021-**-*****" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">

                    </div>
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input name="password" type="password" id="password" placeholder="••••••••" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1"> Confirm Password</label>
                        <input name="password_confirmation" type="password" id="password" placeholder="••••••••" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>


                    <div class="flex items-center mb-4">
                        <input id="remember" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                        <a href="#" class="ml-auto text-sm text-blue-600 hover:underline">Forgot password?</a>
                    </div>

                    <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Sign in to your account
                    </button>
                </form>




    </x-authentication-card>
</x-guest-layout>
