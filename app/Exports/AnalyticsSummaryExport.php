<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AnalyticsSummaryExport implements WithMultipleSheets
{
    protected $refundStats;
    protected $payoutStats;
    protected $orderStats;
    protected $revenueStats;
    protected $startDate;
    protected $endDate;

    public function __construct($refundStats, $payoutStats, $orderStats, $revenueStats, $startDate, $endDate)
    {
        $this->refundStats = $refundStats;
        $this->payoutStats = $payoutStats;
        $this->orderStats = $orderStats;
        $this->revenueStats = $revenueStats;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function sheets(): array
    {
        return [
            new AnalyticsSummarySheet($this->refundStats, $this->payoutStats, $this->orderStats, $this->revenueStats, $this->startDate, $this->endDate),
            new TopSellersSheet($this->payoutStats['top_sellers']),
        ];
    }
}

class AnalyticsSummarySheet implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected $refundStats;
    protected $payoutStats;
    protected $orderStats;
    protected $revenueStats;
    protected $startDate;
    protected $endDate;

    public function __construct($refundStats, $payoutStats, $orderStats, $revenueStats, $startDate, $endDate)
    {
        $this->refundStats = $refundStats;
        $this->payoutStats = $payoutStats;
        $this->orderStats = $orderStats;
        $this->revenueStats = $revenueStats;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return collect([
            // Date Range
            ['Date Range', "{$this->startDate} to {$this->endDate}", '', ''],
            ['', '', '', ''],

            // Revenue Analytics
            ['REVENUE ANALYTICS', '', '', ''],
            ['Total Revenue', \App\Services\CurrencyService::formatRaw($this->revenueStats['total_revenue'], 'USD'), '', ''],
            ['Admin Commission', \App\Services\CurrencyService::formatRaw($this->revenueStats['total_admin_commission'], 'USD'), '', ''],
            ['Seller Earnings', \App\Services\CurrencyService::formatRaw($this->revenueStats['total_seller_earnings'], 'USD'), '', ''],
            ['Coupon Discounts', \App\Services\CurrencyService::formatRaw($this->revenueStats['total_coupon_discounts'], 'USD'), '', ''],
            ['Transaction Count', $this->revenueStats['transaction_count'], '', ''],
            ['Average Order Value', \App\Services\CurrencyService::formatRaw($this->revenueStats['average_order_value'], 'USD'), '', ''],
            ['', '', '', ''],

            // Payout Analytics
            ['PAYOUT ANALYTICS', '', '', ''],
            ['Total Payouts', $this->payoutStats['total_payouts'], '', ''],
            ['Completed Payouts', $this->payoutStats['completed'], '', ''],
            ['Pending Payouts', $this->payoutStats['pending'], '', ''],
            ['Failed Payouts', $this->payoutStats['failed'], '', ''],
            ['Total Payout Amount', \App\Services\CurrencyService::formatRaw($this->payoutStats['total_payout_amount'], 'USD'), '', ''],
            ['Pending Payout Amount', \App\Services\CurrencyService::formatRaw($this->payoutStats['pending_payout_amount'], 'USD'), '', ''],
            ['Average Payout Amount', \App\Services\CurrencyService::formatRaw($this->payoutStats['average_payout_amount'], 'USD'), '', ''],
            ['Completion Rate', $this->payoutStats['completion_rate'] . '%', '', ''],
            ['', '', '', ''],

            // Refund Analytics
            ['REFUND ANALYTICS', '', '', ''],
            ['Total Disputes', $this->refundStats['total_disputes'], '', ''],
            ['Approved Refunds', $this->refundStats['approved'], '', ''],
            ['Rejected Refunds', $this->refundStats['rejected'], '', ''],
            ['Pending Disputes', $this->refundStats['pending'], '', ''],
            ['Total Refund Amount', \App\Services\CurrencyService::formatRaw($this->refundStats['total_refund_amount'], 'USD'), '', ''],
            ['Average Refund Amount', \App\Services\CurrencyService::formatRaw($this->refundStats['average_refund_amount'], 'USD'), '', ''],
            ['Approval Rate', $this->refundStats['approval_rate'] . '%', '', ''],
            ['Rejection Rate', $this->refundStats['rejection_rate'] . '%', '', ''],
            ['Avg Processing Time', $this->refundStats['avg_processing_hours'] . ' hours', '', ''],
            ['', '', '', ''],

            // Order Analytics
            ['ORDER ANALYTICS', '', '', ''],
            ['Total Orders', $this->orderStats['total_orders'], '', ''],
            ['Pending Orders', $this->orderStats['pending'], '', ''],
            ['Active Orders', $this->orderStats['active'], '', ''],
            ['Delivered Orders', $this->orderStats['delivered'], '', ''],
            ['Completed Orders', $this->orderStats['completed'], '', ''],
            ['Cancelled Orders', $this->orderStats['cancelled'], '', ''],
            ['Completion Rate', $this->orderStats['completion_rate'] . '%', '', ''],
            ['Cancellation Rate', $this->orderStats['cancellation_rate'] . '%', '', ''],
            ['Dispute Rate', $this->orderStats['dispute_rate'] . '%', '', ''],
        ]);
    }

    public function headings(): array
    {
        return [
            'Metric',
            'Value',
            '',
            '',
        ];
    }

    public function title(): string
    {
        return 'Analytics Summary';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
            3 => ['font' => ['bold' => true, 'size' => 11], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E8F5E9']]],
            12 => ['font' => ['bold' => true, 'size' => 11], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E3F2FD']]],
            22 => ['font' => ['bold' => true, 'size' => 11], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFF3E0']]],
            32 => ['font' => ['bold' => true, 'size' => 11], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FCE4EC']]],
        ];
    }
}

class TopSellersSheet implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    protected $topSellers;

    public function __construct($topSellers)
    {
        $this->topSellers = $topSellers;
    }

    public function collection()
    {
        return $this->topSellers;
    }

    public function headings(): array
    {
        return [
            'Rank',
            'Seller ID',
            'Seller Name',
            'Seller Email',
            'Total Earnings',
            'Payout Count',
        ];
    }

    public function map($seller): array
    {
        static $rank = 0;
        $rank++;

        return [
            $rank,
            $seller->seller_id,
            $seller->seller->name ?? 'Unknown',
            $seller->seller->email ?? 'N/A',
            \App\Services\CurrencyService::formatRaw($seller->total_earnings, 'USD'),
            $seller->payout_count,
        ];
    }

    public function title(): string
    {
        return 'Top 10 Sellers';
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
