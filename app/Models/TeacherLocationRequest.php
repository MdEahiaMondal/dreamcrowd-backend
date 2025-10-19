<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherLocationRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'request_id',
        'street_address',
        'latitude',
        'longitude',
        'ip_address',
        'country',
        'country_code',
        'city',
        'zip_code',
        'reason',
    ];
    public $timestamps = false;
}
