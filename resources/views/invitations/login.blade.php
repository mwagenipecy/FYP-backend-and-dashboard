<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Log In to Accept Invitation
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center mr-4">
                            <i class="fas fa-user-lock text-indigo-600 text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold">Log In to Accept Your Invitation</h3>
                            <p class="text-gray-600">
                                You need to log in with your account ({{ $invitation->email }}) to accept this invitation.
                            </p>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <h4 class="font-semibold text-lg mb-2">Project Details</h4>
                        <p class="mb-1"><span class="font-medium">Project:</span> {{ $invitation->project->title }}</p>
                        <p class="mb-1"><span class="font-medium">Role:</span> {{ ucfirst($invitation->role) }}</p>
                        <p class="mb-1"><span class="font-medium">Invitation from:</span> {{ $invitation->inviter->name }}</p>
                        <p><span class="font-medium">Invitation expires:</span> {{ $invitation->expires_at->format('M d, Y') }}</p>
                    </div>

                    <div class="flex justify-center">
                        <a href="{{ route('login') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded">
                            Log In to Continue
                        </a>
                    </div>

                    <div class="mt-4 text-center text-gray-600 text-sm">
                        After you log in, you'll be able to return to this invitation to accept or decline it.
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>