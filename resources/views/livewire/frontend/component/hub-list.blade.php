<div>
    <section class="pj vp mr">
        <!-- Section Title Start -->
        <div>
            <div class="animate_top bb ze rj ki xn vq">
                <h2 class="fk vj pr kk wm on/5 gq/2 bb _b">
                    Available hubs
                </h2>
                <p class="bb on/5 wo/5 hq">
                    The college of Communication Information and technologies consist of several innovative hubs
                    which bring impact to the University community.

                </p>
            </div>
        </div>


        <!-- Section Title End -->

        <div class="bb ze ah ch pm hj xp ki xn 2xl:ud-px-49 bc">
            <div class="wc rf qn zf cp kq xf wf">

            @forelse($hubList as $hub)
    <div class="flex flex-col items-center space-y-2 rc animate_top">
        <a href="{{ route('hub_page', $hub->id) }}">
            <img class="w-24 h-24 rounded-full object-cover" src="{{ asset($hub->image) }}" alt="{{ $hub->name }}" />
        </a>
        <p class="text-sm text-gray-700 font-medium text-center">{{ $hub->name }}</p>
    </div>
@empty
    <!-- Optional: Add a fallback message -->
    <p class="text-gray-500 text-sm">No hubs found.</p>
@endforelse


            

          




            </div>
        </div>


    </section>
</div>