<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SellersExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $sellers;
    protected $status;

    public function __construct($sellers, $status = 'all')
    {
        $this->sellers = $sellers;
        $this->status = $status;
    }

    public function collection()
    {
        return $this->sellers;
    }

    public function headings(): array
    {
        return [
            'Seller ID',
            'Name',
            'Email',
            'Registration Date',
            'Country',
            'City',
            'Status',
            'Total Gigs',
            'Total Orders',
            'Total Earnings',
            'Average Rating',
            'Total Reviews',
            'Category',
            'Service Types',
            'Phone',
            'Created At',
        ];
    }

    public function map($seller): array
    {
        $serviceTypes = $seller->teacherGigs->pluck('service_type')->unique()->implode(', ');
        $category = $seller->expertProfile ? ($seller->expertProfile->category_class ?? $seller->expertProfile->category_freelance ?? 'N/A') : 'N/A';

        $statusText = [
            0 => 'Active',
            2 => 'Hidden',
            3 => 'Paused',
            4 => 'Banned',
        ];

        return [
            str_pad($seller->id, 7, '0', STR_PAD_LEFT),
            $seller->first_name . ' ' . $seller->last_name,
            $seller->email,
            $seller->created_at->format('Y-m-d'),
            $seller->country ?? 'N/A',
            $seller->city ?? 'N/A',
            $statusText[$seller->status] ?? 'Unknown',
            $seller->teacher_gigs_count ?? 0,
            $seller->book_orders_count ?? 0,
            number_format($seller->total_earnings ?? 0, 2),
            $seller->average_rating ? number_format($seller->average_rating, 2) : 'N/A',
            $seller->received_reviews_count ?? 0,
            $category,
            $serviceTypes ?: 'N/A',
            $seller->phone ?? 'N/A',
            $seller->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold header
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2E8F0']
                ]
            ],
        ];
    }
}
