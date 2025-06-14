<div>
<section class="py-16 bg-white relative">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Title + Arrows -->
        <div class="flex justify-between items-center mb-12">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">
            <span class="text-black">What </span>
            <span class="text-blue-600"> Students</span>
            <span class="text-black"> Say</span>
        </h2>
        <p class="text-sm text-gray-600 mt-1">Real experiences from students and others we've supported.</p>
    </div>

    <!-- Arrows -->
    <div class="flex space-x-2">
        <button class="w-8 h-8 border border-red-500 text-red-500 rounded-full flex items-center justify-center hover:bg-red-500 hover:text-white transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <button class="w-8 h-8 border border-gray-700 text-gray-700 rounded-full flex items-center justify-center hover:bg-gray-700 hover:text-white transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>
</div>

        <!-- Testimonials -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ([1, 2, 3] as $i)
            <div class="group bg-gray-50 hover:bg-white transition-all duration-300 p-6 rounded-lg shadow hover:shadow-xl transform hover:-translate-y-1 cursor-pointer">
    <div class="flex items-center gap-4 mb-4">
        <img src="{{ asset('/assets/project/image (' . (10 + $i) . ').png') }}" class="h-12 w-12 rounded-full object-cover border-2 border-yellow-400">
        <div>  
            <div class="flex items-center mb-1">
                @for ($j = 0; $j < 4; $j++)
                    <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l..."/>
                    </svg>
                @endfor
                <span class="text-xs text-gray-500 ml-2">4.0 / 5.0 Reviews</span>
            </div>
            <h4 class="font-semibold text-sm">
                @if($i === 1) I Helped Build It — And Learned So Much!
                @elseif($i === 2) Real Project, Real Experience
                @else From Zero to Confident in Tech
                @endif
            </h4>
        </div>
    </div>
    <p class="text-sm text-gray-700">
        @if($i === 1)
            Being part of the project team taught me how to manage timelines, collaborate, and deliver real solutions.
        @elseif($i === 2)
            I joined as a volunteer and ended up learning frontend and backend development while supporting the project rollout.
        @else
            This platform gave me hands-on experience managing tasks and troubleshooting — things no classroom ever taught me.
        @endif
    </p>
    <p class="mt-2 text-xs text-gray-500">
        @if($i === 1) — Neema M., IT Student
        @elseif($i === 2) — Asha N., Project Support
        @else — Juma K., Tech Intern
        @endif
    </p>
</div>

            @endforeach
        </div>
    </div>
    </section>

</div>

