<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherGig extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'service_role',
        'service_type',
        'main_file',
        'category',
        'category_name',
        'sub_category',
        'rate',
        'public_rate',
        'private_rate',
        'payment_type',
        'freelance_type',
        'freelance_service',
        'class_type',
        'lesson_type',
        'delivery_time',
        'revision',
        'full_available',
        'start_date',
        'start_time',
        'impressions',
        'clicks',
        'cancelation',
        'orders',
        'reviews',
        'status',
        'meeting_platform',
        'trial_type',
    ];


    public function repeatDays() {
        return $this->hasMany(TeacherReapetDays::class, 'gig_id');
    }

   public function all_reviews() {
        return $this->hasMany(ServiceReviews::class, 'gig_id')->with('replies');
    }


}
