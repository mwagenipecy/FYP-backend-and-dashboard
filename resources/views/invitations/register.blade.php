<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Register to Accept Invitation
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center mr-4">
                            <i class="fas fa-user-plus text-indigo-600 text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold">Create Your Account</h3>
                            <p class="text-gray-600">
                                Create an account with {{ $invitation->email }} to join this project.
                            </p>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <h4 class="font-semibold text-lg mb-2">Project Details</h4>
                        <p class="mb-1"><span class="font-medium">Project:</span> {{ $invitation->project->title }}</p>
                        <p class="mb-1"><span class="font-medium">Role:</span> {{ ucfirst($invitation->role) }}</p>
                        <p class="mb-1"><span class="font-medium">Invitation from:</span> {{ $invitation->inviter->name }}</p>
                        <p><span class="font-medium">Email:</span> {{ $invitation->email }}</p>
                    </div>

                    <form method="POST" action="{{ route('invitations.register', $invitation->token) }}" class="mt-6">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ old('name') }}" 
                                required 
                                class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ $invitation->email }}" 
                                disabled 
                                class="block w-full border-gray-300 rounded-md shadow-sm bg-gray-100"
                            >
                            <p class="text-sm text-gray-500 mt-1">
                                Your account will be created with this email address from the invitation.
                            </p>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                required 
                                class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                        </div>

                        <div class="mb-6">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                required 
                                class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                        </div>

                        <div class="flex justify-center">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded">
                                Create Account & Accept Invitation
                            </button>
                        </div>
                    </form>

                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">
                            Already have an account? <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800">Log in instead</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>