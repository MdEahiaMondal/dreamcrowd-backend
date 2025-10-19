<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'facebook_link',
        'facebook_status',
        'insta_link',
        'insta_status',
        'twitter_link',
        'twitter_status',
        'youtube_link',
        'youtube_status',
        'tiktok_link',
        'tiktok_status',
    ];
}
