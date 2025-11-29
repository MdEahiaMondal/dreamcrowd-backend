<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\TeacherGig;
use App\Models\User;
use Carbon\Carbon;
use App\Services\NotificationService;

class UpdateTeacherGigStatus extends Command
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        parent::__construct();
        $this->notificationService = $notificationService;
    }
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
    // First, fetch gigs that will be ended
    $gigsToEnd = DB::table('teacher_gigs')
        ->join('teacher_gig_payments', 'teacher_gigs.id', '=', 'teacher_gig_payments.gig_id')
        ->whereNotNull('teacher_gig_payments.start_date')
        ->whereNotNull('teacher_gig_payments.start_time')
        ->whereNotNull('teacher_gig_payments.end_time')
        ->where('teacher_gigs.status', 1) // Only active gigs
        ->whereRaw("STR_TO_DATE(CONCAT(teacher_gig_payments.start_date, ' ', teacher_gig_payments.end_time), '%Y-%m-%d %H:%i:%s') < ?", [$currentDateTime])
        ->select('teacher_gigs.id', 'teacher_gigs.user_id', 'teacher_gigs.title')
        ->get();

    // Update status
    DB::table('teacher_gigs')
        ->join('teacher_gig_payments', 'teacher_gigs.id', '=', 'teacher_gig_payments.gig_id')
        ->whereNotNull('teacher_gig_payments.start_date')
        ->whereNotNull('teacher_gig_payments.start_time')
        ->whereNotNull('teacher_gig_payments.end_time')
        ->where('teacher_gigs.status', 1) // Only active gigs
        ->whereRaw("STR_TO_DATE(CONCAT(teacher_gig_payments.start_date, ' ', teacher_gig_payments.end_time), '%Y-%m-%d %H:%i:%s') < ?", [$currentDateTime])
        ->update(['teacher_gigs.status' => 2]);

    // Send notifications to sellers
    foreach ($gigsToEnd as $gig) {
        try {
            $this->notificationService->send(
                userId: $gig->user_id,
                type: 'gig',
                title: 'Service Ended',
                message: 'Your service "' . $gig->title . '" has ended and is no longer available for booking.',
                data: ['gig_id' => $gig->id, 'gig_title' => $gig->title, 'status' => 'ended'],
                sendEmail: false,
                actorUserId: $gig->user_id,
                targetUserId: $gig->user_id,
                serviceId: $gig->id
            );
            \Log::info("Gig ended notification sent to user #{$gig->user_id} for gig #{$gig->id}");
        } catch (\Exception $e) {
            \Log::error("Failed to send gig ended notification: " . $e->getMessage());
        }
    }

    $this->info('TeacherGig statuses updated successfully. ' . count($gigsToEnd) . ' services ended.');
}
}
