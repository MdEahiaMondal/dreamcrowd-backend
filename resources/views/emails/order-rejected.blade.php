@extends('emails.layouts.base')

@section('title', 'Order Declined')

@section('header_title', 'Order Update')

@section('content')
    <div class="alert-box">
        <p><strong>⚠ Order Status Update</strong></p>
        <p>Your order request has been declined.</p>
    </div>

    <p class="lead">Hello,</p>

    <p>
        We regret to inform you that <strong>{{ $sellerName ?? 'the seller' }}</strong> has declined your
        order request for <strong>"{{ $serviceName ?? 'the requested service' }}"</strong>.
    </p>

    @if(isset($reason) && !empty($reason))
        <div class="info-box">
            <p><strong>Seller's Message:</strong></p>
            <p style="font-style: italic;">"{{ $reason }}"</p>
        </div>
    @endif

    <div class="info-box">
        <p><strong>Order Details:</strong></p>
        <p><strong>Order ID:</strong> #{{ $orderId ?? 'N/A' }}</p>
        <p><strong>Service:</strong> {{ $serviceName ?? 'N/A' }}</p>
        <p><strong>Seller:</strong> {{ $sellerName ?? 'N/A' }}</p>
    </div>

    <div class="divider"></div>

    <h3>What Can You Do Next?</h3>
    <ul>
        <li>Browse other sellers offering similar services</li>
        <li>Contact the seller directly to discuss alternative arrangements</li>
        <li>Explore different services that might meet your needs</li>
        <li>Save this seller for future opportunities</li>
    </ul>

    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            <td align="center">
                <a href="{{ url('/seller-listing') }}" class="btn btn-primary">
                    Browse Similar Services
                </a>
            </td>
        </tr>
    </table>

    <p style="color: #777; font-size: 13px; margin-top: 20px;">
        <em>We apologize for any inconvenience. Our team is here to help you find the perfect service for your needs.</em>
    </p>
@endsection
