<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Expired Invitation
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <div class="h-16 w-16 rounded-full bg-red-100 flex items-center justify-center mr-4">
                            <i class="fas fa-clock text-red-600 text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold">This Invitation Has Expired</h3>
                            <p class="text-gray-600">
                                Sorry, the invitation to join this project has expired.
                            </p>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <h4 class="font-semibold text-lg mb-2">Project Details</h4>
                        <p class="mb-1"><span class="font-medium">Project:</span> {{ $invitation->project->title }}</p>
                        <p class="mb-1"><span class="font-medium">Role:</span> {{ ucfirst($invitation->role) }}</p>
                        <p class="mb-1"><span class="font-medium">Invitation from:</span> {{ $invitation->inviter->name }}</p>
                        <p><span class="font-medium">Expired on:</span> {{ $invitation->expires_at->format('M d, Y') }}</p>
                    </div>

                    <div class="text-center">
                        <p class="mb-4 text-gray-600">
                            Please contact the project supervisor or administrator to request a new invitation.
                        </p>
                        
                        <a href="{{ route('dashboard') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded">
                            Return to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>