<?php

namespace App\Exports;

use App\Models\TeacherGig;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ServicesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = TeacherGig::with([
            'user:id,first_name,last_name,email',
            'all_reviews:id,gig_id,rating,cmnt',
        ])
        ->withCount('all_reviews')
        ->withAvg('all_reviews', 'rating');

        // Apply filters from request
        if (isset($this->filters['status']) && $this->filters['status'] != 'all') {
            $statusMap = [
                'newly_created' => 0,
                'active' => 1,
                'delivered' => 2,
                'cancelled' => 3,
                'completed' => 4,
            ];
            if (isset($statusMap[$this->filters['status']])) {
                $query->where('status', $statusMap[$this->filters['status']]);
            }
        }

        if (isset($this->filters['seller_id'])) {
            $query->where('user_id', $this->filters['seller_id']);
        }

        if (isset($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('category_name', 'like', '%' . $search . '%')
                  ->orWhere('sub_category', 'like', '%' . $search . '%');
            });
        }

        if (isset($this->filters['service_type'])) {
            $query->where('service_type', $this->filters['service_type']);
        }

        if (isset($this->filters['service_role'])) {
            $query->where('service_role', $this->filters['service_role']);
        }

        if (isset($this->filters['category'])) {
            $query->where('category', $this->filters['category']);
        }

        if (isset($this->filters['date_from'])) {
            $query->whereDate('created_at', '>=', $this->filters['date_from']);
        }

        if (isset($this->filters['date_to'])) {
            $query->whereDate('created_at', '<=', $this->filters['date_to']);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Service ID',
            'Title',
            'Seller Name',
            'Seller Email',
            'Category',
            'Sub Category',
            'Service Type',
            'Service Role',
            'Rate',
            'Public Rate',
            'Private Rate',
            'Payment Type',
            'Delivery Time',
            'Status',
            'Total Orders',
            'Total Reviews',
            'Average Rating',
            'Impressions',
            'Clicks',
            'Created Date',
        ];
    }

    /**
     * @param mixed $service
     * @return array
     */
    public function map($service): array
    {
        // Map status to text
        $statusMap = [
            0 => 'Newly Created',
            1 => 'Active',
            2 => 'Delivered',
            3 => 'Cancelled',
            4 => 'Completed',
        ];

        return [
            $service->id,
            $service->title ?? 'N/A',
            ($service->user ? trim($service->user->first_name . ' ' . $service->user->last_name) : 'N/A'),
            $service->user->email ?? 'N/A',
            $service->category_name ?? 'N/A',
            $service->sub_category ?? 'N/A',
            $service->service_type ?? 'N/A',
            $service->service_role ?? 'N/A',
            $service->rate ?? 'N/A',
            $service->public_rate ?? 'N/A',
            $service->private_rate ?? 'N/A',
            $service->payment_type ?? 'N/A',
            $service->delivery_time ?? 'N/A',
            $statusMap[$service->status] ?? 'Unknown',
            $service->orders ?? 0,
            $service->all_reviews_count ?? 0,
            $service->all_reviews_avg_rating ? number_format($service->all_reviews_avg_rating, 1) : 'N/A',
            $service->impressions ?? 0,
            $service->clicks ?? 0,
            $service->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
