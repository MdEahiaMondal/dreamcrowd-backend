<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Class Starts Soon</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            line-height: 1.6;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);
            color: #ffffff;
            padding: 40px 30px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        .email-header p {
            margin: 10px 0 0;
            font-size: 16px;
            opacity: 0.9;
        }
        .email-body {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }
        .class-details {
            background: #f9f9f9;
            border-left: 4px solid #1976d2;
            padding: 20px;
            margin: 25px 0;
            border-radius: 6px;
        }
        .class-details h3 {
            margin: 0 0 15px;
            color: #1976d2;
            font-size: 20px;
        }
        .detail-row {
            display: flex;
            margin: 10px 0;
            font-size: 15px;
        }
        .detail-label {
            font-weight: 600;
            color: #555;
            width: 120px;
        }
        .detail-value {
            color: #333;
        }
        .join-button-container {
            text-align: center;
            margin: 35px 0;
        }
        .join-button {
            display: inline-block;
            padding: 16px 50px;
            background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
            color: #ffffff;
            text-decoration: none;
            border-radius: 30px;
            font-size: 18px;
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.4);
            transition: all 0.3s ease;
        }
        .join-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(76, 175, 80, 0.5);
        }
        .security-notice {
            background: #fff8e1;
            border: 1px solid #ffc107;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            font-size: 14px;
            color: #856404;
        }
        .security-notice strong {
            display: block;
            margin-bottom: 5px;
            color: #f57f17;
        }
        .important-notes {
            background: #e3f2fd;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
        }
        .important-notes h4 {
            margin: 0 0 15px;
            color: #1976d2;
            font-size: 16px;
        }
        .important-notes ul {
            margin: 0;
            padding-left: 20px;
        }
        .important-notes li {
            margin: 8px 0;
            color: #333;
            font-size: 14px;
        }
        .email-footer {
            background: #f5f5f5;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e0e0e0;
        }
        .email-footer p {
            margin: 5px 0;
            color: #666;
            font-size: 13px;
        }
        .email-footer a {
            color: #1976d2;
            text-decoration: none;
        }
        .divider {
            height: 1px;
            background: #e0e0e0;
            margin: 30px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>🎓 Your Class Starts Soon!</h1>
            <p>Get ready to join your live session</p>
        </div>

        <!-- Body -->
        <div class="email-body">
            <p class="greeting">Hi {{ $user->first_name }},</p>

            <p>Your live class with <strong>{{ $teacherName }}</strong> is starting soon! We're excited to have you join this session.</p>

            <!-- Class Details -->
            <div class="class-details">
                <h3>{{ $order->title }}</h3>
                <div class="detail-row">
                    <span class="detail-label">📅 Date & Time:</span>
                    <span class="detail-value">{{ $startTime }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">⏱️ Duration:</span>
                    <span class="detail-value">{{ $duration }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">🌍 Timezone:</span>
                    <span class="detail-value">{{ $timezone }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">👨‍🏫 Teacher:</span>
                    <span class="detail-value">{{ $teacherName }}</span>
                </div>
            </div>

            <!-- Join Button -->
            <div class="join-button-container">
                <a href="{{ $joinUrl }}" class="join-button">
                    🚀 Join Live Class Now
                </a>
            </div>

            <!-- Security Notice -->
            <div class="security-notice">
                <strong>🔒 Secure Join Link</strong>
                This link is unique to you and can only be used once. It will expire after you join or 45 minutes after the class starts. Please do not share this link with others.
            </div>

            <!-- Important Notes -->
            <div class="important-notes">
                <h4>📝 Important Notes:</h4>
                <ul>
                    <li>Click the "Join Live Class Now" button above when you're ready to join</li>
                    <li>Make sure you have a stable internet connection</li>
                    <li>Test your audio and video before joining</li>
                    <li>Join a few minutes early to ensure everything is set up</li>
                    <li>If you have any issues joining, contact our support team</li>
                </ul>
            </div>

            <div class="divider"></div>

            <p style="color: #666; font-size: 14px;">
                Having trouble with the button? Copy and paste this link into your browser:
                <br>
                <a href="{{ $joinUrl }}" style="color: #1976d2; word-break: break-all;">{{ $joinUrl }}</a>
            </p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p><strong>DreamCrowd</strong> - Connecting Teachers and Students</p>
            <p>Need help? Contact us at <a href="mailto:support@dreamcrowd.com">support@dreamcrowd.com</a></p>
            <p style="margin-top: 15px; font-size: 12px; color: #999;">
                You received this email because you have a scheduled class with us.
                <br>
                © {{ date('Y') }} DreamCrowd. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
