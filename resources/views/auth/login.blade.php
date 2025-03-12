<x-guest-layout>
    <x-authentication-card>
       

        <x-validation-errors class="mb-4" />

      


             <h1 class="text-2xl font-bold mb-2">Welcome back</h1>
                <p class="text-gray-600 mb-6">Don't have an account? <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Sign up</a></p>

               

                <!-- Form -->
                <form method="post" action="{{ route('login') }}">
                    @csrf

                @session('status')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ $value }}
                    </div>
                @endsession

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email"  name="email" id="email" placeholder="name@company.com" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password"  name="password" id="password" placeholder="••••••••" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="flex items-center mb-4">
                        <input id="remember" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                        <a href="{{ route('password.request') }}" class="ml-auto text-sm text-blue-600 hover:underline">Forgot password?</a>
                    </div>

                    <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Sign in to your account
                    </button>
                </form>

    </x-authentication-card>
</x-guest-layout>
