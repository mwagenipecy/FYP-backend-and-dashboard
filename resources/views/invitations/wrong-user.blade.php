<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Wrong Account
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <div class="h-16 w-16 rounded-full bg-red-100 flex items-center justify-center mr-4">
                            <i class="fas fa-user-times text-red-600 text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold">Wrong Account</h3>
                            <p class="text-gray-600">
                                You are currently logged in with a different account than the one this invitation was sent to.
                            </p>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <h4 class="font-semibold text-lg mb-2">Invitation Details</h4>
                        <p class="mb-1"><span class="font-medium">Project:</span> {{ $invitation->project->title }}</p>
                        <p class="mb-1"><span class="font-medium">Role:</span> {{ ucfirst($invitation->role) }}</p>
                        <p class="mb-1"><span class="font-medium">Invitation from:</span> {{ $invitation->inviter->name }}</p>
                        <p class="mb-3"><span class="font-medium">Invitation sent to:</span> {{ $invitation->email }}</p>
                        
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        You are currently logged in as: <strong>{{ $currentEmail }}</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <p class="mb-4 text-gray-600">
                            Please log out and sign in with the account associated with <strong>{{ $invitation->email }}</strong> 
                            to accept this invitation.
                        </p>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>