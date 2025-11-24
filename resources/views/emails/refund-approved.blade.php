@extends('emails.layouts.base')

@section('title', 'Refund Approved - Order #' . $order->id)

@section('header_title', 'Refund Approved')

@section('content')
    <p class="lead">Hello {{ $user->name }},</p>

    <p>We're writing to inform you that your refund request for Order <strong>#{{ $order->id }}</strong> has been <strong>approved</strong> and processed.</p>

    <div class="info-box" style="background-color: #e8f5e9; padding: 20px; border-left: 4px solid #4CAF50; margin: 20px 0;">
        <p style="margin: 0 0 10px 0;"><strong>✓ Refund Details:</strong></p>
        <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size: 14px;">
            <tr>
                <td style="padding: 5px 0;"><strong>Order ID:</strong></td>
                <td style="padding: 5px 0;">#{{ $order->id }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;"><strong>Service:</strong></td>
                <td style="padding: 5px 0;">{{ $order->gig->title ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;"><strong>Seller:</strong></td>
                <td style="padding: 5px 0;">{{ $order->teacher->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;"><strong>Refund Amount:</strong></td>
                <td style="padding: 5px 0; color: #4CAF50; font-size: 18px; font-weight: bold;">${{ number_format($refund_amount, 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;"><strong>Refund Type:</strong></td>
                <td style="padding: 5px 0;">{{ $refund_type == 0 ? 'Full Refund' : 'Partial Refund' }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;"><strong>Payment Method:</strong></td>
                <td style="padding: 5px 0;">Stripe</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;"><strong>Processing Date:</strong></td>
                <td style="padding: 5px 0;">{{ now()->format('F d, Y h:i A') }}</td>
            </tr>
        </table>
    </div>

    <div class="alert-box" style="background-color: #fff3cd; padding: 15px; border-left: 4px solid #ffc107; margin: 20px 0;">
        <p><strong>⏱ What Happens Next?</strong></p>
        <p style="margin: 10px 0 0 0;">The refund has been processed through Stripe. Depending on your bank, the funds should appear in your account within <strong>5-10 business days</strong>.</p>
    </div>

    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="margin: 30px 0;">
        <tr>
            <td align="center">
                <a href="{{ url('/user-application-details/' . $order->id) }}" class="btn btn-primary" style="display: inline-block; padding: 12px 30px; background-color: #4CAF50; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold;">
                    View Order Details
                </a>
            </td>
        </tr>
    </table>

    @if(isset($admin_notes) && $admin_notes)
    <div class="info-box" style="background-color: #f5f5f5; padding: 15px; margin: 20px 0;">
        <p><strong>Admin Notes:</strong></p>
        <p style="margin: 5px 0 0 0;">{{ $admin_notes }}</p>
    </div>
    @endif

    <div class="divider" style="height: 1px; background-color: #e0e0e0; margin: 30px 0;"></div>

    <p style="color: #777; font-size: 13px;">
        <em>If you have any questions about this refund, please don't hesitate to contact our support team. We're here to help!</em>
    </p>

    <p style="color: #777; font-size: 13px; margin-top: 15px;">
        Thank you for using {{ config('app.name', 'DreamCrowd') }}!
    </p>
@endsection
