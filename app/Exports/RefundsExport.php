<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RefundsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $disputes;

    public function __construct($disputes)
    {
        $this->disputes = $disputes;
    }

    public function collection()
    {
        return $this->disputes;
    }

    public function headings(): array
    {
        return [
            'Dispute ID',
            'Order ID',
            'User Name',
            'User Email',
            'Seller Name',
            'Seller Email',
            'Service Title',
            'Refund Amount',
            'Refund Type',
            'Status',
            'User Disputed',
            'Teacher Disputed',
            'Reason',
            'Admin Notes',
            'Created At',
            'Updated At',
        ];
    }

    public function map($dispute): array
    {
        $status = match($dispute->status) {
            0 => 'Pending',
            1 => 'Approved',
            2 => 'Rejected',
            default => 'Unknown',
        };

        $refundType = $dispute->refund_type == 0 ? 'Full Refund' : 'Partial Refund';

        return [
            $dispute->id,
            $dispute->order_id,
            $dispute->user ? $dispute->user->name : 'N/A',
            $dispute->user ? $dispute->user->email : 'N/A',
            $dispute->order && $dispute->order->gig && $dispute->order->gig->user ? $dispute->order->gig->user->name : 'N/A',
            $dispute->order && $dispute->order->gig && $dispute->order->gig->user ? $dispute->order->gig->user->email : 'N/A',
            $dispute->order && $dispute->order->gig ? $dispute->order->gig->title : 'N/A',
            '$' . number_format($dispute->amount, 2),
            $refundType,
            $status,
            $dispute->user_disputed ? 'Yes' : 'No',
            $dispute->teacher_disputed ? 'Yes' : 'No',
            $dispute->reason ?? 'N/A',
            $dispute->admin_notes ?? 'N/A',
            $dispute->created_at->format('Y-m-d H:i:s'),
            $dispute->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'FFF3E0']
                ]
            ],
        ];
    }
}
