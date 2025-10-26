<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookOrder extends Model
{
    use HasFactory;

    protected $fillable = [
            'user_id',
            'gig_id',
            'teacher_id',
            'zoom_link',
            'title',
            'frequency',
            'group_type',
            'emails',
            'extra_guests',
            'guests',
            'childs',
            'total_people',
            'service_delivery',
            'work_site',
            'freelance_service',
            'price',
            'buyer_commission',
            'coupen',
            'discount',
            'finel_price',
            'payment_type',
            'payment_id',
            'holder_name',
            'card_number',
            'cvv',
            'date',
            'action_date',
            'teacher_reschedule',
            'user_reschedule',
            'teacher_reschedule_time',
            'user_dispute',
            'teacher_dispute',
            'auto_dispute_processed',
            'refund',
            'start_job',
            'status'
    ];

    public function gig(){
        return $this->belongsTo(TeacherGig::class, 'gig_id');
    }

    public function booker(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
