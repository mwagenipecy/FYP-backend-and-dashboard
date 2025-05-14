<div>
<div class="relative bg-gradient-to-br from-blue-900 via-indigo-900 to-purple-900 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <svg class="absolute left-full transform -translate-x-1/2 -translate-y-1/4 lg:scale-125" width="404" height="784" fill="none" viewBox="0 0 404 784">
            <defs>
                <pattern id="hero-pattern" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                    <rect x="0" y="0" width="4" height="4" fill="currentColor"/>
                </pattern>
            </defs>
            <rect width="404" height="784" fill="url(#hero-pattern)" />
        </svg>
    </div>

    <!-- Floating Elements -->
    <div class="absolute top-10 left-10 w-20 h-20 bg-blue-400 rounded-full opacity-20 animate-pulse"></div>
    <div class="absolute top-32 right-20 w-16 h-16 bg-purple-400 rounded-full opacity-30 animate-bounce" style="animation-delay: 0.5s"></div>
    <div class="absolute bottom-20 left-1/4 w-12 h-12 bg-indigo-400 rounded-full opacity-25 animate-pulse" style="animation-delay: 1s"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
        <div class="text-center">
            <!-- Badge -->
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 mb-8">
                <svg class="w-4 h-4 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-white text-sm font-medium">Application Now Open</span>
            </div>

            <!-- Main Heading -->
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white mb-6 leading-tight">
                <span class="block">Join Our</span>
                <span class="block bg-gradient-to-r from-blue-400 via-purple-400 to-indigo-400 bg-clip-text text-transparent">
                    Excellence Program
                </span>
            </h1>

            <!-- Subtitle -->
            <p class="text-xl md:text-2xl text-blue-100 mb-8 max-w-3xl mx-auto leading-relaxed">
                Take the next step in your academic journey. Submit your application today and unlock opportunities for growth, learning, and success.
            </p>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12 max-w-4xl mx-auto">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                    <div class="text-3xl md:text-4xl font-bold text-white mb-2">{{ $totalQuestions }}</div>
                    <div class="text-blue-200 text-sm">Questions to Complete</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                    <div class="text-3xl md:text-4xl font-bold text-white mb-2">{{ $estimatedTime }}</div>
                    <div class="text-blue-200 text-sm">Estimated Time</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                    <div class="text-3xl md:text-4xl font-bold text-white mb-2">100%</div>
                    <div class="text-blue-200 text-sm">Online Application</div>
                </div>
            </div>

            <!-- Call to Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="#application" 
                   class="group inline-flex items-center px-8 py-4 bg-white text-indigo-900 font-semibold rounded-full hover:bg-blue-50 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    <span>Start Application</span>
                    <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
                
                <button 
                   onclick="document.getElementById('how-it-works').scrollIntoView({behavior: 'smooth'})"
                   class="inline-flex items-center px-8 py-4 bg-transparent text-white font-semibold rounded-full border-2 border-white/50 hover:bg-white/10 transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>How It Works</span>
                </button>
            </div>

            @if($applicationDeadline)
                <!-- Deadline Notice -->
                <div class="mt-8 inline-flex items-center px-6 py-3 bg-orange-500/20 backdrop-blur-sm rounded-full border border-orange-400/30">
                    <svg class="w-5 h-5 text-orange-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-orange-100">Application deadline: {{ $applicationDeadline->format('F j, Y') }}</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Wave Separator -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="w-full h-20 fill-white">
            <path d="M0,0V6c0,21.7,291,111,741,110C1200,116,1200,6,1200,6V0H0Z"></path>
        </svg>
    </div>
</div>

</div>
