<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        return $this->transactions;
    }

    public function headings(): array
    {
        return [
            'Transaction ID',
            'Date',
            'Seller Name',
            'Seller Email',
            'Buyer Name',
            'Buyer Email',
            'Service Title',
            'Service Type',
            'Total Amount',
            'Currency',
            'Seller Commission Rate',
            'Seller Commission Amount',
            'Buyer Commission Rate',
            'Buyer Commission Amount',
            'Admin Commission',
            'Seller Earnings',
            'Status',
            'Payout Status',
            'Stripe Transaction ID',
            'Created At',
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->id,
            $transaction->created_at->format('d-m-Y H:i:s'),
            $transaction->seller ? $transaction->seller->first_name . ' ' . $transaction->seller->last_name : 'N/A',
            $transaction->seller ? $transaction->seller->email : 'N/A',
            $transaction->buyer ? $transaction->buyer->first_name . ' ' . $transaction->buyer->last_name : 'N/A',
            $transaction->buyer ? $transaction->buyer->email : 'N/A',
            $transaction->bookOrder && $transaction->bookOrder->gig ? $transaction->bookOrder->gig->title : 'N/A',
            ucfirst($transaction->service_type ?? 'N/A'),
            $transaction->total_amount,
            $transaction->currency,
            $transaction->seller_commission_rate ?? 0,
            $transaction->seller_commission_amount ?? 0,
            $transaction->buyer_commission_rate ?? 0,
            $transaction->buyer_commission_amount ?? 0,
            $transaction->total_admin_commission ?? 0,
            $transaction->seller_earnings ?? 0,
            ucfirst($transaction->status),
            ucfirst($transaction->payout_status),
            $transaction->stripe_transaction_id ?? 'N/A',
            $transaction->created_at->format('Y-m-d H:i:s'),
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
