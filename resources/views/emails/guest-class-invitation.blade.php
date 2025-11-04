<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>You're Invited to Join a Live Class</title>
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
            background: linear-gradient(135deg, #9c27b0 0%, #7b1fa2 100%);
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
        .invitation-badge {
            background: linear-gradient(135deg, #e1bee7 0%, #f3e5f5 100%);
            border: 2px dashed #9c27b0;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 25px 0;
        }
        .invitation-badge h3 {
            margin: 0;
            color: #6a1b9a;
            font-size: 22px;
        }
        .invitation-badge p {
            margin: 10px 0 0;
            color: #7b1fa2;
            font-size: 15px;
        }
        .class-details {
            background: #f9f9f9;
            border-left: 4px solid #9c27b0;
            padding: 20px;
            margin: 25px 0;
            border-radius: 6px;
        }
        .class-details h3 {
            margin: 0 0 15px;
            color: #9c27b0;
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
            background: linear-gradient(135deg, #9c27b0 0%, #7b1fa2 100%);
            color: #ffffff;
            text-decoration: none;
            border-radius: 30px;
            font-size: 18px;
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(156, 39, 176, 0.4);
            transition: all 0.3s ease;
        }
        .join-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(156, 39, 176, 0.5);
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
        .guest-info {
            background: #e8eaf6;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
        }
        .guest-info h4 {
            margin: 0 0 15px;
            color: #3f51b5;
            font-size: 16px;
        }
        .guest-info ul {
            margin: 0;
            padding-left: 20px;
        }
        .guest-info li {
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
            color: #9c27b0;
            text-decoration: none;
        }
        .divider {
            height: 1px;
            background: #e0e0e0;
            margin: 30px 0;
        }
        .highlight-box {
            background: #e8f5e9;
            border-left: 4px solid #4caf50;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .highlight-box p {
            margin: 0;
            color: #2e7d32;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>🎉 You're Invited!</h1>
            <p>Join an exclusive live learning session</p>
        </div>

        <!-- Body -->
        <div class="email-body">
            <p class="greeting">Hello!</p>

            <!-- Invitation Badge -->
            <div class="invitation-badge">
                <h3>✨ Special Guest Invitation</h3>
                <p><strong>{{ $buyerName }}</strong> has invited you to join their live class!</p>
            </div>

            <p>You've been invited to attend a live learning session as a guest. This is a great opportunity to experience quality education with an expert instructor.</p>

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
                <div class="detail-row">
                    <span class="detail-label">🎫 Invited By:</span>
                    <span class="detail-value">{{ $buyerName }}</span>
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
                <strong>🔒 Secure Guest Access Link</strong>
                This link is unique to you and can only be used once. It will expire after you join or 45 minutes after the class starts. Please do not share this link with others.
            </div>

            <!-- Guest Info -->
            <div class="guest-info">
                <h4>👤 As a Guest, You Can:</h4>
                <ul>
                    <li>Participate in the live video session</li>
                    <li>Interact with the teacher and other participants</li>
                    <li>Ask questions and engage in discussions</li>
                    <li>Experience the full learning environment</li>
                </ul>
            </div>

            <!-- Highlight Box -->
            <div class="highlight-box">
                <p><strong>💡 Tip:</strong> No registration required! Simply click the join button above when the class starts. Make sure you have a stable internet connection and a quiet environment for the best experience.</p>
            </div>

            <div class="divider"></div>

            <p style="color: #666; font-size: 14px; text-align: center;">
                <strong>First time joining a live class?</strong>
                <br>
                Don't worry! When you click the join button, you'll be guided through a simple setup process. The teacher will help ensure everyone is connected properly.
            </p>

            <div class="divider"></div>

            <p style="color: #666; font-size: 14px;">
                Having trouble with the button? Copy and paste this link into your browser:
                <br>
                <a href="{{ $joinUrl }}" style="color: #9c27b0; word-break: break-all;">{{ $joinUrl }}</a>
            </p>

            <p style="color: #999; font-size: 13px; margin-top: 30px; text-align: center;">
                <strong>Want to host your own classes?</strong>
                <br>
                Join DreamCrowd as a teacher or student and access hundreds of live learning opportunities!
                <br>
                <a href="{{ url('/') }}" style="color: #9c27b0;">Learn More →</a>
            </p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p><strong>DreamCrowd</strong> - Connecting Teachers and Students Worldwide</p>
            <p>Questions? Contact us at <a href="mailto:support@dreamcrowd.com">support@dreamcrowd.com</a></p>
            <p style="margin-top: 15px; font-size: 12px; color: #999;">
                You received this email because {{ $buyerName }} invited you to join their class.
                <br>
                This is a one-time guest invitation. Your email will not be used for marketing purposes.
                <br>
                © {{ date('Y') }} DreamCrowd. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
