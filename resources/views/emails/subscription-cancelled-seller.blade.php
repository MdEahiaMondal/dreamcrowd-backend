@extends('emails.layouts.base')

@section('title', 'Subscription Cancelled by Buyer - ' . ($data['service_name'] ?? 'Order'))

@section('header_title', 'Subscription Cancelled')

@section('content')
    <p class="lead">Hello {{ $user->first_name ?? $user->name ?? 'Valued Seller' }},</p>

    <p>A buyer has cancelled their subscription to your service. Here are the details:</p>

    <div class="info-box" style="background-color: #f8d7da; padding: 20px; border-left: 4px solid #dc3545; margin: 20px 0;">
        <p style="margin: 0 0 10px 0;"><strong>Cancellation Details:</strong></p>
        <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size: 14px;">
            <tr>
                <td style="padding: 5px 0;"><strong>Order ID:</strong></td>
                <td style="padding: 5px 0;">#{{ $data['order_id'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;"><strong>Service:</strong></td>
                <td style="padding: 5px 0;">{{ $data['service_name'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;"><strong>Buyer:</strong></td>
                <td style="padding: 5px 0;">{{ $data['buyer_name'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;"><strong>Cancelled On:</strong></td>
                <td style="padding: 5px 0;">{{ now()->format('F d, Y h:i A') }}</td>
            </tr>
        </table>
    </div>

    @if(isset($data['refund_amount']) && $data['refund_amount'] > 0)
    <div class="alert-box" style="background-color: #fff3cd; padding: 20px; border-left: 4px solid #ffc107; margin: 20px 0;">
        <p style="margin: 0 0 10px 0;"><strong>Refund Processed:</strong></p>
        <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size: 14px;">
            <tr>
                <td style="padding: 5px 0;"><strong>Refund Amount:</strong></td>
                <td style="padding: 5px 0; color: #dc3545; font-size: 18px; font-weight: bold;">@currencyRaw($data['refund_amount'])</td>
            </tr>
        </table>
        <p style="margin: 15px 0 0 0; font-size: 13px; color: #856404;">
            This amount has been refunded to the buyer. Your earnings for this order have been adjusted accordingly.
        </p>
    </div>
    @else
    <div class="info-box" style="background-color: #e8f5e9; padding: 15px; border-left: 4px solid #4CAF50; margin: 20px 0;">
        <p><strong>No Refund Issued</strong></p>
        <p style="margin: 10px 0 0 0;">Based on our cancellation policy (classes within 12 hours are non-refundable), no refund was issued for this cancellation. Your earnings remain unchanged.</p>
    </div>
    @endif

    @if(isset($data['cancelled_classes']) && count($data['cancelled_classes']) > 0)
    <div class="info-box" style="background-color: #f5f5f5; padding: 15px; border-left: 4px solid #6c757d; margin: 20px 0;">
        <p><strong>Cancelled Classes ({{ count($data['cancelled_classes']) }}):</strong></p>
        <ul style="margin: 10px 0 0 0; padding-left: 20px;">
            @foreach($data['cancelled_classes'] as $classDate)
            <li>{{ \Carbon\Carbon::parse($classDate)->format('M d, Y h:i A') }}</li>
            @endforeach
        </ul>
        <p style="margin: 15px 0 0 0; font-size: 13px; color: #6c757d;">
            <em>These time slots are now available for other bookings.</em>
        </p>
    </div>
    @endif

    @if(isset($data['reason']) && $data['reason'])
    <div class="info-box" style="background-color: #f9f9f9; padding: 15px; margin: 20px 0;">
        <p><strong>Buyer's Cancellation Reason:</strong></p>
        <p style="margin: 5px 0 0 0; font-style: italic;">"{{ $data['reason'] }}"</p>
    </div>
    @endif

    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="margin: 30px 0;">
        <tr>
            <td align="center">
                <a href="{{ url('/client-management') }}" class="btn btn-primary" style="display: inline-block; padding: 12px 30px; background-color: #4CAF50; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold;">
                    View Client Management
                </a>
            </td>
        </tr>
    </table>

    <div class="divider" style="height: 1px; background-color: #e0e0e0; margin: 30px 0;"></div>

    <p style="color: #777; font-size: 13px;">
        <em>We understand cancellations happen. Focus on providing great service to your other clients, and new bookings will come!</em>
    </p>

    <p style="color: #777; font-size: 13px; margin-top: 15px;">
        Thank you for being a valued seller on {{ config('app.name', 'DreamCrowd') }}!
    </p>
@endsection
