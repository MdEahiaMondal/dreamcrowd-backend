<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherProfileRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'request_id',
        'profile_image',
        'first_name',
        'last_name',
        'show_full_name',
        'gender',
        'profession',
        'first_service',
        'primary_language',
        'fluent_english',
        'speak_other_language',
        'other_language',
        'main_image',
        'more_image_1',
        'more_image_2',
        'more_image_3',
        'more_image_4',
        'more_image_5',
        'more_image_6',
        'video',
        'overview',
        'about_me',
    ];
    public $timestamps = false;
}
