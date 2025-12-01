<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Custom Offer</title>
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
            background: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 30px;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .milestones {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .milestone-item {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .milestone-item:last-child {
            border-bottom: none;
        }
        .total {
            font-size: 24px;
            color: #4CAF50;
            font-weight: bold;
            margin: 20px 0;
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
            <h1>You Have a New Custom Offer!</h1>
        </div>

        <div class="content">
            <p>Hi {{ $buyerName }},</p>

            <p>{{ $sellerName }} has sent you a custom offer for <strong>{{ $offer->gig->title }}</strong>.</p>

            <h3>Offer Details:</h3>
            <ul>
                <li><strong>Offer Type:</strong> {{ $offer->offer_type }}</li>
                <li><strong>Service Mode:</strong> {{ $offer->service_mode }}</li>
                <li><strong>Payment Type:</strong> {{ $offer->payment_type }}</li>
                @if($offer->expires_at)
                <li><strong>Expires:</strong> {{ $offer->expires_at->format('F j, Y g:i A') }} ({{ $offer->expires_at->diffForHumans() }})</li>
                @endif
            </ul>

            @if($offer->description)
            <h3>Description:</h3>
            <p>{{ $offer->description }}</p>
            @endif

            @if($offer->milestones->count() > 0)
            <h3>Milestones:</h3>
            <div class="milestones">
                @foreach($offer->milestones as $milestone)
                <div class="milestone-item">
                    <strong>{{ $milestone->title }}</strong> - @currencyRaw($milestone->price)
                    @if($milestone->description)
                    <br><small>{{ $milestone->description }}</small>
                    @endif
                    @if($milestone->date)
                    <br><small>Date: {{ \Carbon\Carbon::parse($milestone->date)->format('F j, Y') }}</small>
                    @endif
                    @if($milestone->revisions !== null)
                    <br><small>Revisions: {{ $milestone->revisions }}</small>
                    @endif
                    @if($milestone->delivery_days)
                    <br><small>Delivery: {{ $milestone->delivery_days }} days</small>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

            <div class="total">
                Total: @currencyRaw($offer->total_amount)
            </div>

            <center>
                <a href="{{ url('/messages') }}" class="button">View Offer</a>
            </center>

            <p><small>Please review this offer in your messages and accept or reject it before it expires.</small></p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>This is an automated message. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>
