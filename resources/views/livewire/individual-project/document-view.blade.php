<div>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-medium text-gray-900">View Document</h2>
            <a href="{{ route('document.list') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 focus:outline-none focus:border-gray-700 focus:ring focus:ring-gray-200 active:bg-gray-600 transition">
                Back to Documents
            </a>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Document Information</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm font-medium text-gray-500">Title:</span>
                            <p class="mt-1 text-sm text-gray-900">{{ $document->title }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Description:</span>
                            <p class="mt-1 text-sm text-gray-900">{{ $document->description ?? 'No description provided' }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">File Name:</span>
                            <p class="mt-1 text-sm text-gray-900">{{ $document->file_name }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">File Type:</span>
                            <p class="mt-1 text-sm text-gray-900">{{ $document->file_type }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">File Size:</span>
                            <p class="mt-1 text-sm text-gray-900">{{ number_format($document->file_size / 1024, 2) }} KB</p>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Metadata</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm font-medium text-gray-500">Hub:</span>
                            <p class="mt-1 text-sm text-gray-900">{{ $document->hub->name }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Stage:</span>
                            <p class="mt-1 text-sm text-gray-900">{{ $document->stage->name }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Uploaded By:</span>
                            <p class="mt-1 text-sm text-gray-900">{{ $document->uploader->name }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Upload Date:</span>
                            <p class="mt-1 text-sm text-gray-900">{{ $document->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Status:</span>
                            <p class="mt-1">
                                @if($document->is_approved)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Approved by {{ $document->approver->name }} on {{ $document->approved_at->format('M d, Y H:i') }}
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending Approval
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Document Preview</h3>
            <div>
                <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 transition">
                    Download
                </a>
                
                    <button wire:click="approve" class="ml-2 inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-600 transition">
                        Approve Document
                    </button>

                </div>
        </div>

        <div class="bg-gray-50 border border-gray-200 rounded-lg p-2">
            @php
                $fileExtension = pathinfo($document->file_name, PATHINFO_EXTENSION);
                $isPdf = strtolower($fileExtension) === 'pdf';
                $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'svg']);
            @endphp

            @if($isPdf)
                <iframe src="{{ Storage::url($document->file_path) }}" width="100%" height="600" class="border-0"></iframe>
            @elseif($isImage)
                <img src="{{ Storage::url($document->file_path) }}" alt="{{ $document->title }}" class="max-w-full mx-auto">
            @else
                <div class="flex items-center justify-center h-64 bg-gray-100 rounded">
                    <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-600">Preview not available for this file type</p>
                        <p class="mt-1 text-xs text-gray-500">Please download the file to view it</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>