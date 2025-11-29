<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\BookOrder;
use App\Models\CouponUsage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransactionController extends Controller
{
    /**
     * Teacher/Seller Transaction Dashboard
     */
    public function sellerTransactions()
    {
        if (!Auth::check() || Auth::user()->role != 1) {
            return redirect('/')->with('error', 'Unauthorized access');
        }

        $sellerId = Auth::id();

        // Statistics
        $stats = $this->getSellerStats($sellerId);

        // Recent Transactions
        $transactions = Transaction::where('seller_id', $sellerId)
            ->with(['buyer', 'bookOrder'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Monthly earnings chart data (last 6 months)
        $monthlyData = $this->getSellerMonthlyData($sellerId);

        // dd($monthlyData);

        return view('Teacher-Dashboard.transactions', compact('stats', 'transactions', 'monthlyData'));
    }

    /**
     * Buyer/User Transaction Dashboard
     */
    public function buyerTransactions()
    {
        if (!Auth::check() || Auth::user()->role != 0) {
            return redirect('/')->with('error', 'Unauthorized access');
        }

        $buyerId = Auth::id();

        // Statistics
        $stats = $this->getBuyerStats($buyerId);

        // Recent Transactions
        $transactions = Transaction::where('buyer_id', $buyerId)
            ->with(['seller', 'bookOrder'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Monthly spending chart data (last 6 months)
        $monthlyData = $this->getBuyerMonthlyData($buyerId);

        // Coupon usage history
        $couponUsage = CouponUsage::where('buyer_id', $buyerId)
            ->with('coupon')
            ->orderBy('used_at', 'desc')
            ->limit(10)
            ->get();

        return view('User-Dashboard.transactions', compact('stats', 'transactions', 'monthlyData', 'couponUsage'));
    }

    /**
     * Get seller statistics
     */
    private function getSellerStats($sellerId)
    {
        $baseQuery = Transaction::where('seller_id', $sellerId);

        return [
            // Total earnings (all time)
            'total_earnings' => $baseQuery->clone()
                ->where('status', 'completed')
                ->sum('seller_earnings'),

            // Pending earnings (not yet paid out)
            'pending_earnings' => $baseQuery->clone()
                ->where('status', 'completed')
                ->where('payout_status', 'pending')
                ->sum('seller_earnings'),

            // Paid earnings
            'paid_earnings' => $baseQuery->clone()
                ->where('payout_status', 'paid')
                ->sum('seller_earnings'),

            // This month earnings
            'month_earnings' => $baseQuery->clone()
                ->where('status', 'completed')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('seller_earnings'),

            // Today's earnings
            'today_earnings' => $baseQuery->clone()
                ->where('status', 'completed')
                ->whereDate('created_at', today())
                ->sum('seller_earnings'),

            // Total transactions
            'total_transactions' => $baseQuery->clone()->count(),

            // Completed transactions
            'completed_transactions' => $baseQuery->clone()
                ->where('status', 'completed')
                ->count(),

            // Pending transactions
            'pending_transactions' => $baseQuery->clone()
                ->where('status', 'pending')
                ->count(),

            // Refunded transactions
            'refunded_transactions' => $baseQuery->clone()
                ->where('status', 'refunded')
                ->count(),

            // Average transaction value
            'avg_transaction' => $baseQuery->clone()
                ->where('status', 'completed')
                ->avg('seller_earnings'),

            // Commission taken (total)
            'total_commission' => $baseQuery->clone()
                ->where('status', 'completed')
                ->sum('seller_commission_amount'),

            // Average commission rate
            'avg_commission_rate' => $baseQuery->clone()
                ->where('status', 'completed')
                ->avg('seller_commission_rate'),
        ];
    }

    /**
     * Get buyer statistics
     */
    private function getBuyerStats($buyerId)
    {
        $baseQuery = Transaction::where('buyer_id', $buyerId);

        return [
            // Total spent (all time)
            'total_spent' => $baseQuery->clone()
                ->where('status', 'completed')
                ->sum('total_amount'),

            // This month spending
            'month_spent' => $baseQuery->clone()
                ->where('status', 'completed')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total_amount'),

            // Today's spending
            'today_spent' => $baseQuery->clone()
                ->where('status', 'completed')
                ->whereDate('created_at', today())
                ->sum('total_amount'),

            // Total transactions
            'total_transactions' => $baseQuery->clone()->count(),

            // Completed transactions
            'completed_transactions' => $baseQuery->clone()
                ->where('status', 'completed')
                ->count(),

            // Pending transactions
            'pending_transactions' => $baseQuery->clone()
                ->where('status', 'pending')
                ->count(),

            // Refunded transactions
            'refunded_transactions' => $baseQuery->clone()
                ->where('status', 'refunded')
                ->count(),

            // Total saved with coupons
            'total_coupon_savings' => CouponUsage::where('buyer_id', $buyerId)
                ->sum('discount_amount'),

            // Service fees paid (buyer commission)
            'total_service_fees' => $baseQuery->clone()
                ->where('status', 'completed')
                ->sum('buyer_commission_amount'),

            // Average order value
            'avg_order_value' => $baseQuery->clone()
                ->where('status', 'completed')
                ->avg('total_amount'),

            // Total refunded amount
            'total_refunded' => $baseQuery->clone()
                ->where('status', 'refunded')
                ->sum('total_amount'),

            // Number of coupons used
            'coupons_used_count' => CouponUsage::where('buyer_id', $buyerId)->count(),
        ];
    }

    /**
     * Get seller monthly data (last 6 months)
     */
    private function getSellerMonthlyData($sellerId)
    {
        $data = Transaction::where('seller_id', $sellerId)
            ->where('status', 'completed')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month,
                         SUM(seller_earnings) as earnings,
                         COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        return [
            'labels' => $data->map(function ($item) {
                return Carbon::parse($item->month . '-01')->format('M Y');
            }),
            'earnings' => $data->pluck('earnings'),
            'count' => $data->pluck('count'),
        ];
    }

    /**
     * Get buyer monthly data (last 6 months)
     */
    private function getBuyerMonthlyData($buyerId)
    {
        $data = Transaction::where('buyer_id', $buyerId)
            ->where('status', 'completed')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month,
                         SUM(total_amount) as spent,
                         COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        return [
            'labels' => $data->map(function ($item) {
                return Carbon::parse($item->month . '-01')->format('M Y');
            }),
            'spent' => $data->pluck('spent'),
            'count' => $data->pluck('count'),
        ];
    }

    /**
     * View single transaction details (both seller and buyer)
     */
    public function viewTransaction($id)
    {
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Please login first');
        }

        $transaction = Transaction::with(['buyer', 'seller', 'bookOrder'])
            ->findOrFail($id);

        // Check authorization
        if (Auth::user()->role == 1) {
            // Seller
            if ($transaction->seller_id != Auth::id()) {
                return redirect()->back()->with('error', 'Unauthorized access');
            }
        } elseif (Auth::user()->role == 0) {
            // Buyer
            if ($transaction->buyer_id != Auth::id()) {
                return redirect()->back()->with('error', 'Unauthorized access');
            }
        } else {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        return view('shared.transaction-details', compact('transaction'));
    }

    /**
     * Download transaction invoice (buyer only)
     */
    public function downloadInvoice($id)
    {
        if (!Auth::check() || Auth::user()->role != 0) {
            return redirect('/')->with('error', 'Unauthorized access');
        }

        $transaction = Transaction::with(['buyer', 'seller', 'bookOrder'])
            ->where('buyer_id', Auth::id())
            ->findOrFail($id);

        $data = [
            'transaction' => $transaction,
            'companyName' => 'Dreamcrowd',
            'companyAddress' => 'Your Company Address',
            'companyEmail' => 'support@dreamcrowd.com',
            'companyPhone' => '+1 234 567 8900',
            'invoiceDate' => now()->format('d M Y'),
        ];

        $pdf = \PDF::loadView('User-Dashboard.transaction-invoice', $data);
        $filename = 'invoice_' . str_pad($transaction->id, 6, '0', STR_PAD_LEFT) . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Filter transactions (AJAX)
     */
    public function filterTransactions(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userRole = Auth::user()->role;
        $userId = Auth::id();

        $query = Transaction::query();

        // Filter by user role
        if ($userRole == 1) {
            $query->where('seller_id', $userId);
        } elseif ($userRole == 0) {
            $query->where('buyer_id', $userId);
        }

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payout_status') && $userRole == 1) {
            $query->where('payout_status', $request->payout_status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('min_amount')) {
            if ($userRole == 1) {
                $query->where('seller_earnings', '>=', $request->min_amount);
            } else {
                $query->where('total_amount', '>=', $request->min_amount);
            }
        }

        if ($request->filled('max_amount')) {
            if ($userRole == 1) {
                $query->where('seller_earnings', '<=', $request->max_amount);
            } else {
                $query->where('total_amount', '<=', $request->max_amount);
            }
        }

        $transactions = $query->with(['buyer', 'seller', 'bookOrder'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json($transactions);
    }

    /**
     * Seller/Teacher Invoice Download
     */
    public function downloadSellerInvoice($id)
    {
        if (!Auth::check() || Auth::user()->role != 1) {
            return redirect('/')->with('error', 'Unauthorized access');
        }

        $transaction = Transaction::with(['buyer', 'seller', 'bookOrder'])
            ->where('seller_id', Auth::id())
            ->findOrFail($id);

        $data = [
            'transaction' => $transaction,
            'companyName' => 'Dreamcrowd',
            'companyAddress' => 'Your Company Address',
            'companyEmail' => 'support@dreamcrowd.com',
            'companyPhone' => '+1 234 567 8900',
            'invoiceDate' => now()->format('d M Y'),
        ];

        $pdf = \PDF::loadView('user.transaction-invoice', $data);
        $filename = 'seller_invoice_' . str_pad($transaction->id, 6, '0', STR_PAD_LEFT) . '.pdf';

        return $pdf->download($filename);
    }
}