<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <x-validation-errors class="mb-4" />

      
        <h1 class="text-2xl font-bold mb-2">Reset your password</h1>
                <p class="text-gray-600 mb-6">We'll email you instructions to reset your password. If you don't have access to your email anymore, you can try <a href="#" class="text-blue-600 hover:underline">account recovery</a>.</p>

                <!-- Form -->
                <form method="POST" action="{{ route('password.update') }}">
                @csrf
                                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                        <input type="email" id="email" placeholder="john.doe@company.com" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="mb-6">
                        <div class="flex items-center">
                            <input id="agree" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                            <label for="agree" class="ml-2 block text-sm text-gray-700">
                                I'am agree to UHUB's 
                                <a href="#" class="text-blue-600 hover:underline">Terms of Use</a> and 
                                <a href="#" class="text-blue-600 hover:underline">Privacy Policy</a>.
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Reset password
                    </button>
                </form>

                <p class="text-center mt-6 text-gray-600">
                    If you still need help, contact 
                    <a href="#" class="text-blue-600 hover:underline">Uhub Support</a>.
                </p>




    </x-authentication-card>
</x-guest-layout>
