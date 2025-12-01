@extends('emails.layouts.base')

@section('title', 'Subscription Cancelled - ' . ($data['service_name'] ?? 'Order'))

@section('header_title', 'Subscription Cancelled')

@section('content')
    <p class="lead">Hello {{ $user->first_name ?? $user->name ?? 'Valued Customer' }},</p>

    <p>Your subscription has been successfully cancelled. Here are the details of your cancellation:</p>

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
                <td style="padding: 5px 0;"><strong>Cancelled On:</strong></td>
                <td style="padding: 5px 0;">{{ now()->format('F d, Y h:i A') }}</td>
            </tr>
        </table>
    </div>

    @if(isset($data['refund_amount']) && $data['refund_amount'] > 0)
    <div class="success-box" style="background-color: #d4edda; padding: 20px; border-left: 4px solid #28a745; margin: 20px 0;">
        <p style="margin: 0 0 10px 0;"><strong>Refund Information:</strong></p>
        <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size: 14px;">
            <tr>
                <td style="padding: 5px 0;"><strong>Refund Amount:</strong></td>
                <td style="padding: 5px 0; color: #28a745; font-size: 18px; font-weight: bold;">@currencyRaw($data['refund_amount'])</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;"><strong>Payment Method:</strong></td>
                <td style="padding: 5px 0;">Stripe (Original payment method)</td>
            </tr>
        </table>
    </div>

    <div class="alert-box" style="background-color: #fff3cd; padding: 15px; border-left: 4px solid #ffc107; margin: 20px 0;">
        <p><strong>When will I receive my refund?</strong></p>
        <p style="margin: 10px 0 0 0;">The refund has been processed through Stripe. Depending on your bank, the funds should appear in your account within <strong>5-10 business days</strong>.</p>
    </div>
    @else
    <div class="alert-box" style="background-color: #fff3cd; padding: 15px; border-left: 4px solid #ffc107; margin: 20px 0;">
        <p><strong>No Refund Applicable</strong></p>
        <p style="margin: 10px 0 0 0;">Based on our cancellation policy, no refund was applicable for this cancellation. Classes within 12 hours of start time are non-refundable.</p>
    </div>
    @endif

    @if(isset($data['refundable_classes']) && count($data['refundable_classes']) > 0)
    <div class="info-box" style="background-color: #e8f5e9; padding: 15px; border-left: 4px solid #4CAF50; margin: 20px 0;">
        <p><strong>Refunded Classes ({{ count($data['refundable_classes']) }}):</strong></p>
        <ul style="margin: 10px 0 0 0; padding-left: 20px;">
            @foreach($data['refundable_classes'] as $classDate)
            <li>{{ \Carbon\Carbon::parse($classDate)->format('M d, Y h:i A') }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(isset($data['non_refundable_classes']) && count($data['non_refundable_classes']) > 0)
    <div class="info-box" style="background-color: #f5f5f5; padding: 15px; border-left: 4px solid #6c757d; margin: 20px 0;">
        <p><strong>Non-Refundable Classes ({{ count($data['non_refundable_classes']) }}):</strong></p>
        <p style="margin: 5px 0; font-size: 13px; color: #6c757d;">Classes within 12 hours of start time</p>
        <ul style="margin: 10px 0 0 0; padding-left: 20px;">
            @foreach($data['non_refundable_classes'] as $classDate)
            <li>{{ \Carbon\Carbon::parse($classDate)->format('M d, Y h:i A') }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(isset($data['reason']) && $data['reason'])
    <div class="info-box" style="background-color: #f9f9f9; padding: 15px; margin: 20px 0;">
        <p><strong>Cancellation Reason:</strong></p>
        <p style="margin: 5px 0 0 0; font-style: italic;">{{ $data['reason'] }}</p>
    </div>
    @endif

    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="margin: 30px 0;">
        <tr>
            <td align="center">
                <a href="{{ url('/order-management') }}" class="btn btn-primary" style="display: inline-block; padding: 12px 30px; background-color: #4CAF50; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold;">
                    View Order History
                </a>
            </td>
        </tr>
    </table>

    <div class="divider" style="height: 1px; background-color: #e0e0e0; margin: 30px 0;"></div>

    <p style="color: #777; font-size: 13px;">
        <em>If you have any questions about this cancellation or need further assistance, please don't hesitate to contact our support team.</em>
    </p>

    <p style="color: #777; font-size: 13px; margin-top: 15px;">
        Thank you for using {{ config('app.name', 'DreamCrowd') }}!
    </p>
@endsection
