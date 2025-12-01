<?php

namespace App\Http\Controllers;

use App\Jobs\UpdateExchangeRates;
use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class CurrencyController extends Controller
{
    /**
     * Set user's display currency preference
     */
    public function setCurrency(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'currency' => 'required|string|in:USD,GBP',
        ]);

        CurrencyService::setDisplayCurrency($validated['currency']);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'currency' => $validated['currency'],
                'symbol' => CurrencyService::symbol($validated['currency']),
                'message' => 'Currency updated to ' . $validated['currency'],
            ]);
        }

        return back()->with('success', 'Currency updated to ' . $validated['currency']);
    }

    /**
     * Get current currency info
     */
    public function getCurrency(): JsonResponse
    {
        $currency = CurrencyService::getDisplayCurrency();

        return response()->json([
            'success' => true,
            'currency' => $currency,
            'symbol' => CurrencyService::symbol($currency),
            'available' => CurrencyService::getActiveCurrencies(),
            'rates' => CurrencyService::getRatesInfo(),
        ]);
    }

    /**
     * Get exchange rates
     */
    public function getRates(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'rates' => CurrencyService::getRatesInfo(),
        ]);
    }

    /**
     * Get JavaScript configuration for client-side formatting
     */
    public function getJsConfig(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'config' => CurrencyService::getJsConfig(),
        ]);
    }

    /**
     * Manually trigger exchange rate update (Admin only)
     */
    public function updateRates(Request $request): JsonResponse|RedirectResponse
    {
        // Check if user is admin
        if (!auth()->check() || auth()->user()->role !== 2) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
            return back()->with('error', 'Unauthorized');
        }

        // Dispatch the job
        UpdateExchangeRates::dispatch();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Exchange rate update job dispatched successfully.',
            ]);
        }

        return back()->with('success', 'Exchange rate update job dispatched successfully.');
    }

    /**
     * Convert amount API endpoint
     */
    public function convert(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'from' => 'required|string|in:USD,GBP',
            'to' => 'required|string|in:USD,GBP',
        ]);

        $converted = CurrencyService::convert(
            (float) $validated['amount'],
            $validated['from'],
            $validated['to']
        );

        return response()->json([
            'success' => true,
            'original' => [
                'amount' => $validated['amount'],
                'currency' => $validated['from'],
                'formatted' => CurrencyService::formatRaw($validated['amount'], $validated['from']),
            ],
            'converted' => [
                'amount' => $converted,
                'currency' => $validated['to'],
                'formatted' => CurrencyService::formatRaw($converted, $validated['to']),
            ],
            'rate' => CurrencyService::getRate($validated['from'], $validated['to']),
        ]);
    }
}
