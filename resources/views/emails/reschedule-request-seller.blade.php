@extends('emails.layouts.base')

@section('title', 'Seller Requested Reschedule')

@section('header_title', 'Reschedule Request')

@section('content')
    <div class="info-box">
        <p><strong>📅 Reschedule Request from Seller</strong></p>
    </div>

    <p class="lead">Hello,</p>

    <p>
        <strong>{{ $sellerName ?? 'The seller' }}</strong> has requested to reschedule
        <strong>{{ $rescheduleCount ?? 1 }} class(es)</strong> for
        <strong>"{{ $serviceName ?? 'your service' }}"</strong>.
    </p>

    <div class="info-box">
        <p><strong>Reschedule Details:</strong></p>
        <p><strong>Order ID:</strong> #{{ $orderId ?? 'N/A' }}</p>
        <p><strong>Service:</strong> {{ $serviceName ?? 'N/A' }}</p>
        <p><strong>Seller:</strong> {{ $sellerName ?? 'N/A' }}</p>
        <p><strong>Classes to Reschedule:</strong> {{ $rescheduleCount ?? 1 }}</p>
        @if(isset($oldDate))
            <p><strong>Current Date:</strong> {{ $oldDate }}</p>
        @endif
        @if(isset($newDate))
            <p><strong>Proposed New Date:</strong> {{ $newDate }}</p>
        @endif
    </div>

    <div class="alert-box">
        <p><strong>⚠ Your Approval Needed</strong></p>
        <p>Please review and respond to this reschedule request.</p>
    </div>

    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            <td align="center">
                <a href="{{ url('/user-application-details/' . ($orderId ?? '')) }}" class="btn btn-primary">
                    Review Request
                </a>
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    <h3>Next Steps:</h3>
    <ul>
        <li><strong>Review the proposed dates</strong> to see if they work for your schedule</li>
        <li><strong>Accept or decline</strong> the reschedule request</li>
        <li><strong>Contact the seller</strong> if you need clarification or want to suggest alternative dates</li>
    </ul>

    <p style="color: #777; font-size: 13px; margin-top: 20px;">
        <em>We appreciate your understanding and flexibility in accommodating schedule changes.</em>
    </p>
@endsection
