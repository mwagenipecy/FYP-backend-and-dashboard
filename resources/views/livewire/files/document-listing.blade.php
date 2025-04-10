<div>
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-3 border-b flex justify-between items-center">
            <h2 class="text-lg font-semibold">Documents</h2>
            <div class="flex space-x-2">
                <button wire:click="openCreateDocumentModal" class="bg-blue-500 text-white px-4 py-2 rounded">
                    Upload Document
                </button>
            </div>
        </div>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Size
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Date Added
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Action</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($documents as $document)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $document['name'] }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $document['size'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ date('M d, Y', $document['date']) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ $document['preview_url'] }}" target="_blank" class="text-blue-600 hover:text-blue-900 mr-2">Preview</a>
                            <button wire:click="downloadFile('{{ $document['name'] }}')" class="text-blue-600 hover:text-blue-900 mr-2">Download</button>
                            <button wire:click.prevent="deleteFile('{{ $document['name'] }}')" class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            No documents found in this folder.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <livewire:files.create-document-modal />

    @include('livewire.files.partials.delete-document-modal')

</div>
