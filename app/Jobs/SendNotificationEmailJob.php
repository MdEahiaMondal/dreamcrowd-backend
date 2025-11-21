<?php

namespace App\Jobs;

use App\Mail\NotificationMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendNotificationEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 60;

    /**
     * User ID to send email to
     */
    protected $userId;

    /**
     * Email data
     */
    protected $emailData;

    /**
     * Notification ID for logging
     */
    protected $notificationId;

    /**
     * Create a new job instance.
     *
     * @param int $userId
     * @param array $emailData
     * @param int|null $notificationId
     */
    public function __construct(int $userId, array $emailData, ?int $notificationId = null)
    {
        $this->userId = $userId;
        $this->emailData = $emailData;
        $this->notificationId = $notificationId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $user = User::find($this->userId);

            if (!$user || !$user->email) {
                Log::warning('User not found or has no email', [
                    'user_id' => $this->userId,
                    'notification_id' => $this->notificationId
                ]);
                return;
            }

            Mail::to($user->email)->send(new NotificationMail($this->emailData));

            Log::info('Notification email sent successfully', [
                'user_id' => $this->userId,
                'email' => $user->email,
                'notification_id' => $this->notificationId,
                'title' => $this->emailData['title'] ?? 'N/A'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send notification email', [
                'user_id' => $this->userId,
                'notification_id' => $this->notificationId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Re-throw to trigger retry mechanism
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('SendNotificationEmailJob failed after all retries', [
            'user_id' => $this->userId,
            'notification_id' => $this->notificationId,
            'error' => $exception->getMessage()
        ]);
    }
}
