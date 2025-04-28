<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Project Invitation
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center mr-4">
                            <i class="fas fa-envelope text-indigo-600 text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold">You've been invited!</h3>
                            <p class="text-gray-600">
                                {{ $invitation->inviter->name }} has invited you to join their project
                            </p>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <h4 class="font-semibold text-lg mb-2">Project Details</h4>
                        <p class="mb-1"><span class="font-medium">Project:</span> {{ $invitation->project->title }}</p>
                        <p class="mb-1"><span class="font-medium">Role:</span> {{ ucfirst($invitation->role) }}</p>
                        <p><span class="font-medium">Invitation expires:</span> {{ $invitation->expires_at->format('M d, Y') }}</p>
                        
                        @if($invitation->message)
                            <div class="mt-4">
                                <h5 class="font-medium mb-1">Message from {{ $invitation->inviter->name }}:</h5>
                                <div class="bg-white p-3 rounded border">
                                    {{ $invitation->message }}
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="flex justify-center space-x-4">
                        <form method="POST" action="{{ route('invitations.accept', $invitation->token) }}">
                            @csrf
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white py-2 px-6 rounded">
                                Accept Invitation
                            </button>
                        </form>

                        <form method="POST" action="{{ route('invitations.decline', $invitation->token) }}">
                            @csrf
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white py-2 px-6 rounded">
                                Decline Invitation
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>