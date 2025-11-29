<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherGig extends Model
{

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
        'approval_mode',
        'meeting_platform',
        'trial_type',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category');
    }

    public function repeatDays()
    {
        return $this->hasMany(TeacherReapetDays::class, 'gig_id');
    }

    public function all_reviews()
    {
        return $this->hasMany(ServiceReviews::class, 'gig_id')->with('replies');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function expertProfile()
    {
        return $this->hasOne(ExpertProfile::class, 'user_id', 'user_id');
    }

    public function teacherGigData()
    {
        return $this->hasOne(TeacherGigData::class, 'gig_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'service_id');
    }


}
