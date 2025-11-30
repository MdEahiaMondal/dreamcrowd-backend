<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TopSellerTag;
use App\Exports\SellerEarningsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class SellerEarningsController extends Controller
{
    /**
     * Check if feature is enabled
     */
    private function checkFeatureEnabled()
    {
        if (!config('features.seller_earnings_enabled', false)) {
            abort(404, 'This feature is not available.');
        }
    }

    /**
     * Display Earnings & Payouts Dashboard
     */
    public function index(Request $request)
    {
        $this->checkFeatureEnabled();

        if (!Auth::check() || Auth::user()->role != 1) {
            return redirect('/')->with('error', 'Please login as a seller.');
        }

        $sellerId = Auth::id();
        $settings = TopSellerTag::first() ?? TopSellerTag::getCommissionSettings();
        $holdingDays = $settings->holding_period_days ?? 14;

        // Calculate earnings
        $stats = [
            'total_earned' => Transaction::where('seller_id', $sellerId)
                ->where('status', 'completed')
                ->sum('seller_earnings') ?? 0,

            'available' => Transaction::where('seller_id', $sellerId)
                ->where('status', 'completed')
                ->where('payout_status', 'pending')
                ->where('created_at', '<', now()->subDays($holdingDays))
                ->sum('seller_earnings') ?? 0,

            'pending_clearance' => Transaction::where('seller_id', $sellerId)
                ->where('status', 'completed')
                ->where('payout_status', 'pending')
                ->where('created_at', '>=', now()->subDays($holdingDays))
                ->sum('seller_earnings') ?? 0,

            'withdrawn' => Transaction::where('seller_id', $sellerId)
                ->whereIn('payout_status', ['completed', 'paid'])
                ->sum('seller_earnings') ?? 0,
        ];

        // Transaction history query
        $query = Transaction::with(['buyer', 'service', 'bookOrder'])
            ->where('seller_id', $sellerId)
            ->where('status', 'completed');

        // Apply filters
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('service_type')) {
            $query->where('service_type', $request->service_type);
        }
        if ($request->filled('status')) {
            $query->where('payout_status', $request->status);
        }

        $transactions = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('Teacher-Dashboard.earnings-payouts', compact(
            'stats',
            'transactions',
            'settings'
        ));
    }

    /**
     * Generate Invoice PDF
     */
    public function downloadInvoice($transactionId)
    {
        $this->checkFeatureEnabled();

        if (!Auth::check() || Auth::user()->role != 1) {
            return redirect('/')->with('error', 'Please login as a seller.');
        }

        $transaction = Transaction::with(['buyer', 'seller', 'service', 'bookOrder'])
            ->where('seller_id', Auth::id())
            ->findOrFail($transactionId);

        $pdf = Pdf::loadView('invoices.seller-earnings-invoice', [
            'transaction' => $transaction
        ]);

        return $pdf->download('earnings-invoice-' . $transaction->id . '.pdf');
    }

    /**
     * Export Earnings Report
     */
    public function exportReport(Request $request)
    {
        $this->checkFeatureEnabled();

        if (!Auth::check() || Auth::user()->role != 1) {
            return redirect('/')->with('error', 'Please login as a seller.');
        }

        return Excel::download(
            new SellerEarningsExport(Auth::id(), $request->all()),
            'earnings-report-' . date('Y-m-d') . '.xlsx'
        );
    }
}
