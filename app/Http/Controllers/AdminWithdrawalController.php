<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use App\Models\User;
use App\Models\Transaction;
use App\Models\TopSellerTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\WithdrawalStatusMail;
use Stripe\Stripe;
use Stripe\Transfer;

class AdminWithdrawalController extends Controller
{
    /**
     * Check if admin is authenticated
     */
    private function checkAdminAuth()
    {
        if (!Auth::check() || Auth::user()->role != 2) {
            return redirect('/')->with('error', 'Access denied.');
        }
        return null;
    }

    /**
     * Check if withdrawals feature is enabled
     */
    private function checkFeatureEnabled()
    {
        if (!config('features.seller_withdrawals_enabled', false)) {
            abort(404, 'Withdrawals feature is not available.');
        }
    }

    /**
     * List all withdrawal requests
     */
    public function index(Request $request)
    {
        $this->checkFeatureEnabled();

        if ($redirect = $this->checkAdminAuth()) {
            return $redirect;
        }

        $query = Withdrawal::with(['seller', 'processor'])
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('method')) {
            $query->where('method', $request->method);
        }

        if ($request->filled('seller_id')) {
            $query->where('seller_id', $request->seller_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $withdrawals = $query->paginate(20);

        // Get statistics
        $stats = [
            'pending' => Withdrawal::pending()->count(),
            'processing' => Withdrawal::processing()->count(),
            'total_pending_amount' => Withdrawal::whereIn('status', ['pending', 'processing'])->sum('amount'),
            'total_paid_this_month' => Withdrawal::completed()
                ->whereMonth('processed_at', now()->month)
                ->whereYear('processed_at', now()->year)
                ->sum('net_amount'),
        ];

        return view('Admin-Dashboard.withdrawals.index', compact('withdrawals', 'stats'));
    }

    /**
     * Show withdrawal details
     */
    public function show($id)
    {
        $this->checkFeatureEnabled();

        if ($redirect = $this->checkAdminAuth()) {
            return $redirect;
        }

        $withdrawal = Withdrawal::with(['seller', 'processor'])->findOrFail($id);

        // Get seller's other withdrawals
        $sellerWithdrawals = Withdrawal::forSeller($withdrawal->seller_id)
            ->where('id', '!=', $id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get seller's recent transactions
        $sellerTransactions = Transaction::where('seller_id', $withdrawal->seller_id)
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('Admin-Dashboard.withdrawals.show', compact(
            'withdrawal',
            'sellerWithdrawals',
            'sellerTransactions'
        ));
    }

    /**
     * Mark withdrawal as processing
     */
    public function markProcessing(Request $request, $id)
    {
        $this->checkFeatureEnabled();

        if ($redirect = $this->checkAdminAuth()) {
            return $redirect;
        }

        $withdrawal = Withdrawal::findOrFail($id);

        if (!$withdrawal->isPending()) {
            return back()->with('error', 'Only pending withdrawals can be marked as processing.');
        }

        $withdrawal->markAsProcessing(Auth::id());

        // Send notification email
        $this->sendStatusEmail($withdrawal, 'processing');

        return back()->with('success', 'Withdrawal marked as processing.');
    }

    /**
     * Complete withdrawal (mark as paid)
     */
    public function complete(Request $request, $id)
    {
        $this->checkFeatureEnabled();

        if ($redirect = $this->checkAdminAuth()) {
            return $redirect;
        }

        $request->validate([
            'transaction_id' => 'nullable|string|max:255',
            'admin_notes' => 'nullable|string|max:1000',
            'process_stripe' => 'nullable|boolean',
        ]);

        $withdrawal = Withdrawal::with('seller')->findOrFail($id);

        if (!in_array($withdrawal->status, ['pending', 'processing'])) {
            return back()->with('error', 'This withdrawal cannot be completed.');
        }

        $transactionId = $request->transaction_id;

        // Process Stripe Transfer if method is stripe and auto-process is requested
        if ($withdrawal->method === 'stripe' && $request->boolean('process_stripe', true)) {
            $stripeResult = $this->processStripeTransfer($withdrawal);

            if ($stripeResult['success']) {
                $transactionId = $stripeResult['transfer_id'];
            } else {
                return back()->with('error', 'Stripe Transfer failed: ' . $stripeResult['error']);
            }
        }

        $withdrawal->markAsCompleted($transactionId, Auth::id());

        if ($request->filled('admin_notes')) {
            $withdrawal->admin_notes = $request->admin_notes;
            $withdrawal->save();
        }

        // Update related transactions as paid out
        $this->markTransactionsAsPaid($withdrawal);

        // Send notification email
        $this->sendStatusEmail($withdrawal, 'completed');

        return back()->with('success', 'Withdrawal has been completed successfully. Transfer ID: ' . ($transactionId ?? 'N/A'));
    }

    /**
     * Process Stripe Transfer to seller's connected account
     */
    private function processStripeTransfer(Withdrawal $withdrawal): array
    {
        try {
            // Initialize Stripe
            Stripe::setApiKey(config('services.stripe.secret'));

            $seller = $withdrawal->seller;

            if (!$seller || empty($seller->stripe_account_id)) {
                return [
                    'success' => false,
                    'error' => 'Seller does not have a connected Stripe account.'
                ];
            }

            // Convert amount to cents for Stripe
            $amountInCents = (int) ($withdrawal->net_amount * 100);

            // Create the transfer to the connected account
            $transfer = Transfer::create([
                'amount' => $amountInCents,
                'currency' => strtolower($withdrawal->currency ?? 'usd'),
                'destination' => $seller->stripe_account_id,
                'transfer_group' => 'WITHDRAWAL_' . $withdrawal->id,
                'metadata' => [
                    'withdrawal_id' => $withdrawal->id,
                    'seller_id' => $seller->id,
                    'seller_email' => $seller->email,
                ],
            ]);

            Log::info('Stripe Transfer completed successfully', [
                'withdrawal_id' => $withdrawal->id,
                'transfer_id' => $transfer->id,
                'amount' => $withdrawal->net_amount,
                'seller_stripe_account' => $seller->stripe_account_id,
            ]);

            return [
                'success' => true,
                'transfer_id' => $transfer->id,
            ];

        } catch (\Stripe\Exception\ApiErrorException $e) {
            Log::error('Stripe Transfer failed', [
                'withdrawal_id' => $withdrawal->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];

        } catch (\Exception $e) {
            Log::error('Stripe Transfer error', [
                'withdrawal_id' => $withdrawal->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => 'An unexpected error occurred: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Reject/fail withdrawal
     */
    public function reject(Request $request, $id)
    {
        $this->checkFeatureEnabled();

        if ($redirect = $this->checkAdminAuth()) {
            return $redirect;
        }

        $request->validate([
            'failure_reason' => 'required|string|max:1000',
        ]);

        $withdrawal = Withdrawal::findOrFail($id);

        if (!in_array($withdrawal->status, ['pending', 'processing'])) {
            return back()->with('error', 'This withdrawal cannot be rejected.');
        }

        $withdrawal->markAsFailed($request->failure_reason, Auth::id());

        // Send notification email
        $this->sendStatusEmail($withdrawal, 'failed');

        return back()->with('success', 'Withdrawal has been rejected.');
    }

    /**
     * Bulk process withdrawals
     */
    public function bulkProcess(Request $request)
    {
        $this->checkFeatureEnabled();

        if ($redirect = $this->checkAdminAuth()) {
            return $redirect;
        }

        $request->validate([
            'withdrawal_ids' => 'required|array',
            'withdrawal_ids.*' => 'exists:withdrawals,id',
            'action' => 'required|in:processing,complete,reject',
            'failure_reason' => 'required_if:action,reject|nullable|string|max:1000',
        ]);

        $processed = 0;
        $failed = 0;

        foreach ($request->withdrawal_ids as $id) {
            $withdrawal = Withdrawal::find($id);

            if (!$withdrawal) {
                $failed++;
                continue;
            }

            try {
                switch ($request->action) {
                    case 'processing':
                        if ($withdrawal->isPending()) {
                            $withdrawal->markAsProcessing(Auth::id());
                            $this->sendStatusEmail($withdrawal, 'processing');
                            $processed++;
                        } else {
                            $failed++;
                        }
                        break;

                    case 'complete':
                        if (in_array($withdrawal->status, ['pending', 'processing'])) {
                            $transactionId = null;

                            // Process Stripe Transfer if method is stripe
                            if ($withdrawal->method === 'stripe') {
                                $withdrawal->load('seller');
                                $stripeResult = $this->processStripeTransfer($withdrawal);
                                if ($stripeResult['success']) {
                                    $transactionId = $stripeResult['transfer_id'];
                                } else {
                                    $failed++;
                                    continue 2; // Skip to next withdrawal
                                }
                            }

                            $withdrawal->markAsCompleted($transactionId, Auth::id());
                            $this->markTransactionsAsPaid($withdrawal);
                            $this->sendStatusEmail($withdrawal, 'completed');
                            $processed++;
                        } else {
                            $failed++;
                        }
                        break;

                    case 'reject':
                        if (in_array($withdrawal->status, ['pending', 'processing'])) {
                            $withdrawal->markAsFailed($request->failure_reason, Auth::id());
                            $this->sendStatusEmail($withdrawal, 'failed');
                            $processed++;
                        } else {
                            $failed++;
                        }
                        break;
                }
            } catch (\Exception $e) {
                $failed++;
            }
        }

        $message = "Processed {$processed} withdrawals.";
        if ($failed > 0) {
            $message .= " {$failed} failed.";
        }

        return back()->with('success', $message);
    }

    /**
     * Export withdrawals to CSV
     */
    public function export(Request $request)
    {
        $this->checkFeatureEnabled();

        if ($redirect = $this->checkAdminAuth()) {
            return $redirect;
        }

        $query = Withdrawal::with(['seller', 'processor'])
            ->orderBy('created_at', 'desc');

        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('method')) {
            $query->where('method', $request->method);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $withdrawals = $query->get();

        $filename = 'withdrawals_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($withdrawals) {
            $file = fopen('php://output', 'w');

            // Headers
            fputcsv($file, [
                'ID',
                'Date',
                'Seller',
                'Seller Email',
                'Amount',
                'Method',
                'Status',
                'Processing Fee',
                'Net Amount',
                'Transaction ID',
                'Processed At',
                'Processed By',
            ]);

            foreach ($withdrawals as $w) {
                fputcsv($file, [
                    $w->id,
                    $w->created_at->format('Y-m-d H:i:s'),
                    $w->seller->first_name . ' ' . $w->seller->last_name,
                    $w->seller->email,
                    $w->amount,
                    $w->method_display_name,
                    ucfirst($w->status),
                    $w->processing_fee,
                    $w->net_amount,
                    $w->stripe_transfer_id ?? $w->paypal_payout_id ?? $w->bank_reference ?? '-',
                    $w->processed_at ? $w->processed_at->format('Y-m-d H:i:s') : '-',
                    $w->processor ? $w->processor->first_name : '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Mark seller's transactions as paid out
     */
    private function markTransactionsAsPaid(Withdrawal $withdrawal)
    {
        $settings = TopSellerTag::first();
        $holdingDays = $settings->holding_period_days ?? 14;

        // Get cleared transactions that haven't been paid
        $transactions = Transaction::where('seller_id', $withdrawal->seller_id)
            ->where('status', 'completed')
            ->where('payout_status', 'pending')
            ->where('created_at', '<', now()->subDays($holdingDays))
            ->orderBy('created_at', 'asc')
            ->get();

        $remainingAmount = $withdrawal->amount;

        foreach ($transactions as $txn) {
            if ($remainingAmount <= 0) {
                break;
            }

            if ($txn->seller_earnings <= $remainingAmount) {
                $txn->payout_status = 'paid';
                $txn->save();
                $remainingAmount -= $txn->seller_earnings;
            }
        }
    }

    /**
     * Send status notification email
     */
    private function sendStatusEmail(Withdrawal $withdrawal, $status)
    {
        try {
            $seller = $withdrawal->seller;
            if ($seller && $seller->email) {
                Mail::to($seller->email)->queue(new WithdrawalStatusMail($withdrawal, $status));
            }
        } catch (\Exception $e) {
            // Log error but don't fail the request
            \Log::error('Failed to send withdrawal status email: ' . $e->getMessage());
        }
    }
}
