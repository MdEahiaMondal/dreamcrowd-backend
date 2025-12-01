<?php

namespace App\Exports;

use App\Services\UserDashboardService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class UserDashboardExport implements WithMultipleSheets
{
    protected $userId;
    protected $dateFrom;
    protected $dateTo;
    protected $dashboardService;

    public function __construct($userId, $dateFrom = null, $dateTo = null)
    {
        $this->userId = $userId;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->dashboardService = new UserDashboardService();
    }

    public function sheets(): array
    {
        return [
            new SummarySheet($this->userId, $this->dateFrom, $this->dateTo),
            new TransactionsSheet($this->userId, $this->dateFrom, $this->dateTo),
            new MonthlyBreakdownSheet($this->userId),
        ];
    }
}

// =====================================================
// Sheet 1: Summary Statistics
// =====================================================
class SummarySheet implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    protected $userId;
    protected $dateFrom;
    protected $dateTo;
    protected $dashboardService;

    public function __construct($userId, $dateFrom, $dateTo)
    {
        $this->userId = $userId;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->dashboardService = new UserDashboardService();
    }

    public function title(): string
    {
        return 'Summary';
    }

    public function collection()
    {
        $stats = $this->dashboardService->getAllStatistics($this->userId, $this->dateFrom, $this->dateTo);
        $user = \Auth::user();

        return collect([
            // User Info Section
            ['USER INFORMATION', ''],
            ['User Name', $user->name],
            ['Email', $user->email],
            ['Member Since', \Carbon\Carbon::parse($user->created_at)->format('M d, Y')],
            ['Days as Member', $stats['engagement']['days_as_member']],
            ['Report Date Range', ($this->dateFrom ? \Carbon\Carbon::parse($this->dateFrom)->format('M d, Y') : 'All Time') . ' to ' . ($this->dateTo ? \Carbon\Carbon::parse($this->dateTo)->format('M d, Y') : 'Present')],
            [''],

            // Financial Statistics
            ['FINANCIAL STATISTICS', ''],
            ['Total Spent', \App\Services\CurrencyService::formatRaw($stats['financial']['total_spent'], 'USD')],
            ['This Month Spent', \App\Services\CurrencyService::formatRaw($stats['financial']['month_spent'], 'USD')],
            ['Today Spent', \App\Services\CurrencyService::formatRaw($stats['financial']['today_spent'], 'USD')],
            ['Average Order Value', \App\Services\CurrencyService::formatRaw($stats['financial']['avg_order_value'], 'USD')],
            ['Total Service Fees Paid', \App\Services\CurrencyService::formatRaw($stats['financial']['total_service_fees'], 'USD')],
            ['Total Coupon Savings', \App\Services\CurrencyService::formatRaw($stats['financial']['total_coupon_savings'], 'USD')],
            ['Total Refunded', \App\Services\CurrencyService::formatRaw($stats['financial']['total_refunded'], 'USD')],
            [''],

            // Order Statistics
            ['ORDER STATISTICS', ''],
            ['Total Orders', $stats['orders']['total_orders']],
            ['Active Orders', $stats['orders']['active_orders']],
            ['Pending Orders', $stats['orders']['pending_orders']],
            ['Delivered Orders', $stats['orders']['delivered_orders']],
            ['Completed Orders', $stats['orders']['completed_orders']],
            ['Cancelled Orders', $stats['orders']['cancelled_orders']],
            ['Class Orders', $stats['orders']['class_orders']],
            ['Freelance Orders', $stats['orders']['freelance_orders']],
            ['Online Orders', $stats['orders']['online_orders']],
            ['In-Person Orders', $stats['orders']['inperson_orders']],
            ['Upcoming Classes', $stats['orders']['upcoming_classes']],
            [''],

            // Engagement Statistics
            ['ENGAGEMENT STATISTICS', ''],
            ['Reviews Given', $stats['engagement']['reviews_given']],
            ['Disputes Filed', $stats['engagement']['disputes_filed']],
            ['Coupons Used', $stats['engagement']['coupons_used']],
            ['Unique Sellers', $stats['engagement']['unique_sellers']],
        ]);
    }

    public function headings(): array
    {
        return ['Metric', 'Value'];
    }

    public function styles(Worksheet $sheet)
    {
        // Auto-size columns
        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(30);

        // Style headers
        $sheet->getStyle('A1:B1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '007bff'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Style section headers
        $sectionRows = [2, 9, 18, 31];
        foreach ($sectionRows as $row) {
            $sheet->getStyle("A{$row}:B{$row}")->applyFromArray([
                'font' => [
                    'bold' => true,
                    'size' => 11,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E7F1FF'],
                ],
            ]);
        }

        return [];
    }
}

