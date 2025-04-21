<div>
    <div class="bg-white flex items-center  mb-4 justify-center min-h-screen p-2">

        <div class=" w-full bg-white  rounded-lg overflow-hidden flex flex-col md:flex-row">
            <!-- Left Side - Image -->
            <div class="md:w-1/2">
                <img src="{{ asset( $this->hub->image) }}" alt="Hub Image"
                    class="w-full h-full object-cover">
            </div>

            <!-- Right Side - About Text -->
            <div class="md:w-1/2 p-8 flex flex-col justify-center">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">About us</h2>
                <p class="text-gray-700 text-lg leading-relaxed">

                </p>
                <p class="mt-4 text-gray-700 text-lg leading-relaxed">
                   {{  $this->hub->about }}
                </p>


                <p class="mt-4 text-gray-700 text-lg leading-relaxed">
                   {{  $this->hub->description }}
                </p>

            
            </div>
        </div>

    </div>
</div>