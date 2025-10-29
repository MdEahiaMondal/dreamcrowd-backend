<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CommissionReportExport;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TopSellerTag;
use App\Models\SellerCommission;
use App\Models\ServiceCommission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CommissionController extends Controller
{
    public function AdmincheckAuth()
    {
        if (!Auth::user()) {
            return redirect()->to('/')->with('error', 'Please LoginIn to Your Account!');
        } else {
            if (Auth::user()->role == 0) {
                return redirect()->to('/user-dashboard');
            } elseif (Auth::user()->role == 1) {
                return redirect()->to('/teacher-dashboard');
            }
        }
    }

    // Main commission settings page
    public function AdminCommissionSet()
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        $tag = TopSellerTag::first();

        if (!$tag) {
            $tag = TopSellerTag::create([
                'commission' => 15,
                'buyer_commission' => 0,
                'buyer_commission_rate' => 0,
                'commission_type' => 'seller',
                'currency' => 'USD',
                'stripe_currency' => 'GBP',
                'is_active' => 1,
                'enable_custom_seller_commission' => 0,
                'enable_custom_service_commission' => 0,
                'earning' => 0,
                'booking' => 0,
                'review' => 0,
                'sorting_impressions' => 0,
                'sorting_clicks' => 0,
                'sorting_orders' => 0,
                'sorting_reviews' => 0,
            ]);
        }

        // Get counts for custom commissions
        $customSellersCount = SellerCommission::where('is_active', 1)->count();
        $customServicesCount = ServiceCommission::where('is_active', 1)->count();

        return view('Admin-Dashboard.CommissionSet', compact('tag', 'customSellersCount', 'customServicesCount'));
    }

    // Update default seller commission
    public function UpdateCommissionRate(Request $request)
    {
        $request->validate([
            'commission' => 'required|numeric|min:5|max:30',
        ]);

        try {
            $tag = TopSellerTag::first();

            if (!$tag) {
                $tag = new TopSellerTag();
                $tag->commission_type = 'seller';
                $tag->currency = 'USD';
                $tag->stripe_currency = 'GBP';
                $tag->is_active = 1;
            }

            $oldCommission = $tag->commission;
            $tag->commission = $request->commission;
            $tag->save();

            \Log::info('Default commission rate updated', [
                'old_rate' => $oldCommission,
                'new_rate' => $tag->commission,
                'admin_id' => auth()->id()
            ]);

            return redirect()->back()->with('success', 'Default seller commission updated to ' . $tag->commission . '%');

        } catch (\Exception $e) {
            \Log::error('Commission update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update commission rate.');
        }
    }

    // Update buyer commission
    public function UpdateBuyerCommissionRate(Request $request)
    {
        $rules = ['buyer_commission' => 'required|in:0,1'];

        if ($request->buyer_commission == 1) {
            $rules['buyer_commission_rate'] = 'required|numeric|min:1|max:15';
        }

        $request->validate($rules);

        try {
            $tag = TopSellerTag::first();

            if (!$tag) {
                $tag = new TopSellerTag();
                $tag->commission = 15;
                $tag->currency = 'USD';
                $tag->stripe_currency = 'GBP';
                $tag->is_active = 1;
            }

            $tag->buyer_commission = $request->buyer_commission;
            $tag->buyer_commission_rate = $request->buyer_commission == 1 ? $request->buyer_commission_rate : 0;

            if ($tag->buyer_commission == 1) {
                $tag->commission_type = 'both';
            } else {
                $tag->commission_type = 'seller';
            }

            $tag->save();

            $message = $request->buyer_commission == 1
                ? 'Buyer commission enabled at ' . $tag->buyer_commission_rate . '%'
                : 'Buyer commission disabled';

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('Buyer commission update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update buyer commission.');
        }
    }

    // Toggle custom seller commission feature
    public function ToggleCustomSellerCommission(Request $request)
    {
        try {
            $tag = TopSellerTag::first();
            $tag->enable_custom_seller_commission = $request->enable ? 1 : 0;
            $tag->save();

            $message = $request->enable
                ? 'Custom seller commission feature enabled'
                : 'Custom seller commission feature disabled';

            return response()->json(['success' => true, 'message' => $message]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to toggle feature']);
        }
    }

    // Toggle custom service commission feature
    public function ToggleCustomServiceCommission(Request $request)
    {
        try {
            $tag = TopSellerTag::first();
            $tag->enable_custom_service_commission = $request->enable ? 1 : 0;
            $tag->save();

            $message = $request->enable
                ? 'Custom service commission feature enabled'
                : 'Custom service commission feature disabled';

            return response()->json(['success' => true, 'message' => $message]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to toggle feature']);
        }
    }

    // Manage custom seller commissions page
    public function ManageSellerCommissions()
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        $sellers = User::where('role', 1)->get(); // Adjust based on your user roles
        $sellerCommissions = SellerCommission::with('seller')->paginate(20);
        $defaultRate = TopSellerTag::first()->commission ?? 15;

        return view('Admin-Dashboard.SellerCommissions', compact('sellers', 'sellerCommissions', 'defaultRate'));
    }

    // Manage custom service commissions page
    public function ManageServiceCommissions()
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        // Get your services/classes - adjust table name
        // $services = Service::all();
        $serviceCommissions = ServiceCommission::paginate(20);
        $defaultRate = TopSellerTag::first()->commission ?? 15;

        return view('Admin-Dashboard.ServiceCommissions', compact('serviceCommissions', 'defaultRate'));
    }

    // Update currency settings
    public function UpdateCurrencySettings(Request $request)
    {
        $request->validate([
            'currency' => 'required|in:USD,GBP,EUR',
            'stripe_currency' => 'required|in:USD,GBP,EUR',
        ]);

        try {
            $tag = TopSellerTag::first();
            $tag->currency = $request->currency;
            $tag->stripe_currency = $request->stripe_currency;
            $tag->save();

            return redirect()->back()->with('success', 'Currency settings updated successfully');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update currency settings');
        }
    }

    // ============ SELLER COMMISSION CRUD ============

    public function StoreSellerCommission(Request $request)
    {
        $request->validate([
            'seller_id' => 'required|exists:users,id|unique:seller_commissions,seller_id',
            'commission_rate' => 'required|numeric|min:5|max:30',
            'notes' => 'nullable|string|max:255',
        ]);

        try {
            SellerCommission::create([
                'seller_id' => $request->seller_id,
                'commission_rate' => $request->commission_rate,
                'is_active' => 1,
                'notes' => $request->notes,
            ]);

            return redirect()->back()->with('success', 'Custom seller commission added successfully!');

        } catch (\Exception $e) {
            \Log::error('Seller commission creation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add seller commission.');
        }
    }

    public function UpdateSellerCommission(Request $request, $id)
    {
        $request->validate([
            'commission_rate' => 'required|numeric|min:5|max:30',
            'is_active' => 'required|in:0,1',
            'notes' => 'nullable|string|max:255',
        ]);

        try {
            $commission = SellerCommission::findOrFail($id);
            $commission->update([
                'commission_rate' => $request->commission_rate,
                'is_active' => $request->is_active,
                'notes' => $request->notes,
            ]);

            return redirect()->back()->with('success', 'Seller commission updated successfully!');

        } catch (\Exception $e) {
            \Log::error('Seller commission update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update seller commission.');
        }
    }

    public function DeleteSellerCommission($id)
    {
        try {
            $commission = SellerCommission::findOrFail($id);
            $commission->delete();

            return redirect()->back()->with('success', 'Seller commission deleted successfully!');

        } catch (\Exception $e) {
            \Log::error('Seller commission deletion failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete seller commission.');
        }
    }

