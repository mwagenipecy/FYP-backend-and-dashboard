<!-- Stats Card Section -->
<div class="container mx-auto py-6 px-4">
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-template-columns gap-6">

    <!-- Total Products Card -->
    @if($visible)
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 flex items-start space-x-4">
      <div class="bg-green-50 p-3 rounded-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
        </svg>
      </div>
      <div>
        <h3 class="text-gray-500 text-sm font-medium">{{ $firstCardTitle }}</h3>
        <p class="text-gray-900 text-2xl font-semibold mt-1">{{ $firstValue }}</p>
      </div>
    </div>
    @endif

    <!-- New Products Card -->
    @if($visible2)
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 flex items-start space-x-4">
      <div class="bg-purple-50 p-3 rounded-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
        </svg>
      </div>
      <div>
        <h3 class="text-gray-500 text-sm font-medium">{{ $secondCardTitle }}</h3>
        <p class="text-gray-900 text-2xl font-semibold mt-1">{{ $secondValue }}</p>
      </div>
    </div>
    @endif 
    
    <!-- Sales Card -->
    @if($visible3)
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 flex items-start space-x-4">
      <div class="bg-yellow-50 p-3 rounded-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
      </div>
      <div>
        <h3 class="text-gray-500 text-sm font-medium">{{ $thirdCardTitle }}</h3>
        <p class="text-gray-900 text-2xl font-semibold mt-1">{{ $thirdValue }}</p>
      </div>
    </div>
    @endif 
    
    <!-- Total Income Card -->
    @if($visible4)
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 flex items-start space-x-4">
      <div class="bg-blue-50 p-3 rounded-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
      <div>
        <h3 class="text-gray-500 text-sm font-medium">{{ $fourthCardTitle }}</h3>
        <p class="text-gray-900 text-2xl font-semibold mt-1">{{ $fourthValue }}</p>
      </div>
    </div>
    @endif    
  </div>
</div>

<style>
  /* Custom grid template that auto-adjusts based on visible cards */
  .lg\:grid-template-columns {
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  }
  
  /* For screens below the lg breakpoint, we maintain the regular responsive behavior */
  @media (max-width: 1023px) {
    .lg\:grid-template-columns {
      /* Uses the default sm:grid-cols-2 behavior on smaller screens */
    }
  }
</style>