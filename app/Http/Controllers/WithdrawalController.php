<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use App\Models\Transaction;
use App\Models\TopSellerTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WithdrawalController extends Controller
{
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
     * Check if seller is authenticated
     */
    private function checkSellerAuth()
    {
        if (!Auth::check() || Auth::user()->role != 1) {
            return redirect('/')->with('error', 'Please login as a seller.');
        }
        return null;
    }

    /**
     * Get seller's available balance for withdrawal
     */
    private function getAvailableBalance($sellerId)
    {
        $settings = TopSellerTag::first();
        $holdingDays = $settings->holding_period_days ?? 14;

        // Total earnings that have cleared the holding period
        $clearedEarnings = Transaction::where('seller_id', $sellerId)
            ->where('status', 'completed')
            ->where('payout_status', 'pending')
            ->where('created_at', '<', now()->subDays($holdingDays))
            ->sum('seller_earnings');

        // Subtract pending withdrawal requests
        $pendingWithdrawals = Withdrawal::getPendingAmount($sellerId);

        return max(0, $clearedEarnings - $pendingWithdrawals);
    }

    /**
     * Show withdrawal request form
     */
    public function create(Request $request)
    {
        $this->checkFeatureEnabled();

        if ($redirect = $this->checkSellerAuth()) {
            return $redirect;
        }

        $seller = Auth::user();
        $settings = TopSellerTag::first() ?? TopSellerTag::getCommissionSettings();

        $availableBalance = $this->getAvailableBalance($seller->id);
        $minimumWithdrawal = $settings->minimum_withdrawal ?? 25.00;
        $hasPendingWithdrawal = Withdrawal::hasPendingWithdrawal($seller->id);

        // Get recent withdrawal history
        $withdrawals = Withdrawal::forSeller($seller->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('Teacher-Dashboard.withdrawal-request', compact(
            'seller',
            'settings',
            'availableBalance',
            'minimumWithdrawal',
            'hasPendingWithdrawal',
            'withdrawals'
        ));
    }

    /**
     * Store a new withdrawal request
     */
    public function store(Request $request)
    {
        $this->checkFeatureEnabled();

        if ($redirect = $this->checkSellerAuth()) {
            return $redirect;
        }

        $seller = Auth::user();
        $settings = TopSellerTag::first() ?? TopSellerTag::getCommissionSettings();
        $availableBalance = $this->getAvailableBalance($seller->id);
        $minimumWithdrawal = $settings->minimum_withdrawal ?? 25.00;

        // Validate request (PayPal removed - only Stripe and Bank Transfer available)
        $validator = Validator::make($request->all(), [
            'amount' => "required|numeric|min:{$minimumWithdrawal}|max:{$availableBalance}",
            'method' => 'required|in:stripe,bank_transfer',
            'notes' => 'nullable|string|max:500',
        ], [
            'amount.min' => "Minimum withdrawal amount is \${$minimumWithdrawal}",
            'amount.max' => "Maximum available balance is \${$availableBalance}",
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Check for pending withdrawal
        if (Withdrawal::hasPendingWithdrawal($seller->id)) {
            return back()->with('error', 'You already have a pending withdrawal request. Please wait for it to be processed.');
        }

        // Validate payment method setup
        $paymentDetails = $this->validatePaymentMethod($seller, $request->method);
        if (isset($paymentDetails['error'])) {
            return back()->with('error', $paymentDetails['error']);
        }

        // Create withdrawal request
        $withdrawal = Withdrawal::createRequest(
            $seller->id,
            $request->amount,
            $request->method,
            $paymentDetails,
            $request->notes
        );

        return redirect()->route('seller.earnings')
            ->with('success', "Withdrawal request for \${$request->amount} has been submitted successfully. We'll process it within 2-5 business days.");
    }

    /**
     * Validate payment method and return payment details
     * Note: PayPal is not currently supported - only Stripe and Bank Transfer
     */
    private function validatePaymentMethod($seller, $method)
    {
        switch ($method) {
            case 'stripe':
                if (empty($seller->stripe_account_id) || !$seller->stripe_payouts_enabled) {
                    return ['error' => 'Please connect your Stripe account first to receive payments via Stripe.'];
                }
                return ['stripe_account_id' => $seller->stripe_account_id];

            case 'bank_transfer':
                if (empty($seller->bank_details)) {
                    return ['error' => 'Please add your bank account details first.'];
                }
                return json_decode($seller->bank_details, true) ?? [];

            default:
                return ['error' => 'Invalid withdrawal method.'];
        }
    }

    /**
     * Cancel a pending withdrawal request
     */
    public function cancel(Request $request, $id)
    {
        $this->checkFeatureEnabled();

        if ($redirect = $this->checkSellerAuth()) {
            return $redirect;
        }

        $withdrawal = Withdrawal::where('id', $id)
            ->where('seller_id', Auth::id())
            ->firstOrFail();

        if (!$withdrawal->canBeCancelled()) {
            return back()->with('error', 'This withdrawal request cannot be cancelled.');
        }

        $withdrawal->cancel('Cancelled by seller');

        return back()->with('success', 'Withdrawal request has been cancelled.');
    }

    /**
     * Get withdrawal history
     */
    public function history(Request $request)
    {
        $this->checkFeatureEnabled();

        if ($redirect = $this->checkSellerAuth()) {
            return $redirect;
        }

        $query = Withdrawal::forSeller(Auth::id())
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('method')) {
            $query->where('method', $request->method);
        }

        $withdrawals = $query->paginate(20);

        return view('Teacher-Dashboard.withdrawal-history', compact('withdrawals'));
    }

    /**
     * Update payout settings (bank details)
     */
    public function updatePayoutSettings(Request $request)
    {
        $this->checkFeatureEnabled();

        if ($redirect = $this->checkSellerAuth()) {
            return $redirect;
        }

        $seller = Auth::user();

        $validator = Validator::make($request->all(), [
            'preferred_payout_method' => 'nullable|in:stripe,bank_transfer',
            'bank_name' => 'nullable|string|max:255',
            'account_holder_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:50',
            'routing_number' => 'nullable|string|max:50',
            'swift_code' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Update preferred method
        if ($request->filled('preferred_payout_method')) {
            $seller->preferred_payout_method = $request->preferred_payout_method;
        }

        // Update bank details (store as JSON)
        if ($request->filled('bank_name') || $request->filled('account_number')) {
            $bankDetails = [
                'bank_name' => $request->bank_name,
                'account_holder_name' => $request->account_holder_name,
                'account_number' => $request->account_number ? substr($request->account_number, 0, 4) . '****' . substr($request->account_number, -4) : null,
                'routing_number' => $request->routing_number,
                'swift_code' => $request->swift_code,
                // Store full account number encrypted for admin use
                'full_account_number_encrypted' => encrypt($request->account_number),
            ];
            $seller->bank_details = json_encode($bankDetails);
        }

        $seller->save();

        return back()->with('success', 'Payout settings updated successfully.');
    }
}
