<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUsDynamic extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_1',
        'image_heading',
        'cover_image_1',
        'about',
        'section_1',
        'cover_image_2',
        'tag_line',
        'heading_1',
        'details_1',
        'heading_2',
        'details_2',
        'heading_3',
        'details_3',
    ];
}
