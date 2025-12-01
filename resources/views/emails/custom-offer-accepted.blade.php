<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Offer Accepted</title>
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
        .success-badge {
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            display: inline-block;
            margin: 20px 0;
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
            <h1>🎉 Your Custom Offer Was Accepted!</h1>
        </div>

        <div class="content">
            <p>Hi {{ $sellerName }},</p>

            <p>Great news! {{ $buyerName }} has accepted your custom offer for <strong>{{ $offer->gig->title }}</strong>.</p>

            <center>
                <span class="success-badge">Payment Received: @currencyRaw($offer->total_amount)</span>
            </center>

            <h3>Next Steps:</h3>
            <ol>
                <li>Review the order details in your dashboard</li>
                <li>Start working on the project according to the agreed milestones</li>
                <li>Communicate with {{ $buyerName }} through the messaging system</li>
                <li>Deliver your work on time to ensure a positive review</li>
            </ol>

            <center>
                <a href="{{ url('/teacher-dashboard') }}" class="button">View Order</a>
            </center>

            <p><small>Remember to maintain professional communication and deliver high-quality work to build your reputation!</small></p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>This is an automated message. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>
