@props(['icon', 'title', 'value', 'previousValue' => null, 'trend' => null])

<div class="flex items-center space-x-2">
    <div class="text-blue-500">
        {!! $icon !!}
    </div>
    <div>
        <h2 class="text-gray-600">{{ $title }}</h2>
        <p class="text-2xl font-bold">{{ $value }}</p>

        @if($previousValue && $trend)
        <div class="flex items-center text-gray-500 text-sm">
            <span>Previous month </span>
            {{-- <span class="mx-1">|</span> --}}
            <span class="text-gray-500">
                <svg class="mx-1 w-4 h-4 text-gray-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
            </span>
            <span class="mx-1">vs</span>
            <span class="{{ $trend > 0 ? 'text-green-500' : 'text-red-500' }}">
                {{ $trend > 0 ? '+' : '' }}{{ $trend }}%
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $trend > 0 ? 'M12 6v13m0-13 4 4m-4-4-4 4' : 'M12 19V5m0 14-4-4m4 4 4-4' }}" />
                </svg>
            </span>
        </div>
        @endif
    </div>
</div>
