<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SellerEarningsExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $sellerId;
    protected $filters;

    public function __construct($sellerId, $filters = [])
    {
        $this->sellerId = $sellerId;
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Transaction::with(['buyer', 'bookOrder', 'service'])
            ->where('seller_id', $this->sellerId)
            ->where('status', 'completed');

        // Apply date filters
        if (!empty($this->filters['date_from'])) {
            $query->whereDate('created_at', '>=', $this->filters['date_from']);
        }
        if (!empty($this->filters['date_to'])) {
            $query->whereDate('created_at', '<=', $this->filters['date_to']);
        }

        // Apply service type filter
        if (!empty($this->filters['service_type'])) {
            $query->where('service_type', $this->filters['service_type']);
        }

        // Apply payout status filter
        if (!empty($this->filters['status'])) {
            $query->where('payout_status', $this->filters['status']);
        }

        return $query->orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'Date',
            'Transaction ID',
            'Buyer Name',
            'Service Title',
            'Service Type',
            'Order Amount ($)',
            'Commission Rate (%)',
            'Commission Amount ($)',
            'Your Earnings ($)',
            'Payout Status',
            'Payment Reference',
        ];
    }

    public function map($txn): array
    {
        // Get buyer name with privacy (first name + last initial)
        $buyerName = 'N/A';
        if ($txn->buyer) {
            $firstName = $txn->buyer->first_name ?? '';
            $lastInitial = !empty($txn->buyer->last_name) ? strtoupper(substr($txn->buyer->last_name, 0, 1)) . '.' : '';
            $buyerName = trim($firstName . ' ' . $lastInitial) ?: 'N/A';
        }

        // Get service title
        $serviceTitle = $txn->bookOrder->title ?? ($txn->service->title ?? 'N/A');

        // Get payout status with proper formatting
        $payoutStatus = ucfirst($txn->payout_status ?? 'pending');
        if (in_array($txn->payout_status, ['completed', 'paid'])) {
            $payoutStatus = 'Paid';
        }

        return [
            $txn->created_at->format('Y-m-d'),
            '#' . str_pad($txn->id, 6, '0', STR_PAD_LEFT),
            $buyerName,
            $serviceTitle,
            ucfirst($txn->service_type ?? 'service'),
            number_format($txn->total_amount, 2),
            $txn->seller_commission_rate . '%',
            number_format($txn->seller_commission_amount, 2),
            number_format($txn->seller_earnings, 2),
            $payoutStatus,
            $txn->stripe_transaction_id ?? 'N/A',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Auto-size columns
        foreach (range('A', 'K') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [
            // Style the header row
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '28A745'] // Green color
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
    }

    public function title(): string
    {
        return 'Earnings Report';
    }
}
