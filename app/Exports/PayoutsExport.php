<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PayoutsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $payouts;

    public function __construct($payouts)
    {
        $this->payouts = $payouts;
    }

    public function collection()
    {
        return $this->payouts;
    }

    public function headings(): array
    {
        return [
            'Transaction ID',
            'Seller Name',
            'Seller Email',
            'Buyer Name',
            'Buyer Email',
            'Service Title',
            'Order Total',
            'Seller Earnings',
            'Admin Commission',
            'Seller Commission Rate',
            'Payout Status',
            'Payment Status',
            'Stripe Payout ID',
            'Payout Date',
            'Created At',
        ];
    }

    public function map($payout): array
    {
        return [
            $payout->id,
            $payout->seller ? $payout->seller->name : 'N/A',
            $payout->seller ? $payout->seller->email : 'N/A',
            $payout->buyer ? $payout->buyer->name : 'N/A',
            $payout->buyer ? $payout->buyer->email : 'N/A',
            $payout->bookOrder && $payout->bookOrder->gig ? $payout->bookOrder->gig->title : 'N/A',
            \App\Services\CurrencyService::formatRaw($payout->total_amount, 'USD'),
            \App\Services\CurrencyService::formatRaw($payout->seller_earnings, 'USD'),
            \App\Services\CurrencyService::formatRaw($payout->total_admin_commission, 'USD'),
            $payout->seller_commission_rate . '%',
            ucfirst($payout->payout_status),
            ucfirst($payout->status),
            $payout->stripe_payout_id ?? 'N/A',
            $payout->payout_at ? $payout->payout_at->format('Y-m-d H:i:s') : 'N/A',
            $payout->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E3F2FD']
                ]
            ],
        ];
    }
}
