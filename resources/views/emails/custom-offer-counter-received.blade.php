<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Counter Offer Received</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background: #FFC107;
            color: #333;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 30px;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: #FFC107;
            color: #333;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
        .comparison {
            display: table;
            width: 100%;
            margin: 20px 0;
        }
        .comparison-box {
            display: table-cell;
            width: 50%;
            padding: 15px;
            vertical-align: top;
        }
        .original-box {
            background: #f5f5f5;
            border-radius: 5px 0 0 5px;
        }
        .counter-box {
            background: #fff3cd;
            border-radius: 0 5px 5px 0;
        }
        .price-tag {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }
        .original-price {
            color: #666;
        }
        .counter-price {
            color: #FFC107;
        }
        .price-diff {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 14px;
            margin-top: 10px;
        }
        .price-lower {
            background: #dc3545;
            color: white;
        }
        .price-higher {
            background: #28a745;
            color: white;
        }
        .message-box {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #FFC107;
        }
        .footer {
            background: #f4f4f4;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Counter Offer Received!</h1>
        </div>

        <div class="content">
            <p>Hi {{ $sellerName }},</p>

            <p><strong>{{ $buyerName }}</strong> has sent a counter offer for your custom offer on <strong>{{ $counterOffer->gig->title ?? 'Service' }}</strong>.</p>

            <h3>Price Comparison:</h3>
            <div class="comparison">
                <div class="comparison-box original-box">
                    <h4>Your Original Offer</h4>
                    <div class="price-tag original-price">
                        @currencyRaw($originalOffer->total_amount ?? 0)
                    </div>
                </div>
                <div class="comparison-box counter-box">
                    <h4>Buyer's Counter Offer</h4>
                    <div class="price-tag counter-price">
                        @currencyRaw($counterOffer->total_amount)
                    </div>
                    @php
                        $diff = floatval($counterOffer->total_amount) - floatval($originalOffer->total_amount ?? 0);
                        $diffPercent = ($originalOffer && $originalOffer->total_amount > 0)
                            ? round(($diff / $originalOffer->total_amount) * 100, 1)
                            : 0;
                    @endphp
                    @if($diff != 0)
                    <span class="price-diff {{ $diff < 0 ? 'price-lower' : 'price-higher' }}">
                        {{ $diff < 0 ? '-' : '+' }}@currencyRaw(abs($diff)) ({{ abs($diffPercent) }}%)
                    </span>
                    @endif
                </div>
            </div>

            @if($counterOffer->counter_message)
            <h3>Buyer's Message:</h3>
            <div class="message-box">
                <p>{{ $counterOffer->counter_message }}</p>
            </div>
            @endif

            <h3>Offer Details:</h3>
            <ul>
                <li><strong>Offer Type:</strong> {{ $counterOffer->offer_type }}</li>
                <li><strong>Service Mode:</strong> {{ $counterOffer->service_mode }}</li>
                <li><strong>Payment Type:</strong> {{ $counterOffer->payment_type }}</li>
            </ul>

            <center>
                <a href="{{ url('/messages') }}" class="button">Review Counter Offer</a>
            </center>

            <p>You can accept the counter offer to proceed with the buyer's proposed price, or reject it and send a new offer if you wish.</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>This is an automated message. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>
