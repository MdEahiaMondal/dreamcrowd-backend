<?php

namespace App\Http\Controllers;

use App\Models\BookOrder;
use App\Models\CustomOffer;
use App\Models\CustomOfferMilestone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomOfferMilestoneController extends Controller
{
    /**
     * Get milestones for an order (buyer & seller)
     */
    public function getMilestones($orderId)
    {
        $order = BookOrder::with(['customOffer.milestones'])->findOrFail($orderId);

        // Verify user is either buyer or seller
        $user = Auth::user();
        if ($order->user_id !== $user->id && $order->teacher_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if (!$order->customOffer) {
            return response()->json(['error' => 'This order does not have a custom offer'], 404);
        }

        $milestones = $order->customOffer->milestones->map(function ($milestone) {
            return [
                'id' => $milestone->id,
                'title' => $milestone->title,
                'description' => $milestone->description,
                'date' => $milestone->date ? $milestone->date->format('Y-m-d') : null,
                'start_time' => $milestone->start_time,
                'end_time' => $milestone->end_time,
                'price' => $milestone->price,
                'revisions' => $milestone->revisions,
                'revisions_used' => $milestone->revisions_used,
                'delivery_days' => $milestone->delivery_days,
                'status' => $milestone->status,
                'started_at' => $milestone->started_at,
                'delivered_at' => $milestone->delivered_at,
                'completed_at' => $milestone->completed_at,
                'released_at' => $milestone->released_at,
                'delivery_note' => $milestone->delivery_note,
                'revision_note' => $milestone->revision_note,
                'can_request_revision' => $milestone->canRequestRevision(),
            ];
        });

        $completedCount = $order->customOffer->milestones
            ->whereIn('status', ['completed', 'released'])->count();
        $totalCount = $order->customOffer->milestones->count();
        $progressPercent = $totalCount > 0 ? round(($completedCount / $totalCount) * 100) : 0;

        return response()->json([
            'success' => true,
            'milestones' => $milestones,
            'completed_count' => $completedCount,
            'total_count' => $totalCount,
            'progress_percent' => $progressPercent,
        ]);
    }

    /**
     * Seller: Mark milestone as started
     */
    public function startMilestone($milestoneId)
    {
        $milestone = CustomOfferMilestone::with('customOffer')->findOrFail($milestoneId);

        // Verify user is the seller
        $user = Auth::user();
        if ($milestone->customOffer->seller_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized - only seller can start milestones'], 403);
        }

        // Check milestone is in pending status
        if ($milestone->status !== 'pending') {
            return response()->json(['error' => 'Milestone is not in pending status'], 400);
        }

        $milestone->markAsStarted();

        return response()->json([
            'success' => true,
            'message' => 'Milestone started successfully',
            'status' => $milestone->status,
        ]);
    }

    /**
     * Seller: Deliver milestone with note
     */
    public function deliverMilestone(Request $request, $milestoneId)
    {
        $request->validate([
            'delivery_note' => 'nullable|string|max:2000',
        ]);

        $milestone = CustomOfferMilestone::with('customOffer')->findOrFail($milestoneId);

        // Verify user is the seller
        $user = Auth::user();
        if ($milestone->customOffer->seller_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized - only seller can deliver milestones'], 403);
        }

        // Check milestone is in_progress
        if ($milestone->status !== 'in_progress') {
            return response()->json(['error' => 'Milestone must be in progress to deliver'], 400);
        }

        $milestone->markAsDelivered($request->delivery_note);

        return response()->json([
            'success' => true,
            'message' => 'Milestone delivered successfully',
            'status' => $milestone->status,
        ]);
    }

    /**
     * Buyer: Approve/complete milestone
     */
    public function approveMilestone($milestoneId)
    {
        $milestone = CustomOfferMilestone::with('customOffer')->findOrFail($milestoneId);

        // Verify user is the buyer
        $user = Auth::user();
        if ($milestone->customOffer->buyer_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized - only buyer can approve milestones'], 403);
        }

        // Check milestone is delivered
        if ($milestone->status !== 'delivered') {
            return response()->json(['error' => 'Milestone must be delivered before approval'], 400);
        }

        $milestone->markAsCompleted();

        // Check if all milestones are completed
        $offer = $milestone->customOffer;
        $allCompleted = $offer->milestones()
            ->whereNotIn('status', ['completed', 'released'])
            ->count() === 0;

        return response()->json([
            'success' => true,
            'message' => 'Milestone approved successfully',
            'status' => $milestone->status,
            'all_milestones_completed' => $allCompleted,
        ]);
    }

    /**
     * Buyer: Request revision
     */
    public function requestRevision(Request $request, $milestoneId)
    {
        $request->validate([
            'revision_note' => 'required|string|max:2000',
        ]);

        $milestone = CustomOfferMilestone::with('customOffer')->findOrFail($milestoneId);

        // Verify user is the buyer
        $user = Auth::user();
        if ($milestone->customOffer->buyer_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized - only buyer can request revisions'], 403);
        }

        // Check milestone is delivered
        if ($milestone->status !== 'delivered') {
            return response()->json(['error' => 'Milestone must be delivered to request revision'], 400);
        }

        // Check if revisions available
        if (!$milestone->canRequestRevision()) {
            return response()->json(['error' => 'No revisions remaining for this milestone'], 400);
        }

        $success = $milestone->requestRevision($request->revision_note);

        if (!$success) {
            return response()->json(['error' => 'Failed to request revision'], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Revision requested successfully',
            'status' => $milestone->status,
            'revisions_remaining' => $milestone->revisions - $milestone->revisions_used,
        ]);
    }
}
