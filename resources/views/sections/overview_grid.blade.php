<div class="border border-gray-300 rounded-lg">
    <div class="flex">
        <div class="bg-white py-12 px-4 flex-1 border-r border-gray-300">
            <x-overview_tile
                :icon="$iconOne"
                :title="$titleOne"
                :value="$valueOne"
                :previousValue="$previousValueOne ?? null"
                :trend="$trendOne ?? null"
            />
        </div>
        <div class="bg-white py-12 px-4 flex-1 border-gray-300">
            <x-overview_tile
                :icon="$iconTwo"
                :title="$titleTwo"
                :value="$valueTwo"
                :previousValue="$previousValueTwo ?? null"
                :trend="$trendTwo ?? null"
            />
        </div>
    </div>
</div>

<div class="border border-gray-300 rounded-lg">
    <div class="flex">
        <div class="bg-white py-12 px-4 flex-1 border-r border-gray-300">
            <x-overview_tile
                :icon="$iconThree"
                :title="$titleThree"
                :value="$valueThree"
                :previousValue="$previousValueThree ?? null"
                :trend="$trendThree ?? null"
            />
        </div>
        <div class="bg-white py-12 px-4 flex-1">
            <x-overview_tile
                :icon="$iconFour"
                :title="$titleFour"
                :value="$valueFour"
                :previousValue="$previousValueFour ?? null"
                :trend="$trendFour ?? null"
            />
        </div>
    </div>
</div>
