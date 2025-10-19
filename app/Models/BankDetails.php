<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bank_name',
        'holder_name',
        'iban',
        'card_number',
        'cvv',
        'expiry_date',
    ];
}
