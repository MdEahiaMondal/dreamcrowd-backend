<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherGigData extends Model
{
    use HasFactory;
    protected $fillable = [
        'gig_id',
        'category',
        'sub_category',
        'experience_level',
        'class_type',
        'lesson_type',
        'freelance_type',
        'freelance_service',
        'video_call',
        'max_distance',
        'title',
        'description',
        'requirements',
        'main_file',
        'other',
        'video',
        'course',
        'resource',
        'payment_type',
        'recurring_type',
        'group_type',
        'service_delivery',
        'work_site',
        'meeting_platform',
        'trial_type',
    ];
}