// =====================================================
// Sheet 2: Transactions
// =====================================================
class TransactionsSheet implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    protected $userId;
    protected $dateFrom;
    protected $dateTo;
    protected $dashboardService;

    public function __construct($userId, $dateFrom, $dateTo)
    {
        $this->userId = $userId;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->dashboardService = new UserDashboardService();
    }

    public function title(): string
    {
        return 'Transactions';
    }

    public function collection()
    {
        $transactions = $this->dashboardService->getRecentTransactions($this->userId, 1000, 1);

        return $transactions->map(function ($order) {
            $statusLabels = [
                '0' => 'Pending',
                '1' => 'Active',
                '2' => 'Delivered',
                '3' => 'Completed',
                '4' => 'Cancelled',
            ];

            return [
                'order_id' => $order->id,
                'date' => $order->created_at->format('Y-m-d H:i:s'),
                'service' => $order->gig->title ?? 'N/A',
                'category' => $order->gig->category_name ?? 'N/A',
                'seller' => $order->teacher->name ?? 'N/A',
                'service_type' => $order->gig->service_type ?? 'N/A',
                'amount' => $order->price ?? 0,
                'service_fee' => $order->buyer_commission ?? 0,
                'discount' => $order->discount ?? 0,
                'final_price' => $order->finel_price ?? 0,
                'status' => $statusLabels[$order->status] ?? 'Unknown',
                'coupon_code' => $order->coupen ?? 'N/A',
                'payment_id' => $order->payment_id ?? 'N/A',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'Date',
            'Service',
            'Category',
            'Seller',
            'Service Type',
            'Amount',
            'Service Fee',
            'Discount',
            'Final Price',
            'Status',
            'Coupon Code',
            'Payment ID',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Auto-size all columns
        foreach (range('A', 'M') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Style header row
        $sheet->getStyle('A1:M1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '007bff'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Add alternating row colors
        $highestRow = $sheet->getHighestRow();
        for ($row = 2; $row <= $highestRow; $row++) {
            if ($row % 2 == 0) {
                $sheet->getStyle("A{$row}:M{$row}")->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'F8F9FA'],
                    ],
                ]);
            }
        }

        return [];
    }
}

// =====================================================
// Sheet 3: Monthly Breakdown
// =====================================================
class MonthlyBreakdownSheet implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    protected $userId;
    protected $dashboardService;

    public function __construct($userId)
    {
        $this->userId = $userId;
        $this->dashboardService = new UserDashboardService();
    }

    public function title(): string
    {
        return 'Monthly Breakdown';
    }

    public function collection()
    {
        $monthlyData = $this->dashboardService->getMonthlyTrendData($this->userId, 12);

        $data = collect();

        for ($i = 0; $i < count($monthlyData['labels']); $i++) {
            $data->push([
                'month' => $monthlyData['labels'][$i],
                'spent' => \App\Services\CurrencyService::formatRaw($monthlyData['spent'][$i], 'USD'),
                'order_count' => $monthlyData['count'][$i],
                'avg_order' => $monthlyData['count'][$i] > 0 ? \App\Services\CurrencyService::formatRaw($monthlyData['spent'][$i] / $monthlyData['count'][$i], 'USD') : \App\Services\CurrencyService::formatRaw(0, 'USD'),
            ]);
        }

        // Add total row
        $totalSpent = array_sum($monthlyData['spent']);
        $totalOrders = array_sum($monthlyData['count']);

        $data->push([
            'month' => 'TOTAL',
            'spent' => \App\Services\CurrencyService::formatRaw($totalSpent, 'USD'),
            'order_count' => $totalOrders,
            'avg_order' => $totalOrders > 0 ? \App\Services\CurrencyService::formatRaw($totalSpent / $totalOrders, 'USD') : \App\Services\CurrencyService::formatRaw(0, 'USD'),
        ]);

        return $data;
    }

    public function headings(): array
    {
        return [
            'Month',
            'Total Spent',
            'Order Count',
            'Average Order Value',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Auto-size columns
        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Style header row
        $sheet->getStyle('A1:D1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '007bff'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Style total row
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle("A{$highestRow}:D{$highestRow}")->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FFE699'],
            ],
        ]);

        return [];
    }
}
