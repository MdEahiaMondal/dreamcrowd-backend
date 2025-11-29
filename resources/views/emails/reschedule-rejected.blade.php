@extends('emails.layouts.base')

@section('title', 'Reschedule Declined')

@section('header_title', 'Reschedule Update')

@section('content')
    <div class="error-box">
        <p><strong>✗ Reschedule Request Declined</strong></p>
    </div>

    <p class="lead">Hello,</p>

    <p>
        We regret to inform you that <strong>{{ $rejectorName ?? 'the other party' }}</strong> has declined
        your reschedule request for <strong>"{{ $serviceName ?? 'the service' }}"</strong>.
    </p>

    <div class="info-box">
        <p><strong>Order Details:</strong></p>
        <p><strong>Order ID:</strong> #{{ $orderId ?? 'N/A' }}</p>
        <p><strong>Service:</strong> {{ $serviceName ?? 'N/A' }}</p>
    </div>

    <div class="alert-box">
        <p><strong>📅 Current Schedule Remains</strong></p>
        <p>The original class schedule will remain in effect.</p>
    </div>

    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            <td align="center">
                <a href="{{ url('/user-application-details/' . ($orderId ?? '')) }}" class="btn btn-primary">
                    View Order Details
                </a>
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    <h3>What You Can Do:</h3>
    <ul>
        <li><strong>Proceed with the original schedule</strong> as planned</li>
        <li><strong>Contact the other party</strong> to discuss alternative arrangements</li>
        <li><strong>Submit a new request</strong> with different dates</li>
        <li><strong>Contact support</strong> if you need assistance</li>
    </ul>

    <p style="color: #777; font-size: 13px; margin-top: 20px;">
        <em>We appreciate your understanding. Please reach out to support if you have any concerns.</em>
    </p>
@endsection
