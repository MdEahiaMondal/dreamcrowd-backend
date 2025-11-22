@extends('emails.layouts.base')

@section('title', 'Order Delivered')

@section('header_title', 'Order Delivered ✓')

@section('content')
    <div class="success-box">
        <p><strong>✓ Your Order Has Been Delivered!</strong></p>
    </div>

    <p class="lead">Hello,</p>

    <p>
        Your service <strong>"{{ $serviceName ?? 'N/A' }}"</strong> has been delivered and is ready for your review.
    </p>

    <div class="info-box">
        <p><strong>Delivery Details:</strong></p>
        <p><strong>Order ID:</strong> #{{ $orderId ?? 'N/A' }}</p>
        <p><strong>Service:</strong> {{ $serviceName ?? 'N/A' }}</p>
        <p><strong>Delivered On:</strong> {{ $deliveryDate ?? now()->format('F j, Y g:i A') }}</p>
    </div>

    <div class="alert-box">
        <p><strong>⏰ Important: 48-Hour Review Window</strong></p>
        <p>
            You have until <strong>{{ $disputeDeadline ?? now()->addHours(48)->format('F j, Y g:i A') }}</strong>
            to review the delivery and report any issues.
        </p>
        <p style="margin-top: 10px;">
            After this time, the order will be automatically marked as completed and payment will be released to the seller.
        </p>
    </div>

    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            <td align="center">
                <a href="{{ url('/user-application-details/' . ($orderId ?? '')) }}" class="btn btn-primary">
                    Review Delivery
                </a>
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    <h3>Next Steps:</h3>
    <ul>
        <li><strong>Review the delivery</strong> to ensure it meets your requirements</li>
        <li><strong>Contact the seller</strong> if you need any clarifications or revisions</li>
        <li><strong>Report any issues</strong> within 48 hours if the delivery doesn't meet expectations</li>
        <li><strong>Leave a review</strong> to help other buyers and support quality sellers</li>
    </ul>

    <p style="color: #777; font-size: 13px; margin-top: 20px;">
        <em>If everything looks good, the order will automatically complete and you can leave a review for the seller.</em>
    </p>
@endsection
