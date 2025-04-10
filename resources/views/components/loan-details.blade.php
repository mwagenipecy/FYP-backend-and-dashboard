<div>
    <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">ID: {{ $loan->id }}</h2>
            <p class="text-gray-600 dark:text-gray-400">
                {{ \Carbon\Carbon::parse($loan->disbursement_date)->toFormattedDateString() }}</p>
            {{-- <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="text-gray-500 hover:text-gray-700">
                    Action
                    <svg class="w-4 h-4 ml-1 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Delete</a>
                </div>
            </div> --}}
            @if (!$loan->is_approved && !$loan->is_paid)
                <button
                    class="text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-4 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 rounded-lg px-4 py-2"
                    data-modal-target="approveLoanModal{{ $loan->id }}"
                    data-modal-toggle="approveLoanModal{{ $loan->id }}"
                    aria-controls="approveLoanModal{{ $loan->id }}">
                    Approve Loan
                </button>
            @elseif ($loan->is_paid)
                <span class="text-green-600 font-semibold">Loan Fully Paid</span>
            @else
                <span class="text-green-600 font-semibold">Loan Approved</span>
            @endif
        </div>

        <div class="bg-gray-100 rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Details</h3>
            <div class="grid grid-cols-5 sm:grid-cols-2 md:grid-cols-5 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Member</p>
                    <p class="font-medium">{{ $loan->user->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Loan Amount</p>
                    <p class="font-medium">$   {{  number_format($loan->amount + $loan->repayments->sum("interest_paid") , 2) }}  - {{ number_format($loan->loan_amount,2) }} </p>
                    {{--  --}}
                </div>
                <div>
                    <p class="text-sm text-gray-600">Principal</p>
                    <p class="font-medium">${{ number_format($loan->amount, 2) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Duration (Months)</p>
                    <p class="font-medium">{{ $loan->tenure }} Months</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Interest Rate (%)</p>
                    <p class="font-medium">{{ $loan->interest_rate }}%</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Date Given</p>
                    <p class="font-medium">
                        {{ \Carbon\Carbon::parse($loan->disbursement_date)->toFormattedDateString() }}</p>
                </div>
                {{-- <div>
                    <p class="text-sm text-gray-600">Repaid to Date</p>
                    <p class="font-medium">Tsh {{ number_format($loan->repayments->sum('amount'), 0) }}/=</p>
                </div> --}}
                {{-- <div>
                    <p class="text-sm text-gray-600">Interest Paid</p>
                    <p class="font-medium">Tsh {{ number_format($loan->charges->sum('amount'), 0) }}/=</p>
                </div> --}}
                {{-- <div>
                    <p class="text-sm text-gray-600">Remaining Balance</p>
                    <p class="font-medium">Tsh
                        {{ number_format($loan->amount - $loan->repayments->sum('amount'), 0) }}/=</p>
                </div> --}}
                <div>
                    <p class="text-sm text-gray-600">Min Monthly Payment</p>
                    <p class="font-medium">Tsh {{ number_format($loan->loan_amount / $loan->tenure, 2) }}/=</p>
                    {{-- <p class="font-medium">${{ number_format($loan->minimum_monthly_payment, 0) }}</p> --}}
                </div>
                {{-- <div>
                    <p class="text-sm text-gray-600">Total to Return</p>
                    <p class="font-medium">Tsh
                        {{ number_format($loan->amount + ($loan->amount * $loan->interest_rate) / 100, 0) }}/=</p>
                </div> --}}
                <div>
                    <p class="text-sm text-gray-600">Flexibility</p>
                    <p class="font-medium">{{ $loan->charges->count() > 0 ? 'Yes' : 'No' }}</p>
                </div>
            </div>
        </div>

        <div>
            <h3 class="text-lg font-semibold mb-2">Payment Progress</h3>
            @php
                $total = $loan->loan_amount;
                $paid = $loan->repayments->sum('amount');
                $progress = min(100, ($paid / $total) * 100);
            @endphp
            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ $progress }}%"></div>
            </div>
        </div>
    </div>
</div>

<!-- Approve Loan Modal -->
<div id="approveLoanModal{{ $loan->id }}" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Approve Loan & Edit Details
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="approveLoanModal{{ $loan->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6">
                <p class="text-sm text-gray-600">You can update the loan details before approving the loan.</p>
                @livewire('loans.edit-loan-form', ['loan' => $loan, 'context' => 'approval'], key($loan->id))
            </div>
        </div>
    </div>
</div>
<!-- End Approve Loan Modal -->
