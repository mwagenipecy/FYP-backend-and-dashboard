<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $selectedUsers;

    public function __construct($selectedUsers = [])
    {
        $this->selectedUsers = $selectedUsers;
    }

    public function query()
    {
        $query = User::query()->with(['role']);
        
        if (!empty($this->selectedUsers)) {
            $query->whereIn('id', $this->selectedUsers);
        }
        
        return $query;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Registration Number',
            'Role',
            'Account Type',
            'Status',
            'Country',
            'Created At',
        ];
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->regno ?? 'N/A',
            $user->role->name ?? 'User',
            $user->current_team_id ? 'PRO' : 'Basic',
            ucfirst($user->status ?? 'pending'),
            $user->profile->country ?? 'Unknown', // Adjust based on your actual implementation
            $user->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row (header)
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2F0FD'],
                ],
            ],
        ];
    }
}