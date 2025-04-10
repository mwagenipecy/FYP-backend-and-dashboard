<div>
    @props(['status'])

    @php
        $colors = [
            'pending' => 'text-yellow-500 bg-yellow-100',
            'approved' => 'text-green-300 bg-green-100',
            'disbursed' => 'text-green-500 bg-green-100',
            'paid' => 'text-green-500 bg-green-100',
            'repaid' => 'text-green-600 bg-green-200',
            'overdue' => 'text-red-500 bg-red-100',
            'declined' => 'text-red-500 bg-red-100',
            'waived' => 'text-purple-500 bg-purple-100',
            'rescheduled' => 'text-blue-500 bg-blue-100',
            'written_off' => 'text-gray-500 bg-gray-100',
            'partial'=>'text-blue-500 bg-blue-100',
        ];

        $statusClass = $colors[$status] ?? 'text-gray-500 bg-gray-100'; // Default class
    @endphp

    <span class="{{ $statusClass }} px-2 py-1 rounded-full">
        {{ ucfirst(str_replace('_', ' ', $status)) }}
    </span>
</div>
