<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostGuidline extends Model
{
    use HasFactory;

    protected $fillable = [
        'heading',
        'detail',
    ];
}