// ============ SERVICE COMMISSION CRUD ============

    public function StoreServiceCommission(Request $request)
    {
        $request->validate([
            'service_id' => 'required|integer',
            'service_type' => 'required|in:Inperson,Online',
            'commission_rate' => 'required|numeric|min:5|max:30',
            'notes' => 'nullable|string|max:255',
        ]);

        try {
            // Check if service commission already exists
            $exists = ServiceCommission::where('service_id', $request->service_id)
                ->where('service_type', $request->service_type)
                ->exists();

            if ($exists) {
                return redirect()->back()->with('error', 'Commission for this service/class already exists!');
            }

            ServiceCommission::create([
                'service_id' => $request->service_id,
                'service_type' => $request->service_type,
                'commission_rate' => $request->commission_rate,
                'is_active' => 1,
                'notes' => $request->notes,
            ]);

            return redirect()->back()->with('success', 'Custom service commission added successfully!');

        } catch (\Exception $e) {
            \Log::error('Service commission creation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add service commission.');
        }
    }

    public function UpdateServiceCommission(Request $request, $id)
    {
        $request->validate([
            'commission_rate' => 'required|numeric|min:5|max:30',
            'is_active' => 'required|in:0,1',
            'notes' => 'nullable|string|max:255',
        ]);

        try {
            $commission = ServiceCommission::findOrFail($id);
            $commission->update([
                'commission_rate' => $request->commission_rate,
                'is_active' => $request->is_active,
                'notes' => $request->notes,
            ]);

            return redirect()->back()->with('success', 'Service commission updated successfully!');

        } catch (\Exception $e) {
            \Log::error('Service commission update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update service commission.');
        }
    }

    public function DeleteServiceCommission($id)
    {
        try {
            $commission = ServiceCommission::findOrFail($id);
            $commission->delete();

            return redirect()->back()->with('success', 'Service commission deleted successfully!');

        } catch (\Exception $e) {
            \Log::error('Service commission deletion failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete service commission.');
        }
    }

    public function CommissionReport(Request $request)
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        // Base query
        $query = Transaction::with(['buyer', 'seller']);

        // Apply filters
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Get transactions
        $transactions = $query->orderBy('created_at', 'desc')->paginate(20);

        // Calculate statistics
        $totalEarnings = Transaction::where('status', 'completed')->sum('total_admin_commission');
        $todayEarnings = Transaction::where('status', 'completed')
            ->whereDate('created_at', today())
            ->sum('total_admin_commission');
        $todayTransactions = Transaction::whereDate('created_at', today())->count();

        $monthlyEarnings = Transaction::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_admin_commission');
        $monthlyTransactions = Transaction::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $pendingPayouts = Transaction::where('payout_status', 'pending')
            ->sum('seller_earnings');
        $pendingCount = Transaction::where('payout_status', 'pending')->count();

        // Top earning seller
        $topSeller = Transaction::select('seller_id', \DB::raw('SUM(seller_earnings) as total'))
            ->where('status', 'completed')
            ->groupBy('seller_id')
            ->orderBy('total', 'desc')
            ->with('seller')
            ->first();

        $topSellerEarnings = $topSeller->total ?? 0;
        $topSeller = $topSeller->seller ?? null;

        return view('Admin-Dashboard.CommissionReport', compact(
            'transactions',
            'totalEarnings',
            'todayEarnings',
            'todayTransactions',
            'monthlyEarnings',
            'monthlyTransactions',
            'pendingPayouts',
            'pendingCount',
            'topSeller',
            'topSellerEarnings'
        ));
    }


    /**
     * View transaction details
     */
    public function TransactionDetails($id)
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        $transaction = Transaction::with(['seller', 'buyer'])->findOrFail($id);

        return view('Admin-Dashboard.TransactionDetails', compact('transaction'));
    }

    /**
     * Mark payout as completed
     */
    public function MarkPayoutCompleted(Request $request, $id)
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        try {
            $transaction = Transaction::findOrFail($id);

            if ($transaction->payout_status == 'paid') {
                return redirect()->back()->with('error', 'Payout already completed!');
            }

            $transaction->markPayoutCompleted($request->stripe_payout_id);

            return redirect()->back()->with('success', 'Payout marked as completed successfully!');

        } catch (\Exception $e) {
            \Log::error('Payout completion failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to mark payout as completed.');
        }
    }

    /**
     * Process refund
     */
    public function ProcessRefund(Request $request, $id)
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        $request->validate([
            'refund_reason' => 'required|string|max:500',
        ]);

        try {
            $transaction = Transaction::findOrFail($id);

            if ($transaction->status == 'refunded') {
                return redirect()->back()->with('error', 'Transaction already refunded!');
            }

            // Mark transaction as refunded
            $transaction->markAsRefunded();

            // Add refund reason to notes
            $transaction->notes = ($transaction->notes ? $transaction->notes . "\n\n" : '') .
                "REFUND: " . $request->refund_reason . " (Processed on " . now()->format('d M Y H:i') . ")";
            $transaction->save();

            // TODO: Process actual Stripe refund here
            // \Stripe\Refund::create([
            //     'charge' => $transaction->stripe_transaction_id,
            // ]);

            \Log::info('Transaction refunded', [
                'transaction_id' => $id,
                'amount' => $transaction->total_amount,
                'reason' => $request->refund_reason,
                'admin_id' => auth()->id()
            ]);

            return redirect()->back()->with('success', 'Transaction refunded successfully!');

        } catch (\Exception $e) {
            \Log::error('Refund processing failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to process refund: ' . $e->getMessage());
        }
    }


    public function ExportCSV(Request $request)
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        try {
            // Get transactions with filters
            $query = Transaction::with(['buyer', 'seller']);

            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            $transactions = $query->orderBy('created_at', 'desc')->get();

            // Create CSV
            $filename = 'commission_report_' . date('Y-m-d_His') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function () use ($transactions) {
                $file = fopen('php://output', 'w');

                // Add CSV headers
                fputcsv($file, [
                    'Transaction ID',
                    'Date',
                    'Buyer Name',
                    'Buyer Email',
                    'Seller Name',
                    'Seller Email',
                    'Service Type',
                    'Service ID',
                    'Total Amount',
                    'Currency',
                    'Commission Rate (%)',
                    'Admin Commission',
                    'Seller Earnings',
                    'Status',
                    'Payout Status',
                    'Stripe Transaction ID',
                    'Paid At',
                    'Payout At',
                ]);

                // Add transaction data
                foreach ($transactions as $transaction) {
                    fputcsv($file, [
                        $transaction->id,
                        $transaction->created_at->format('Y-m-d H:i:s'),
                        $transaction->buyer->name ?? 'N/A',
                        $transaction->buyer->email ?? 'N/A',
                        $transaction->seller->name ?? 'N/A',
                        $transaction->seller->email ?? 'N/A',
                        ucfirst($transaction->service_type),
                        $transaction->service_id,
                        number_format($transaction->total_amount, 2),
                        $transaction->currency,
                        $transaction->seller_commission_rate,
                        number_format($transaction->total_admin_commission, 2),
                        number_format($transaction->seller_earnings, 2),
                        ucfirst($transaction->status),
                        ucfirst($transaction->payout_status),
                        $transaction->stripe_transaction_id ?? 'N/A',
                        $transaction->paid_at ? $transaction->paid_at->format('Y-m-d H:i:s') : 'N/A',
                        $transaction->payout_at ? $transaction->payout_at->format('Y-m-d H:i:s') : 'N/A',
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);

        } catch (\Exception $e) {
            \Log::error('CSV export failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to export CSV.');
        }
    }


    public function ExportPDF(Request $request)
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        try {
            // Get transactions with filters
            $query = Transaction::with(['buyer', 'seller']);

            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            $transactions = $query->orderBy('created_at', 'desc')->get();

            // Calculate totals
            $totalAmount = $transactions->sum('total_amount');
            $totalCommission = $transactions->sum('total_admin_commission');
            $totalSellerEarnings = $transactions->sum('seller_earnings');

            $data = [
                'transactions' => $transactions,
                'totalAmount' => $totalAmount,
                'totalCommission' => $totalCommission,
                'totalSellerEarnings' => $totalSellerEarnings,
                'exportDate' => now()->format('d M Y H:i:s'),
                'dateRange' => [
                    'from' => $request->date_from,
                    'to' => $request->date_to,
                ],
            ];

            $pdf = \PDF::loadView('Admin-Dashboard.CommissionReportPDF', $data);

            $filename = 'commission_report_' . date('Y-m-d_His') . '.pdf';

            return $pdf->download($filename);

        } catch (\Exception $e) {
            \Log::error('PDF export failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to export PDF.');
        }
    }

    public function ExportExcel(Request $request)
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        try {
            $filename = 'commission_report_' . date('Y-m-d_His') . '.xlsx';

            return \Excel::download(new CommissionReportExport($request->all()), $filename);

        } catch (\Exception $e) {
            \Log::error('Excel export failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to export Excel.');
        }
    }


    /**
     * Print receipt for transaction
     */
    public function PrintReceipt($id)
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        try {
            $transaction = Transaction::with(['buyer', 'seller'])->findOrFail($id);

            return view('Admin-Dashboard.TransactionReceipt', compact('transaction'));

        } catch (\Exception $e) {
            \Log::error('Print receipt failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Transaction not found.');
        }
    }

    /**
     * Download invoice for transaction
     */
    public function DownloadInvoice($id)
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        try {
            $transaction = Transaction::with(['buyer', 'seller'])->findOrFail($id);

            // Get company information from your settings
            // Adjust this based on where you store company info
            $homeSettings = \App\Models\HomeDynamic::first();

            $data = [
                'transaction' => $transaction,
                'companyName' => $homeSettings->company_name ?? 'Dreamcrowd',
                'companyAddress' => $homeSettings->company_address ?? 'Your Company Address, City, Country',
                'companyEmail' => $homeSettings->company_email ?? 'support@dreamcrowd.com',
                'companyPhone' => $homeSettings->company_phone ?? '+1 234 567 8900',
                'invoiceDate' => now()->format('d M Y'),
            ];

            // Generate PDF
            $pdf = \PDF::loadView('Admin-Dashboard.TransactionInvoice', $data);

            // Set paper size and orientation
            $pdf->setPaper('A4', 'portrait');

            $filename = 'invoice_' . str_pad($transaction->id, 6, '0', STR_PAD_LEFT) . '_' . date('Ymd') . '.pdf';

            return $pdf->download($filename);

        } catch (\Exception $e) {
            \Log::error('Download invoice failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to generate invoice: ' . $e->getMessage());
        }
    }

    public function PrintInvoice($id)
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        try {
            $transaction = Transaction::with(['buyer', 'seller'])->findOrFail($id);

            $homeSettings = \App\Models\HomeDynamic::first();

            $data = [
                'transaction' => $transaction,
                'companyName' => $homeSettings->company_name ?? 'Dreamcrowd',
                'companyAddress' => $homeSettings->company_address ?? 'Your Company Address, City, Country',
                'companyEmail' => $homeSettings->company_email ?? 'support@dreamcrowd.com',
                'companyPhone' => $homeSettings->company_phone ?? '+1 234 567 8900',
                'invoiceDate' => now()->format('d M Y'),
            ];

            return view('Admin-Dashboard.TransactionInvoice', $data);

        } catch (\Exception $e) {
            \Log::error('Print invoice failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Transaction not found.');
        }
    }

}
