<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CommissionReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * Get transactions collection
     */
    public function collection()
    {
        $query = Transaction::with(['buyer', 'seller']);

        if (isset($this->filters['date_from'])) {
            $query->whereDate('created_at', '>=', $this->filters['date_from']);
        }

        if (isset($this->filters['date_to'])) {
            $query->whereDate('created_at', '<=', $this->filters['date_to']);
        }

        if (isset($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * Define headings
     */
    public function headings(): array
    {
        return [
            'Transaction ID',
            'Date',
            'Time',
            'Buyer Name',
            'Buyer Email',
            'Seller Name',
            'Seller Email',
            'Service Type',
            'Service ID',
            'Total Amount',
            'Currency',
            'Commission Rate (%)',
            'Seller Commission',
            'Buyer Commission',
            'Total Admin Commission',
            'Seller Earnings',
            'Status',
            'Payout Status',
            'Stripe Transaction ID',
            'Paid At',
            'Payout At',
        ];
    }

    /**
     * Map transaction data
     */
    public function map($transaction): array
    {
        return [
            $transaction->id,
            $transaction->created_at->format('Y-m-d'),
            $transaction->created_at->format('H:i:s'),
            $transaction->buyer->name ?? 'N/A',
            $transaction->buyer->email ?? 'N/A',
            $transaction->seller->name ?? 'N/A',
            $transaction->seller->email ?? 'N/A',
            ucfirst($transaction->service_type),
            $transaction->service_id,
            $transaction->total_amount,
            $transaction->currency,
            $transaction->seller_commission_rate,
            $transaction->seller_commission_amount,
            $transaction->buyer_commission_amount,
            $transaction->total_admin_commission,
            $transaction->seller_earnings,
            ucfirst($transaction->status),
            ucfirst($transaction->payout_status),
            $transaction->stripe_transaction_id ?? 'N/A',
            $transaction->paid_at ? $transaction->paid_at->format('Y-m-d H:i:s') : 'N/A',
            $transaction->payout_at ? $transaction->payout_at->format('Y-m-d H:i:s') : 'N/A',
        ];
    }

    /**
     * Apply styles
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '007bff']
                ],
                'font' => ['color' => ['rgb' => 'FFFFFF']],
            ],
        ];
    }

    /**
     * Sheet title
     */
    public function title(): string
    {
        return 'Commission Report';
    }
}
