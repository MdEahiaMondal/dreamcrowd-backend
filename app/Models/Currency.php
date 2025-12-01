<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'symbol',
        'symbol_position',
        'decimal_places',
        'is_default',
        'is_active',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_active' => 'boolean',
        'decimal_places' => 'integer',
    ];

    /**
     * Get the default currency (USD)
     */
    public static function getDefault()
    {
        return static::where('is_default', true)->first()
            ?? static::where('code', 'USD')->first();
    }

    /**
     * Get all active currencies
     */
    public static function getActive()
    {
        return static::where('is_active', true)->get();
    }

    /**
     * Get currency by code
     */
    public static function findByCode(string $code)
    {
        return static::where('code', strtoupper($code))->first();
    }

    /**
     * Exchange rates from this currency
     */
    public function ratesFrom()
    {
        return $this->hasMany(ExchangeRate::class, 'from_currency_id');
    }

    /**
     * Exchange rates to this currency
     */
    public function ratesTo()
    {
        return $this->hasMany(ExchangeRate::class, 'to_currency_id');
    }
}
