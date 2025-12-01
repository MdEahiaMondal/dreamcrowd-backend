<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_currency_id',
        'to_currency_id',
        'rate',
        'is_active',
    ];

    protected $casts = [
        'rate' => 'decimal:6',
        'is_active' => 'boolean',
    ];

    /**
     * Get the source currency
     */
    public function fromCurrency()
    {
        return $this->belongsTo(Currency::class, 'from_currency_id');
    }

    /**
     * Get the target currency
     */
    public function toCurrency()
    {
        return $this->belongsTo(Currency::class, 'to_currency_id');
    }

    /**
     * Get exchange rate between two currencies
     */
    public static function getRate(string $fromCode, string $toCode): float
    {
        if ($fromCode === $toCode) {
            return 1.0;
        }

        $from = Currency::where('code', $fromCode)->first();
        $to = Currency::where('code', $toCode)->first();

        if (!$from || !$to) {
            return 1.0;
        }

        $rate = static::where('from_currency_id', $from->id)
            ->where('to_currency_id', $to->id)
            ->where('is_active', true)
            ->first();

        return $rate ? (float) $rate->rate : 1.0;
    }

    /**
     * Update or create exchange rate
     */
    public static function setRate(string $fromCode, string $toCode, float $rate): ?self
    {
        $from = Currency::where('code', $fromCode)->first();
        $to = Currency::where('code', $toCode)->first();

        if (!$from || !$to) {
            return null;
        }

        return static::updateOrCreate(
            [
                'from_currency_id' => $from->id,
                'to_currency_id' => $to->id,
            ],
            [
                'rate' => $rate,
                'is_active' => true,
            ]
        );
    }
}
