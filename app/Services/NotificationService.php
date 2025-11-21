<?php

namespace App\Services;

use App\Models\Notification;
use App\Events\NotificationSent;
use App\Jobs\SendNotificationEmailJob;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Send notification
     *
     * @param int|array $userId Recipient user ID(s)
     * @param string $type Notification type
     * @param string $title Title
     * @param string $message Message
     * @param array $data Additional data
     * @param bool $sendEmail Send email?
     * @param int|null $actorUserId Who did the action
     * @param int|null $targetUserId Who is affected
     * @param int|null $orderId Related order
     * @param int|null $serviceId Related service
     * @param bool $isEmergency Emergency notification?
     * @param int|null $sentByAdminId Admin who sent
     * @param string|null $scheduledAt When to send
     * @return Notification|array|null
     */
    public function send(
        $userId,
        $type,
        $title,
        $message,
        $data = [],
        $sendEmail = true,
        $actorUserId = null,
        $targetUserId = null,
        $orderId = null,
        $serviceId = null,
        $isEmergency = false,
        $sentByAdminId = null,
        $scheduledAt = null
    ) {
        // Handle multiple users
        if (is_array($userId)) {
            $notifications = [];
            foreach ($userId as $singleUserId) {
                $notifications[] = $this->send(
                    $singleUserId,
                    $type,
                    $title,
                    $message,
                    $data,
                    $sendEmail,
                    $actorUserId,
                    $targetUserId?? $singleUserId,
                    $orderId,
                    $serviceId,
                    $isEmergency,
                    $sentByAdminId,
                    $scheduledAt
                );
            }
            return $notifications;
        }

        // Create notification
        $notification = Notification::create([
            'user_id' => $userId,
            'actor_user_id' => $actorUserId,
            'target_user_id' => $targetUserId,
            'order_id' => $orderId,
            'service_id' => $serviceId,
            'type' => $type,
            'is_emergency' => $isEmergency,
            'sent_email' => $sendEmail,
            'title' => $title,
            'message' => $message,
            'data' => is_array($data) ? json_encode($data) : $data,
            'sent_by_admin_id' => $sentByAdminId,
            'scheduled_at' => $scheduledAt
        ]);

        // If scheduled, don't send now
        if ($scheduledAt && strtotime($scheduledAt) > time()) {
            return $notification;
        }

        // Always broadcast to website
        broadcast(new NotificationSent($notification, $userId));

        // Send email if enabled - dispatch to queue for async processing
        if ($sendEmail) {
            $user = \App\Models\User::find($userId);
            if ($user && $user->email) {
                try {
                    // Dispatch email job to queue
                    SendNotificationEmailJob::dispatch(
                        $userId,
                        [
                            'title' => $title,
                            'message' => $message,
                            'data' => is_string($data) ? json_decode($data, true) : $data,
                            'is_emergency' => $isEmergency
                        ],
                        $notification->id
                    );

                    Log::info('Notification email queued', [
                        'notification_id' => $notification->id,
                        'user_id' => $userId,
                        'email' => $user->email
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to queue notification email: ' . $e->getMessage(), [
                        'notification_id' => $notification->id,
                        'user_id' => $userId,
                        'email' => $user->email
                    ]);
                }
            }
        }

        return $notification;
    }

    /**
     * Send to multiple users
     */
    public function sendToMultipleUsers(
        array $userIds,
        $type,
        $title,
        $message,
        $data = [],
        $sendEmail = true,
        $actorUserId = null,
        $targetUserId = null,
        $orderId = null,
        $serviceId = null,
        $isEmergency = false,
        $sentByAdminId = null
    ) {
        return $this->send(
            $userIds,
            $type,
            $title,
            $message,
            $data,
            $sendEmail,
            $actorUserId,
            $targetUserId,
            $orderId,
            $serviceId,
            $isEmergency,
            $sentByAdminId
        );
    }
}