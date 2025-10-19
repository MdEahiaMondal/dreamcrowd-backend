<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeleteAccounts extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_email',
        'reason',
        'additional_reason',
    ];

}
