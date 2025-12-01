<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BuyersExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * Query for buyers with filters
     */
    public function query()
    {
        $query = User::query()
            ->buyersOnly()
            ->withCount(['bookOrders'])
            ->withSum('buyerTransactions as total_spent', 'total_amount');

        // Apply status filter
        if (!empty($this->filters['status'])) {
            switch ($this->filters['status']) {
                case 'active':
                    $query->active();
                    break;
                case 'banned':
                    $query->banned();
                    break;
                case 'inactive':
                    $query->inactive();
                    break;
                case 'deleted':
                    $query->onlyTrashed();
                    break;
            }
        }

        // Apply search filter
        if (!empty($this->filters['search'])) {
            $query->search($this->filters['search']);
        }

        // Apply date range filter
        if (!empty($this->filters['date_from'])) {
            $query->whereDate('created_at', '>=', $this->filters['date_from']);
        }
        if (!empty($this->filters['date_to'])) {
            $query->whereDate('created_at', '<=', $this->filters['date_to']);
        }

        // Apply sorting
        if (!empty($this->filters['sort'])) {
            switch ($this->filters['sort']) {
                case 'name_asc':
                    $query->orderBy('first_name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('first_name', 'desc');
                    break;
                case 'date_asc':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'date_desc':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'spending':
                    $query->orderByDesc('total_spent');
                    break;
                case 'orders':
                    $query->orderByDesc('book_orders_count');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query;
    }

    /**
     * Define the headings for the Excel file
     */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Country',
            'City',
            'Status',
            'Total Spent',
            'Total Orders',
            'Last Active',
            'Joined Date',
            'Banned Reason',
        ];
    }

    /**
     * Map each row of data
     */
    public function map($buyer): array
    {
        return [
            $buyer->id,
            $buyer->first_name . ' ' . $buyer->last_name,
            $buyer->email,
            $buyer->country ?? 'N/A',
            $buyer->city ?? 'N/A',
            ucfirst($buyer->status_string ?? 'active'),
            \App\Services\CurrencyService::formatRaw($buyer->total_spent ?? 0, 'USD'),
            $buyer->book_orders_count ?? 0,
            $buyer->last_active_at ? $buyer->last_active_at->format('Y-m-d H:i:s') : 'Never',
            $buyer->created_at->format('Y-m-d H:i:s'),
            $buyer->banned_reason ?? 'N/A',
        ];
    }

    /**
     * Style the worksheet
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row (header)
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E0E0E0']
                ]
            ],
        ];
    }
}
