@extends('emails.layouts.base')

@section('title', 'Reschedule Approved')

@section('header_title', 'Reschedule Approved ✓')

@section('content')
    <div class="success-box">
        <p><strong>✓ Reschedule Request Approved!</strong></p>
    </div>

    <p class="lead">Hello,</p>

    <p>
        Good news! Your reschedule request for <strong>"{{ $serviceName ?? 'the service' }}"</strong>
        has been approved.
    </p>

    <div class="info-box">
        <p><strong>Updated Schedule:</strong></p>
        <p><strong>Order ID:</strong> #{{ $orderId ?? 'N/A' }}</p>
        <p><strong>Service:</strong> {{ $serviceName ?? 'N/A' }}</p>
        @if(isset($newDate))
            <p><strong>New Date:</strong> {{ $newDate }}</p>
        @endif
    </div>

    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            <td align="center">
                <a href="{{ url('/user-application-details/' . ($orderId ?? '')) }}" class="btn btn-primary">
                    View Updated Schedule
                </a>
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    <h3>Important Notes:</h3>
    <ul>
        <li>Your class schedule has been updated with the new dates</li>
        <li>You'll receive a reminder before each rescheduled class</li>
        <li>All class details remain the same except for the dates</li>
        <li>Contact support if you have any questions</li>
    </ul>

    <p style="color: #777; font-size: 13px; margin-top: 20px;">
        <em>Thank you for your patience and flexibility with the schedule adjustment.</em>
    </p>
@endsection
