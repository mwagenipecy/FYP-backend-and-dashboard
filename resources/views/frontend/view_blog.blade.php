@extends("layouts.front")
@section("front-end")



                <main class="pt-8 pb-16 mt-12 lg:pt-16 lg:pb-24 bg-white dark:bg-gray-900 antialiased">
                    <div class="flex justify-between px-4 mx-auto max-w-screen-xl ">
                        <article class="mx-auto w-full max-w-2xl format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
                            <header class="mb-4 lg:mb-6 not-format">
                                <address class="flex items-center mb-6 not-italic">
                                    <div class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white">
                                        <img class="mr-4 w-16 h-16 rounded-full" src="{{ asset('/assets/hub/y4c-removebg-preview.png') }}" alt="Jese Leos">
                                        <div>
                                            <a href="#" rel="author" class="text-xl font-bold text-gray-900 dark:text-white"> Y4C hub </a>
                                            <p class="text-base text-gray-500 dark:text-gray-400">Graphic Designer, educator & CEO Flowbite</p>
                                            <p class="text-base text-gray-500 dark:text-gray-400"><time pubdate datetime="2022-02-08" title="February 8th, 2022">Feb. 8, 2022</time></p>
                                        </div>
                                    </div>
                                </address>
                                <h1 class="mb-4 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white">Best practices for successful prototypes</h1>
                            </header>
                            <p class="lead">Flowbite is an open-source library of UI components built with the utility-first
                                classes from Tailwind CSS. It also includes interactive elements such as dropdowns, modals,
                                datepickers.</p>
                            <p>Before going digital, you might benefit from scribbling down some ideas in a sketchbook. This way,
                                you can think things through before committing to an actual design project.</p>
                            <p>But then I found a <a href="https://flowbite.com">component library based on Tailwind CSS called
                                    Flowbite</a>. It comes with the most commonly used UI components, such as buttons, navigation
                                bars, cards, form elements, and more which are conveniently built with the utility classes from
                                Tailwind CSS.</p>
                            <figure><img src="https://flowbite.s3.amazonaws.com/typography-plugin/typography-image-1.png" alt="">
                                <figcaption>Digital art by Anonymous</figcaption>
                            </figure>
                            <h2>Getting started with Flowbite</h2>
                            <p>First of all you need to understand how Flowbite works. This library is not another framework.
                                Rather, it is a set of components based on Tailwind CSS that you can just copy-paste from the
                                documentation.</p>
                            <p>It also includes a JavaScript file that enables interactive components, such as modals, dropdowns,
                                and datepickers which you can optionally include into your project via CDN or NPM.</p>
                            <p>You can check out the <a href="https://flowbite.com/docs/getting-started/quickstart/">quickstart
                                    guide</a> to explore the elements by including the CDN files into your project. But if you want
                                to build a project with Flowbite I recommend you to follow the build tools steps so that you can
                                purge and minify the generated CSS.</p>
                            <p>You'll also receive a lot of useful application UI, marketing UI, and e-commerce pages that can help
                                you get started with your projects even faster. You can check out this <a
                                    href="https://flowbite.com/docs/components/tables/">comparison table</a> to better understand
                                the differences between the open-source and pro version of Flowbite.</p>
                            <h2>When does design come in handy?</h2>
                            <p>While it might seem like extra work at a first glance, here are some key moments in which prototyping
                                will come in handy:</p>
                            <ol>
                                <li><strong>Usability testing</strong>. Does your user know how to exit out of screens? Can they
                                    follow your intended user journey and buy something from the site you’ve designed? By running a
                                    usability test, you’ll be able to see how users will interact with your design once it’s live;
                                </li>
                                <li><strong>Involving stakeholders</strong>. Need to check if your GDPR consent boxes are displaying
                                    properly? Pass your prototype to your data protection team and they can test it for real;</li>
                                <li><strong>Impressing a client</strong>. Prototypes can help explain or even sell your idea by
                                    providing your client with a hands-on experience;</li>
                                <li><strong>Communicating your vision</strong>. By using an interactive medium to preview and test
                                    design elements, designers and developers can understand each other — and the project — better.
                                </li>
                            </ol>
                            <h3>Laying the groundwork for best design</h3>
                            <p>Before going digital, you might benefit from scribbling down some ideas in a sketchbook. This way,
                                you can think things through before committing to an actual design project.</p>
                            <p>Let's start by including the CSS file inside the <code>head</code> tag of your HTML.</p>
                            <h3>Understanding typography</h3>
                            <h4>Type properties</h4>
                            <p>A typeface is a collection of letters. While each letter is unique, certain shapes are shared across
                                letters. A typeface represents shared patterns across a collection of letters.</p>
                            <h4>Baseline</h4>
                            <p>A typeface is a collection of letters. While each letter is unique, certain shapes are shared across
                                letters. A typeface represents shared patterns across a collection of letters.</p>
                            <h4>Measurement from the baseline</h4>
                            <p>A typeface is a collection of letters. While each letter is unique, certain shapes are shared across
                                letters. A typeface represents shared patterns across a collection of letters.</p>
                            <h3>Type classification</h3>
                            <h4>Serif</h4>
                            <p>A serif is a small shape or projection that appears at the beginning or end of a stroke on a letter.
                                Typefaces with serifs are called serif typefaces. Serif fonts are classified as one of the
                                following:</p>
                            <h4>Old-Style serifs</h4>
                            <ul>
                                <li>Low contrast between thick and thin strokes</li>
                                <li>Diagonal stress in the strokes</li>
                                <li>Slanted serifs on lower-case ascenders</li>
                            </ul><img src="https://flowbite.s3.amazonaws.com/typography-plugin/typography-image-2.png" alt="">
                            <ol>
                                <li>Low contrast between thick and thin strokes</li>
                                <li>Diagonal stress in the strokes</li>
                                <li>Slanted serifs on lower-case ascenders</li>
                            </ol>
                            <h3>Laying the best for successful prototyping</h3>
                            <p>A serif is a small shape or projection that appears at the beginning:</p>
                            <blockquote>
                                <p>Flowbite is just awesome. It contains tons of predesigned components and pages starting from
                                    login screen to complex dashboard. Perfect choice for your next SaaS application.</p>
                            </blockquote>
                            <h4>Code example</h4>
                            <p>A serif is a small shape or projection that appears at the beginning or end of a stroke on a letter.
                                Typefaces with serifs are called serif typefaces. Serif fonts are classified as one of the
                                following:</p>


                            <h4>Table example</h4>
                            <p>A serif is a small shape or projection that appears at the beginning or end of a stroke on a letter.
                            </p>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Country</th>
                                        <th>Date &amp; Time</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>United States</td>
                                        <td>April 21, 2021</td>
                                        <td><strong>$2,300</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Canada</td>
                                        <td>May 31, 2021</td>
                                        <td><strong>$300</strong></td>
                                    </tr>
                                    <tr>
                                        <td>United Kingdom</td>
                                        <td>June 3, 2021</td>
                                        <td><strong>$2,500</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Australia</td>
                                        <td>June 23, 2021</td>
                                        <td><strong>$3,543</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Germany</td>
                                        <td>July 6, 2021</td>
                                        <td><strong>$99</strong></td>
                                    </tr>
                                    <tr>
                                        <td>France</td>
                                        <td>August 23, 2021</td>
                                        <td><strong>$2,540</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                            <h3>Best practices for setting up your prototype</h3>
                            <p><strong>Low fidelity or high fidelity?</strong> Fidelity refers to how close a prototype will be to
                                the real deal. If you’re simply preparing a quick visual aid for a presentation, a low-fidelity
                                prototype — like a wireframe with placeholder images and some basic text — would be more than
                                enough. But if you’re going for more intricate usability testing, a high-fidelity prototype — with
                                on-brand colors, fonts and imagery — could help get more pointed results.</p>
                            <p><strong>Consider your user</strong>. To create an intuitive user flow, try to think as your user
                                would when interacting with your product. While you can fine-tune this during beta testing,
                                considering your user’s needs and habits early on will save you time by setting you on the right
                                path.</p>
                            <p><strong>Start from the inside out</strong>. A nice way to both organize your tasks and create more
                                user-friendly prototypes is by building your prototypes ‘inside out’. Start by focusing on what will
                                be important to your user, like a Buy now button or an image gallery, and list each element by order
                                of priority. This way, you’ll be able to create a prototype that puts your users’ needs at the heart
                                of your design.</p>
                            <p>And there you have it! Everything you need to design and share prototypes — right in Flowbite Figma.
                            </p>
                            <section class="not-format">
                                <div class="flex justify-between items-center mb-6">
                                    <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white">Discussion (20)</h2>
                                </div>
                                <form class="mb-6">
                                    <div class="py-2 px-4 mb-4 bg-white rounded-lg rounded-t-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                                        <label for="comment" class="sr-only">Your comment</label>
                                        <textarea id="comment" rows="6"
                                            class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 dark:text-white dark:placeholder-gray-400 dark:bg-gray-800"
                                            placeholder="Write a comment..." required></textarea>
                                    </div>
                                    <button type="submit"
                                        class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                                        Post comment
                                    </button>
                                </form>
                                <article class="p-6 mb-6 text-base bg-white rounded-lg dark:bg-gray-900">
                                    <footer class="flex justify-between items-center mb-2">
                                        <div class="flex items-center">
                                            <p class="inline-flex items-center mr-3 font-semibold text-sm text-gray-900 dark:text-white"><img
                                                    class="mr-2 w-6 h-6 rounded-full"
                                                    src="https://flowbite.com/docs/images/people/profile-picture-2.jpg"
                                                    alt="Michael Gough">Michael Gough</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400"><time pubdate datetime="2022-02-08"
                                                    title="February 8th, 2022">Feb. 8, 2022</time></p>
                                        </div>
                                        <button id="dropdownComment1Button" data-dropdown-toggle="dropdownComment1"
                                            class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:text-gray-400 dark:bg-gray-900 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                            type="button">
                                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                                                <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                                            </svg>
                                            <span class="sr-only">Comment settings</span>
                                        </button>
                                        <!-- Dropdown menu -->
                                        <div id="dropdownComment1"
                                            class="hidden z-10 w-36 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                                aria-labelledby="dropdownMenuIconHorizontalButton">
                                                <li>
                                                    <a href="#"
                                                        class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Remove</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Report</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </footer>
                                    <p>Very straight-to-point article. Really worth time reading. Thank you! But tools are just the
                                        instruments for the UX designers. The knowledge of the design tools are as important as the
                                        creation of the design strategy.</p>
                                    <div class="flex items-center mt-4 space-x-4">
                                        <button type="button"
                                            class="flex items-center font-medium text-sm text-gray-500 hover:underline dark:text-gray-400">
                                            <svg class="mr-1.5 w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                            <path d="M18 0H2a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h2v4a1 1 0 0 0 1.707.707L10.414 13H18a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5 4h2a1 1 0 1 1 0 2h-2a1 1 0 1 1 0-2ZM5 4h5a1 1 0 1 1 0 2H5a1 1 0 0 1 0-2Zm2 5H5a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Zm9 0h-6a1 1 0 0 1 0-2h6a1 1 0 1 1 0 2Z"/>
                                            </svg>
                                            Reply
                                        </button>
                                    </div>
                                </article>
                                <article class="p-6 mb-6 ml-6 lg:ml-12 text-base bg-white rounded-lg dark:bg-gray-900">
                                    <footer class="flex justify-between items-center mb-2">
                                        <div class="flex items-center">
                                            <p class="inline-flex items-center mr-3 font-semibold text-sm text-gray-900 dark:text-white"><img
                                                    class="mr-2 w-6 h-6 rounded-full"
                                                    src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
                                                    alt="Jese Leos">Jese Leos</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400"><time pubdate datetime="2022-02-12"
                                                    title="February 12th, 2022">Feb. 12, 2022</time></p>
                                        </div>
                                        <button id="dropdownComment2Button" data-dropdown-toggle="dropdownComment2"
                                            class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:text-gray-400 dark:bg-gray-900 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                            type="button">
                                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                                                <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                                            </svg>
                                            <span class="sr-only">Comment settings</span>
                                        </button>
                                        <!-- Dropdown menu -->
                                        <div id="dropdownComment2"
                                            class="hidden z-10 w-36 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                                aria-labelledby="dropdownMenuIconHorizontalButton">
                                                <li>
                                                    <a href="#"
                                                        class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Remove</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Report</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </footer>
                                    <p>Much appreciated! Glad you liked it ☺️</p>
                                    <div class="flex items-center mt-4 space-x-4">
                                        <button type="button"
                                            class="flex items-center font-medium text-sm text-gray-500 hover:underline dark:text-gray-400">
                                            <svg class="mr-1.5 w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                                <path d="M18 0H2a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h2v4a1 1 0 0 0 1.707.707L10.414 13H18a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5 4h2a1 1 0 1 1 0 2h-2a1 1 0 1 1 0-2ZM5 4h5a1 1 0 1 1 0 2H5a1 1 0 0 1 0-2Zm2 5H5a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Zm9 0h-6a1 1 0 0 1 0-2h6a1 1 0 1 1 0 2Z"/>
                                            </svg>
                                            Reply
                                        </button>
                                    </div>
                                </article>
                                <article class="p-6 mb-6 text-base bg-white border-t border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                                    <footer class="flex justify-between items-center mb-2">
                                        <div class="flex items-center">
                                            <p class="inline-flex items-center mr-3 font-semibold text-sm text-gray-900 dark:text-white"><img
                                                    class="mr-2 w-6 h-6 rounded-full"
                                                    src="https://flowbite.com/docs/images/people/profile-picture-3.jpg"
                                                    alt="Bonnie Green">Bonnie Green</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400"><time pubdate datetime="2022-03-12"
                                                    title="March 12th, 2022">Mar. 12, 2022</time></p>
                                        </div>
                                        <button id="dropdownComment3Button" data-dropdown-toggle="dropdownComment3"
                                            class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:text-gray-400 dark:bg-gray-900 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                            type="button">
                                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                                                <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                                            </svg>
                                            <span class="sr-only">Comment settings</span>
                                        </button>
                                        <!-- Dropdown menu -->
                                        <div id="dropdownComment3"
                                            class="hidden z-10 w-36 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                                aria-labelledby="dropdownMenuIconHorizontalButton">
                                                <li>
                                                    <a href="#"
                                                        class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Remove</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Report</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </footer>
                                    <p>The article covers the essentials, challenges, myths and stages the UX designer should consider while creating the design strategy.</p>
                                    <div class="flex items-center mt-4 space-x-4">
                                        <button type="button"
                                            class="flex items-center font-medium text-sm text-gray-500 hover:underline dark:text-gray-400">
                                            <svg class="mr-1.5 w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                            <path d="M18 0H2a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h2v4a1 1 0 0 0 1.707.707L10.414 13H18a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5 4h2a1 1 0 1 1 0 2h-2a1 1 0 1 1 0-2ZM5 4h5a1 1 0 1 1 0 2H5a1 1 0 0 1 0-2Zm2 5H5a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Zm9 0h-6a1 1 0 0 1 0-2h6a1 1 0 1 1 0 2Z"/>
                                            </svg>
                                            Reply
                                        </button>
                                    </div>
                                </article>
                                <article class="p-6 text-base bg-white border-t border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                                    <footer class="flex justify-between items-center mb-2">
                                        <div class="flex items-center">
                                            <p class="inline-flex items-center mr-3 font-semibold text-sm text-gray-900 dark:text-white"><img
                                                    class="mr-2 w-6 h-6 rounded-full"
                                                    src="https://flowbite.com/docs/images/people/profile-picture-4.jpg"
                                                    alt="Helene Engels">Helene Engels</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400"><time pubdate datetime="2022-06-23"
                                                    title="June 23rd, 2022">Jun. 23, 2022</time></p>
                                        </div>
                                        <button id="dropdownComment4Button" data-dropdown-toggle="dropdownComment4"
                                            class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:text-gray-400 dark:bg-gray-900 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                            type="button">
                                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                                                <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                                            </svg>
                                        </button>
                                        <!-- Dropdown menu -->
                                        <div id="dropdownComment4"
                                            class="hidden z-10 w-36 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                                aria-labelledby="dropdownMenuIconHorizontalButton">
                                                <li>
                                                    <a href="#"
                                                        class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Remove</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Report</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </footer>
                                    <p>Thanks for sharing this. I do came from the Backend development and explored some of the tools to design my Side Projects.</p>
                                    <div class="flex items-center mt-4 space-x-4">
                                        <button type="button"
                                            class="flex items-center font-medium text-sm text-gray-500 hover:underline dark:text-gray-400">
                                            <svg class="mr-1.5 w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                            <path d="M18 0H2a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h2v4a1 1 0 0 0 1.707.707L10.414 13H18a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5 4h2a1 1 0 1 1 0 2h-2a1 1 0 1 1 0-2ZM5 4h5a1 1 0 1 1 0 2H5a1 1 0 0 1 0-2Zm2 5H5a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Zm9 0h-6a1 1 0 0 1 0-2h6a1 1 0 1 1 0 2Z"/>
                                            </svg>
                                            Reply
                                        </button>
                                    </div>
                                </article>
                            </section>
                        </article>
                    </div>
                </main>

                <aside aria-label="Related articles" class="py-8 lg:py-24 bg-gray-50 dark:bg-gray-800">
                    <div class="px-4 mx-auto max-w-screen-xl">
                        <h2 class="mb-8 text-2xl font-bold text-gray-900 dark:text-white">Related articles</h2>
                        <div class="grid gap-12 sm:grid-cols-2 lg:grid-cols-4">
                            <article class="max-w-xs">
                                <a href="#">
                                    <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/article/blog-1.png" class="mb-5 rounded-lg" alt="Image 1">
                                </a>
                                <h2 class="mb-2 text-xl font-bold leading-tight text-gray-900 dark:text-white">
                                    <a href="#">Our first office</a>
                                </h2>
                                <p class="mb-4 text-gray-500 dark:text-gray-400">Over the past year, Volosoft has undergone many changes! After months of preparation.</p>
                                <a href="#" class="inline-flex items-center font-medium underline underline-offset-4 text-primary-600 dark:text-primary-500 hover:no-underline">
                                    Read in 2 minutes
                                </a>
                            </article>
                            <article class="max-w-xs">
                                <a href="#">
                                    <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/article/blog-2.png" class="mb-5 rounded-lg" alt="Image 2">
                                </a>
                                <h2 class="mb-2 text-xl font-bold leading-tight text-gray-900 dark:text-white">
                                    <a href="#">Enterprise design tips</a>
                                </h2>
                                <p class="mb-4  text-gray-500 dark:text-gray-400">Over the past year, Volosoft has undergone many changes! After months of preparation.</p>
                                <a href="#" class="inline-flex items-center font-medium underline underline-offset-4 text-primary-600 dark:text-primary-500 hover:no-underline">
                                    Read in 12 minutes
                                </a>
                            </article>
                            <article class="max-w-xs">
                                <a href="#">
                                    <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/article/blog-3.png" class="mb-5 rounded-lg" alt="Image 3">
                                </a>
                                <h2 class="mb-2 text-xl font-bold leading-tight text-gray-900 dark:text-white">
                                    <a href="#">We partnered with Google</a>
                                </h2>
                                <p class="mb-4  text-gray-500 dark:text-gray-400">Over the past year, Volosoft has undergone many changes! After months of preparation.</p>
                                <a href="#" class="inline-flex items-center font-medium underline underline-offset-4 text-primary-600 dark:text-primary-500 hover:no-underline">
                                    Read in 8 minutes
                                </a>
                            </article>
                            <article class="max-w-xs">
                                <a href="#">
                                    <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/article/blog-4.png" class="mb-5 rounded-lg" alt="Image 4">
                                </a>
                                <h2 class="mb-2 text-xl font-bold leading-tight text-gray-900 dark:text-white">
                                    <a href="#">Our first project with React</a>
                                </h2>
                                <p class="mb-4  text-gray-500 dark:text-gray-400">Over the past year, Volosoft has undergone many changes! After months of preparation.</p>
                                <a href="#" class="inline-flex items-center font-medium underline underline-offset-4 text-primary-600 dark:text-primary-500 hover:no-underline">
                                    Read in 4 minutes
                                </a>
                            </article>
                        </div>
                    </div>
                </aside>

                <section class="bg-white dark:bg-gray-900">
                    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
                        <div class="mx-auto max-w-screen-md sm:text-center">
                            <h2 class="mb-4 text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl dark:text-white">Sign up for our newsletter</h2>
                            <p class="mx-auto mb-8 max-w-2xl  text-gray-500 md:mb-12 sm:text-xl dark:text-gray-400">Stay up to date with the roadmap progress, announcements and exclusive discounts feel free to sign up with your email.</p>
                            <form action="#">
                                <div class="items-center mx-auto mb-3 space-y-4 max-w-screen-sm sm:flex sm:space-y-0">
                                    <div class="relative w-full">
                                        <label for="email" class="hidden mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Email address</label>
                                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                            <path d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z"/>
                                            <path d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z"/>
                                        </svg>
                                        </div>
                                        <input class="block p-3 pl-9 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 sm:rounded-none sm:rounded-l-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter your email" type="email" id="email" required="">
                                    </div>
                                    <div>
                                        <button type="submit" class="py-3 px-5 w-full text-sm font-medium text-center text-white rounded-lg border cursor-pointer bg-primary-700 border-primary-600 sm:rounded-none sm:rounded-r-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Subscribe</button>
                                    </div>
                                </div>
                                <div class="mx-auto max-w-screen-sm text-sm text-left text-gray-500 newsletter-form-footer dark:text-gray-300">We care about the protection of your data. <a href="#" class="font-medium text-primary-600 dark:text-primary-500 hover:underline">Read our Privacy Policy</a>.</div>
                            </form>
                        </div>
                    </div>
                </section>

                @endsection
