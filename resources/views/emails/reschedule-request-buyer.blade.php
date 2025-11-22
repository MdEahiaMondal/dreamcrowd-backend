@extends('emails.layouts.base')

@section('title', 'Buyer Requested Reschedule')

@section('header_title', 'Reschedule Request')

@section('content')
    <div class="info-box">
        <p><strong>📅 Reschedule Request Received</strong></p>
    </div>

    <p class="lead">Hello,</p>

    <p>
        <strong>{{ $buyerName ?? 'The buyer' }}</strong> has requested to reschedule
        <strong>{{ $rescheduleCount ?? 1 }} class(es)</strong> for
        <strong>"{{ $serviceName ?? 'your service' }}"</strong>.
    </p>

    <div class="info-box">
        <p><strong>Reschedule Details:</strong></p>
        <p><strong>Order ID:</strong> #{{ $orderId ?? 'N/A' }}</p>
        <p><strong>Service:</strong> {{ $serviceName ?? 'N/A' }}</p>
        <p><strong>Buyer:</strong> {{ $buyerName ?? 'N/A' }}</p>
        <p><strong>Classes to Reschedule:</strong> {{ $rescheduleCount ?? 1 }}</p>
        @if(isset($oldDate))
            <p><strong>Current Date:</strong> {{ $oldDate }}</p>
        @endif
        @if(isset($newDate))
            <p><strong>Requested New Date:</strong> {{ $newDate }}</p>
        @endif
    </div>

    <div class="alert-box">
        <p><strong>⚠ Action Required</strong></p>
        <p>Please review the reschedule request and respond as soon as possible.</p>
    </div>

    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            <td align="center">
                <a href="{{ url('/client-management') }}" class="btn btn-primary">
                    Review & Respond
                </a>
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    <h3>What You Can Do:</h3>
    <ul>
        <li><strong>Accept the request</strong> if the new dates work for your schedule</li>
        <li><strong>Decline the request</strong> if you cannot accommodate the changes</li>
        <li><strong>Contact the buyer</strong> to discuss alternative dates</li>
    </ul>

    <p style="color: #777; font-size: 13px; margin-top: 20px;">
        <em>Prompt responses help maintain good relationships with your clients.</em>
    </p>
@endsection
