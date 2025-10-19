<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\TeacherGig;
use Carbon\Carbon;

class UpdateTeacherGigStatus extends Command
{
    // Command signature for Artisan
    protected $signature = 'update:teacher-gig-status';
    protected $description = 'Automatically update TeacherGig statuses based on start and end dates';

    // Command logic
    public function handle()
{
    // Get the current date
    $currentDate = Carbon::today();
    $currentDateTime = Carbon::now()->format('Y-m-d H:i:s');
    // Activate service for today only
    // DB::table('teacher_gigs')
    //     ->join('teacher_gig_payments', 'teacher_gigs.id', '=', 'teacher_gig_payments.gig_id')
    //     ->where('teacher_gig_payments.start_date', '=', $currentDate) // Activate today only
    //     ->whereNotIn('teacher_gigs.status', [1, 4, 0]) // Skip already active, pending, or disabled gigs
    //     ->update(['teacher_gigs.status' => 1]);

    // End service where start_date has passed
   DB::table('teacher_gigs')
    ->join('teacher_gig_payments', 'teacher_gigs.id', '=', 'teacher_gig_payments.gig_id')
    ->whereNotNull('teacher_gig_payments.start_date')
    ->whereNotNull('teacher_gig_payments.start_time')
    ->whereNotNull('teacher_gig_payments.end_time')
    ->where('teacher_gigs.status', 1) // Only active gigs
    ->whereRaw("STR_TO_DATE(CONCAT(teacher_gig_payments.start_date, ' ', teacher_gig_payments.end_time), '%Y-%m-%d %H:%i:%s') < ?", [$currentDateTime])
    ->update(['teacher_gigs.status' => 2]);

    $this->info('TeacherGig statuses updated successfully.');
}
}
