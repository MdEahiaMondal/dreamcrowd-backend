<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicesFaqs extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'gig_id',
        'question',
        'answer',
    ];
}
