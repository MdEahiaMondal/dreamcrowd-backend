@extends('emails.layouts.base')

@section('title', 'Order Approved')

@section('header_title', 'Order Approved! 🎉')

@section('content')
    <div class="success-box">
        <p><strong>✓ Great News!</strong></p>
        <p>Your order has been approved and is now active.</p>
    </div>

    <p class="lead">Hello,</p>

    <p>
        <strong>{{ $sellerName ?? 'The seller' }}</strong> has accepted your order for
        <strong>"{{ $serviceName ?? 'the requested service' }}"</strong>.
    </p>

    <p>
        The seller will begin working on your order shortly. You can track the progress and communicate
        with the seller through your dashboard.
    </p>

    <div class="info-box">
        <p><strong>Order Details:</strong></p>
        <p><strong>Order ID:</strong> #{{ $orderId ?? 'N/A' }}</p>
        <p><strong>Service:</strong> {{ $serviceName ?? 'N/A' }}</p>
        <p><strong>Seller:</strong> {{ $sellerName ?? 'N/A' }}</p>
        <p><strong>Amount:</strong> @currencyRaw($amount ?? 0)</p>
        @if(isset($deliveryDate))
            <p><strong>Expected Delivery:</strong> {{ $deliveryDate }}</p>
        @endif
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

    <h3>What's Next?</h3>
    <ul>
        <li>The seller will start working on your order</li>
        <li>You'll receive updates as progress is made</li>
        <li>You can message the seller anytime through the order page</li>
        <li>Once delivered, you'll have 48 hours to review and report any issues</li>
    </ul>

    <p style="color: #777; font-size: 13px; margin-top: 20px;">
        <em>If you have any questions or concerns, please don't hesitate to contact our support team.</em>
    </p>
@endsection
