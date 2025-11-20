<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Offer Rejected</title>
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
            background: #f44336;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 30px;
        }
        .reason-box {
            background: #fff3cd;
            border-left: 4px solid #f44336;
            padding: 15px;
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
            <h1>Custom Offer Rejected</h1>
        </div>

        <div class="content">
            <p>Hi {{ $sellerName }},</p>

            <p>{{ $buyerName }} has declined your custom offer for <strong>{{ $offer->gig->title }}</strong>.</p>

            @if($rejectionReason && $rejectionReason !== 'No reason provided')
            <div class="reason-box">
                <strong>Reason:</strong><br>
                {{ $rejectionReason }}
            </div>
            @endif

            <h3>What You Can Do:</h3>
            <ul>
                <li>Review the rejection reason to understand the buyer's concerns</li>
                <li>Send a new custom offer with adjusted terms</li>
                <li>Contact the buyer to discuss their requirements further</li>
                <li>Ensure your future offers align better with buyer expectations</li>
            </ul>

            <center>
                <a href="{{ url('/messages') }}" class="button">Send New Offer</a>
            </center>

            <p><small>Don't be discouraged! Each interaction is an opportunity to improve and find the right match for your services.</small></p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>This is an automated message. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>
