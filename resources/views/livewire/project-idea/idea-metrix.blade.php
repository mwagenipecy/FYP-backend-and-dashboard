<div>
    @php
        $iconOne =
            '<svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15v4m6-6v6m6-4v4m6-6v6M3 11l6-5 6 5 5.5-5.5"/></svg>';
        $iconTwo =
            '<svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15v4m6-6v6m6-4v4m6-6v6M3 11l6-5 6 5 5.5-5.5"/></svg>';
        $iconThree =
            '<svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15v4m6-6v6m6-4v4m6-6v6M3 11l6-5 6 5 5.5-5.5"/></svg>';
        $iconFour =
            '<svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15v4m6-6v6m6-4v4m6-6v6M3 11l6-5 6 5 5.5-5.5"/></svg>';

        $titleOne = 'Total Idea Generated';
        $valueOne = $totalIdea;
        // $previousValueOne = 'Previous month';
        // $trendOne = '5';

        $titleTwo = 'Pending Idea';
        // $valueTwo = '$20,000';
        $valueTwo = $pendingIdea;
        // $previousValueTwo = 'Previous month';
        // $trendTwo = '5';

        $titleThree = 'Total Accepted';
        // $valueThree = '$5,000';
        $valueThree =  $totalIdea - $pendingIdea;
        // $previousValueThree = 'Previous month';
        // $trendThree = '5';

        $titleFour = false;
        // $valueFour = '23';
        $valueFour = '';
        // $previousValueFour = 'Previous month';
        // $trendFour = '-3';
    @endphp

    <!-- Summary Section -->
    @include(
        'sections.four_items_overview',
        compact(
            'iconOne',
            'titleOne',
            'valueOne',
            // 'previousValueOne',
            // 'trendOne',
            'iconTwo',
            'titleTwo',
            'valueTwo',
            // 'previousValueTwo',
            // 'trendTwo',
            'iconThree',
            'titleThree',
            'valueThree',
            // 'previousValueThree',
            // 'trendThree',
            'iconFour',
            'titleFour',
            'valueFour',
            // 'previousValueFour',
            // 'trendFour'
        ))
</div>