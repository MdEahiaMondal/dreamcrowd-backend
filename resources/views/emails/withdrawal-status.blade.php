@extends('emails.layouts.base')

@section('title', 'Withdrawal Update - #' . $withdrawal->id)

@section('header_title', 'Withdrawal Status Update')

@section('content')
    <p class="lead">Hello {{ $sellerName }},</p>

    <p>{{ $statusMessage }}</p>

    @if($status == 'completed')
    <div class="info-box" style="background-color: #e8f5e9; padding: 20px; border-left: 4px solid #4CAF50; margin: 20px 0;">
        <p style="margin: 0 0 10px 0;"><strong>Withdrawal Completed</strong></p>
    @elseif($status == 'processing')
    <div class="info-box" style="background-color: #e3f2fd; padding: 20px; border-left: 4px solid #2196F3; margin: 20px 0;">
        <p style="margin: 0 0 10px 0;"><strong>Withdrawal Processing</strong></p>
    @elseif($status == 'failed')
    <div class="info-box" style="background-color: #ffebee; padding: 20px; border-left: 4px solid #f44336; margin: 20px 0;">
        <p style="margin: 0 0 10px 0;"><strong>Withdrawal Declined</strong></p>
    @else
    <div class="info-box" style="background-color: #f5f5f5; padding: 20px; border-left: 4px solid #9e9e9e; margin: 20px 0;">
        <p style="margin: 0 0 10px 0;"><strong>Withdrawal Details</strong></p>
    @endif
        <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size: 14px;">
            <tr>
                <td style="padding: 5px 0;"><strong>Withdrawal ID:</strong></td>
                <td style="padding: 5px 0;">#{{ $withdrawal->id }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;"><strong>Amount Requested:</strong></td>
                <td style="padding: 5px 0;">${{ $amount }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;"><strong>Processing Fee:</strong></td>
                <td style="padding: 5px 0;">${{ number_format($withdrawal->processing_fee, 2) }}</td>
            </tr>
            <tr style="border-top: 2px solid {{ $status == 'completed' ? '#4CAF50' : ($status == 'failed' ? '#f44336' : '#2196F3') }};">
                <td style="padding: 10px 0;"><strong>Net Amount:</strong></td>
                <td style="padding: 10px 0; color: {{ $status == 'completed' ? '#4CAF50' : '#333' }}; font-size: 20px; font-weight: bold;">
                    ${{ $netAmount }}
                </td>
            </tr>
            <tr>
                <td style="padding: 5px 0;"><strong>Payment Method:</strong></td>
                <td style="padding: 5px 0;">{{ $method }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;"><strong>Request Date:</strong></td>
                <td style="padding: 5px 0;">{{ $withdrawal->created_at->format('F d, Y h:i A') }}</td>
            </tr>
            @if($withdrawal->processed_at)
            <tr>
                <td style="padding: 5px 0;"><strong>Processed Date:</strong></td>
                <td style="padding: 5px 0;">{{ $withdrawal->processed_at->format('F d, Y h:i A') }}</td>
            </tr>
            @endif
        </table>
    </div>

    @if($status == 'completed')
    <div class="alert-box" style="background-color: #fff3cd; padding: 15px; border-left: 4px solid #ffc107; margin: 20px 0;">
        <p><strong>When Will I Receive the Money?</strong></p>
        <p style="margin: 10px 0 0 0;">
            @if($withdrawal->method == 'stripe')
            The funds have been sent via Stripe. Depending on your bank, the money should appear in your account within <strong>1-3 business days</strong>.
            @else
            The funds have been sent via bank transfer. Depending on your bank, the money should appear within <strong>3-5 business days</strong>.
            @endif
        </p>
    </div>

    @if($withdrawal->stripe_transfer_id || $withdrawal->bank_reference)
    <div class="alert-box" style="background-color: #f5f5f5; padding: 15px; border-left: 4px solid #9e9e9e; margin: 20px 0;">
        <p><strong>Transaction Reference:</strong></p>
        <p style="margin: 10px 0 0 0; font-family: monospace;">
            {{ $withdrawal->stripe_transfer_id ?? $withdrawal->bank_reference }}
        </p>
    </div>
    @endif
    @endif

    @if($status == 'failed' && $withdrawal->failure_reason)
    <div class="alert-box" style="background-color: #ffebee; padding: 15px; border-left: 4px solid #f44336; margin: 20px 0;">
        <p><strong>Reason for Decline:</strong></p>
        <p style="margin: 10px 0 0 0;">{{ $withdrawal->failure_reason }}</p>
    </div>

    <div class="alert-box" style="background-color: #fff3cd; padding: 15px; border-left: 4px solid #ffc107; margin: 20px 0;">
        <p><strong>What Can I Do?</strong></p>
        <ul style="margin: 10px 0 0 20px; padding: 0;">
            <li>Review your payment information and ensure it's correct</li>
            <li>Contact our support team if you believe this was an error</li>
            <li>Submit a new withdrawal request after resolving any issues</li>
        </ul>
    </div>
    @endif

    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="margin: 30px 0;">
        <tr>
            <td align="center">
                <a href="{{ $dashboardUrl }}" class="btn btn-primary" style="display: inline-block; padding: 12px 30px; background-color: {{ $status == 'completed' ? '#4CAF50' : '#2196F3' }}; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold;">
                    View Earnings Dashboard
                </a>
            </td>
        </tr>
    </table>

    <div class="divider" style="height: 1px; background-color: #e0e0e0; margin: 30px 0;"></div>

    <p style="color: #777; font-size: 13px;">
        <strong>Need Help?</strong> If you have any questions about this withdrawal or need assistance, please contact our support team.
    </p>

    <p style="color: #777; font-size: 13px; margin-top: 15px;">
        Thank you for being a valued seller on {{ config('app.name', 'DreamCrowd') }}.
    </p>
@endsection
