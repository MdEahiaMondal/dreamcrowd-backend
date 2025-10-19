<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpertProfile extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'user_id',
        'profile_image',
        'first_name',
        'last_name',
        'show_full_name',
        'gender',
        'profession',
        'service_role',
        'service_type',
        'first_service',
        'latitude',
        'longitude',
        'street_address',
        'ip_address',
        'country',
        'country_code',
        'city',
        'zip_code',
        'category_class',
        'sub_category_class',
        'positive_search_class',
        'category_freelance',
        'sub_category_freelance',
        'positive_search_freelance',
        'experience',
        'experience_graphic',
        'experience_web',
        'portfolio',
        'portfolio_url',
        'primary_language',
        'fluent_english',
        'speak_other_language',
        'fluent_other_language',
        'overview',
        'about_me',
        'main_image',
        'more_image_1',
        'more_image_2',
        'more_image_3',
        'more_image_4',
        'more_image_5',
        'more_image_6',
        'video',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
        'app_date',
        'action_date',
        'app_type',
        'status',
    ];


}
