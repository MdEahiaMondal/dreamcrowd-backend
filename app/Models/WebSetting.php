<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'classes_expert',
        'remote_expert',
        'commission_rate',
        'currency',
        'meta_description',
    ];

}
