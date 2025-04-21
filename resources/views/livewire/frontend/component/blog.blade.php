<div>
    <!-- ===== Blog Start ===== -->
    <section class="py-1 bg-gray-50">
        <!-- Section Title Start -->
        <div class="text-center mb-12 animate_top">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                Latest Events & Activities
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Get the ongoing and upcoming activities and events done by the College
            </p>
        </div>
        <!-- Section Title End -->

        <!-- Blog Cards Start -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ([
                    ['title' => 'Free advertising for your online business', 'image' => '/assets/project/project-03.png', 'date' => '25 Dec, 2025'],
                    ['title' => '10 Tips to Improve Your SEO Ranking', 'image' => '/assets/project/project-03.png', 'date' => '12 Jan, 2025'],
                    ['title' => 'Why Branding Matters in 2025', 'image' => '/assets/project/project-03.png', 'date' => '5 Feb, 2025'],
                    ['title' => 'Understanding Customer Behavior Online', 'image' => '/assets/project/project-03.png', 'date' => '20 Mar, 2025'],
                ] as $blog)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden animate_top">
                        <div class="relative">
                            <img src="{{ asset($blog['image']) }}" alt="Blog"
                                 class="w-full h-48 object-cover" />
                            <div class="absolute bottom-4 right-4 z-10">
                                <a href="{{ route('view-blog') }}"
                                   class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                    Read More
                                </a>
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="flex items-center text-sm text-gray-500 mb-2 space-x-2">
                                <img src="{{ asset('/assets/icon/icon-calender.svg') }}" alt="Calendar" class="w-4 h-4" />
                                <span>{{ $blog['date'] }}</span>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 hover:text-blue-600">
                                <a href="{{ route('view-blog') }}">
                                    {{ $blog['title'] }}
                                </a>
                            </h3>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- Blog Cards End -->
    </section>
    <!-- ===== Blog End ===== -->
</div>
