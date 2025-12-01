@extends('emails.layouts.base')

@section('title', 'Payout Completed - Transaction #' . $transaction->id)

@section('header_title', 'Payout Completed')

@section('content')
    <p class="lead">Hello {{ $seller->name }},</p>

    <p>Great news! Your payout for Transaction <strong>#{{ $transaction->id }}</strong> has been <strong>processed and completed</strong>.</p>

    <div class="info-box" style="background-color: #e8f5e9; padding: 20px; border-left: 4px solid #4CAF50; margin: 20px 0;">
        <p style="margin: 0 0 10px 0;"><strong>💰 Payout Details:</strong></p>
        <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size: 14px;">
            <tr>
                <td style="padding: 5px 0;"><strong>Transaction ID:</strong></td>
                <td style="padding: 5px 0;">#{{ $transaction->id }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;"><strong>Order ID:</strong></td>
                <td style="padding: 5px 0;">#{{ $transaction->order_id ?? 'N/A' }}</td>
            </tr>
            @if($transaction->bookOrder && $transaction->bookOrder->gig)
            <tr>
                <td style="padding: 5px 0;"><strong>Service:</strong></td>
                <td style="padding: 5px 0;">{{ $transaction->bookOrder->gig->title }}</td>
            </tr>
            @endif
            <tr>
                <td style="padding: 5px 0;"><strong>Buyer:</strong></td>
                <td style="padding: 5px 0;">{{ $transaction->buyer->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;"><strong>Order Amount:</strong></td>
                <td style="padding: 5px 0;">@currencyRaw($transaction->total_amount)</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;"><strong>Commission:</strong></td>
                <td style="padding: 5px 0;">-@currencyRaw($transaction->seller_commission_amount) ({{ number_format($transaction->seller_commission_rate, 2) }}%)</td>
            </tr>
            <tr style="border-top: 2px solid #4CAF50;">
                <td style="padding: 10px 0;"><strong>Your Earnings:</strong></td>
                <td style="padding: 10px 0; color: #4CAF50; font-size: 20px; font-weight: bold;">@currencyRaw($transaction->seller_earnings)</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;"><strong>Payout Date:</strong></td>
                <td style="padding: 5px 0;">{{ now()->format('F d, Y h:i A') }}</td>
            </tr>
        </table>
    </div>

    <div class="alert-box" style="background-color: #e3f2fd; padding: 15px; border-left: 4px solid #2196F3; margin: 20px 0;">
        <p><strong>📊 Payment Breakdown:</strong></p>
        <ul style="margin: 10px 0 0 20px; padding: 0;">
            <li>Original Order Amount: <strong>@currencyRaw($transaction->total_amount)</strong></li>
            <li>Platform Commission ({{ number_format($transaction->seller_commission_rate, 2) }}%): <strong>-@currencyRaw($transaction->seller_commission_amount)</strong></li>
            <li>Buyer Commission: <strong>@currencyRaw($transaction->buyer_commission_amount)</strong> (paid by buyer)</li>
            <li style="margin-top: 10px; border-top: 2px solid #2196F3; padding-top: 10px; color: #4CAF50; font-weight: bold;">
                Net Amount Paid to You: <strong>@currencyRaw($transaction->seller_earnings)</strong>
            </li>
        </ul>
    </div>

    <div class="alert-box" style="background-color: #fff3cd; padding: 15px; border-left: 4px solid #ffc107; margin: 20px 0;">
        <p><strong>⏱ When Will I Receive the Money?</strong></p>
        <p style="margin: 10px 0 0 0;">The funds have been released to your registered payment method. Depending on your bank and payment provider, the money should appear in your account within <strong>3-5 business days</strong>.</p>
    </div>

    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="margin: 30px 0;">
        <tr>
            <td align="center">
                <a href="{{ url('/teacher-transaction') }}" class="btn btn-primary" style="display: inline-block; padding: 12px 30px; background-color: #4CAF50; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold;">
                    View Transaction History
                </a>
            </td>
        </tr>
    </table>

    <div class="divider" style="height: 1px; background-color: #e0e0e0; margin: 30px 0;"></div>

    <p style="color: #777; font-size: 13px;">
        <strong>Need Help?</strong> If you have any questions about this payout or haven't received the funds within the expected timeframe, please contact our support team.
    </p>

    <p style="color: #777; font-size: 13px; margin-top: 15px;">
        <strong>Keep Up the Great Work!</strong> Thank you for being a valued seller on {{ config('app.name', 'DreamCrowd') }}. We appreciate your contributions to our community.
    </p>
@endsection
