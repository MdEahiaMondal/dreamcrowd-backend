<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BecomeExpert extends Model
{
    use HasFactory;

    protected $fillable = [
        'hero_heading',
        'hero_description',
        'hero_btn_link',
        'hero_image',
        'work_heading_1',
        'work_detail_1',
        'work_image_1',
        'work_heading_2',
        'work_detail_2',
        'work_image_2',
        'work_heading_3',
        'work_detail_3',
        'work_image_3',
        'host_heading',
        'host_description',
        'host_image_1',
        'host_image_2',
        'host_image_3',
        'host_image_4',
        'feature_heading',
        'banner_heading',
        'banner_btn_link',
        'expert_heading',
        'expert_btn_link',
        'expert_image',
        'faqs',
        'verification_center',
    ];

}
