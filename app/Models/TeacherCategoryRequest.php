<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherCategoryRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'request_id',
        'category',
        'sub_category',
        'category_role',
        'portfolio',
        'portfolio_url',
        'certificate',
    ];
    public $timestamps = false;
}
