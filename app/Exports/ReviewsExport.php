<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReviewsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $reviews;

    public function __construct($reviews)
    {
        $this->reviews = $reviews;
    }

    public function collection()
    {
        return $this->reviews;
    }

    public function headings(): array
    {
        return [
            'Review ID',
            'Date',
            'Seller Name',
            'Seller Email',
            'Buyer Name',
            'Buyer Email',
            'Service Title',
            'Service Type',
            'Rating',
            'Review Text',
            'Replies Count',
            'Created At',
        ];
    }

    public function map($review): array
    {
        return [
            $review->id,
            $review->created_at->format('Y-m-d'),
            $review->teacher ? $review->teacher->first_name . ' ' . $review->teacher->last_name : 'N/A',
            $review->teacher ? $review->teacher->email : 'N/A',
            $review->user ? $review->user->first_name . ' ' . $review->user->last_name : 'N/A',
            $review->user ? $review->user->email : 'N/A',
            $review->gig ? $review->gig->title : 'N/A',
            $review->gig ? $review->gig->service_type : 'N/A',
            $review->rating . '/5',
            $review->cmnt,
            $review->replies->count(),
            $review->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
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
