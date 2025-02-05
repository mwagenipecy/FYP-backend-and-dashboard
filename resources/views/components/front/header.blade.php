        <header class="g s r vd ya cj" :class="{ 'hh sm _k dj bl ll': stickyMenu }"
            @scroll.window="stickyMenu = (window.pageYOffset > 20) ? true : false">
            <div class="bb ze ki xn 2xl:ud-px-0 oo wf yf i">

                <div class="vd to/4 tc wf yf">
                    <a href="{{ route("home_page") }}" class="flex">
                        <img class=" h-12 w-12 " src="{{ asset('/assets/img/udsmlogo.png') }}" alt="Logo Light" />
                        <div class="flex justify-between mx-4  item-center">
                            <h1 class="font-bold strong text-4xl mt-2 text-blue-700"> UHUB </h1>
                            <img class="xc nm" src="images/logo-dark.svg" alt="Logo Dark" />
                        </div>
                    </a>

                    <!-- Hamburger Toggle BTN -->
                    <button class="po rc" @click="navigationOpen = !navigationOpen">
                        <span class="rc i pf re pd">
                            <span class="du-block h q vd yc">
                                <span class="rc i r s eh um tg te rd eb ml jl dl"
                                    :class="{ 'ue el': !navigationOpen }"></span>
                                <span class="rc i r s eh um tg te rd eb ml jl fl"
                                    :class="{ 'ue qr': !navigationOpen }"></span>
                                <span class="rc i r s eh um tg te rd eb ml jl gl"
                                    :class="{ 'ue hl': !navigationOpen }"></span>
                            </span>
                            <span class="du-block h q vd yc lf">
                                <span class="rc eh um tg ml jl el h na r ve yc"
                                    :class="{ 'sd dl': !navigationOpen }"></span>
                                <span class="rc eh um tg ml jl qr h s pa vd rd"
                                    :class="{ 'sd rr': !navigationOpen }"></span>
                            </span>
                        </span>
                    </button>
                    <!-- Hamburger Toggle BTN -->
                </div>


                <div class="vd wo/4 sd qo f ho oo wf yf" :class="{ 'd hh rm sr td ud qg ug jc yh': navigationOpen }">
                    <nav>
                        <ul class="tc _o sf yo cg ep">
                            <li><a href="{{ route("home_page") }}" class="xl" :class="{ 'mk': page === 'home' }">Home</a></li>
                            <li><a href=" " class="xl">Features</a></li>
                            <li class="c i" x-data="{ dropdown: false }">

                                <a href="#" class="xl tc wf yf bg" @click.prevent="dropdown = !dropdown"
                                    :class="{ 'mk': page === 'blog-grid' || page === 'blog-single' || page === 'signin' ||
                                            page === 'signup' || page === '404' }">
                                    Pages
                                    <svg :class="{ 'wh': dropdown }" class="th mm we fd pf"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path
                                            d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z" />
                                    </svg>
                                </a>
                                <!-- Dropdown Start -->
                                <ul class="a" :class="{ 'tc': dropdown }">
                                    <li><a href="{{ route("student-profile") }}" class="xl"
                                            :class="{ 'mk': page === 'blog-grid' }">Students </a></li>

                                    <li><a href=" " class="xl"
                                            :class="{ 'mk': page === 'blog-single' }">Blogs </a></li>

                                    {{-- <li><a href="" class=" text-white font-semibold"
                                            :class="{ 'mk': page === 'signin' }">Sign In</a></li>

                                    <li><a href="signup.html" class="xl font-semibold"
                                            :class="{ 'mk': page === 'signup' }">Sign Up</a></li>

                                    <li><a href="404.html" class="xl"
                                            :class="{ 'mk': page === '404' }">404</a></li> --}}

                                </ul>
                                <!-- Dropdown End -->
                            </li>
                            <li><a href="#" class="xl">Support</a></li>
                        </ul>
                    </nav>
                    <div class="tc wf ig pb no">
                        <a href="signin.html"
                            :class="{ 'nk yl': page === 'home', 'ok': page === 'home' && stickyMenu }"
                            class="ek pk xl">Sign In</a>
                        <a href="signup.html"
                            :class="{ 'hh/[0.15]': page === 'home', 'sh': page === 'home' && stickyMenu }"
                            class="lk gh dk rg tc wf xf _l gi hi">Sign Up</a>
                    </div>
                </div>
            </div>
        </header>
