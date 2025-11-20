<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Offer Expired</title>
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
            background: #ff9800;
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
            <h1>Custom Offer Expired</h1>
        </div>

        <div class="content">
            <p>Hi {{ $recipientName }},</p>

            @if($isBuyer)
                <p>The custom offer from {{ $otherPartyName }} for <strong>{{ $offer->gig->title }}</strong> has expired.</p>

                <p><strong>Offer Amount:</strong> ${{ number_format($offer->total_amount, 2) }}</p>

                <h3>What You Can Do:</h3>
                <ul>
                    <li>Contact {{ $otherPartyName }} to request a new offer</li>
                    <li>Browse similar services from other sellers</li>
                    <li>Adjust your requirements and request a different offer</li>
                </ul>

                <center>
                    <a href="{{ url('/messages') }}" class="button">View Messages</a>
                </center>
            @else
                <p>Your custom offer to {{ $otherPartyName }} for <strong>{{ $offer->gig->title }}</strong> has expired without being accepted.</p>

                <p><strong>Offer Amount:</strong> ${{ number_format($offer->total_amount, 2) }}</p>

                <h3>What You Can Do:</h3>
                <ul>
                    <li>Contact {{ $otherPartyName }} to understand why they didn't accept</li>
                    <li>Send a new offer with updated terms or pricing</li>
                    <li>Ensure future offers have reasonable expiration times</li>
                </ul>

                <center>
                    <a href="{{ url('/messages') }}" class="button">Send New Offer</a>
                </center>
            @endif

            <p><small>Custom offers help facilitate better communication between buyers and sellers. Keep the conversation going!</small></p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>This is an automated message. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>
