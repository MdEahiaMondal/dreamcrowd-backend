<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template Preview - {{ config('app.name') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 30px 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .header h1 {
            color: #333;
            font-size: 32px;
            margin-bottom: 10px;
        }

        .header p {
            color: #666;
            font-size: 16px;
        }

        .email-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
        }

        .email-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .email-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .email-card-header {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            padding: 20px;
        }

        .email-card-header h3 {
            font-size: 20px;
            margin-bottom: 5px;
        }

        .email-card-header p {
            font-size: 13px;
            opacity: 0.9;
        }

        .email-card-body {
            padding: 20px;
        }

        .email-card-body p {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            width: 100%;
            padding: 12px 20px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            font-weight: 600;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background: #45a049;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            background: #f0f0f0;
            color: #666;
            font-size: 11px;
            border-radius: 12px;
            margin-top: 10px;
        }

        .alert {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .alert p {
            color: #856404;
            margin: 0;
        }

        @media (max-width: 768px) {
            .email-grid {
                grid-template-columns: 1fr;
            }

            .header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📧 Email Template Preview System</h1>
            <p>Professional email templates with privacy protection | {{ config('app.name', 'DreamCrowd') }}</p>
        </div>

        <div class="alert">
            <p><strong>⚡ Live Preview:</strong> Click on any email template below to see how it will look when sent to users. All templates use privacy-protected names (e.g., "Gabriel A" instead of "Gabriel Ahmed").</p>
        </div>

        <div class="email-grid">
            @foreach($emailTemplates as $template)
                <div class="email-card">
                    <div class="email-card-header">
                        <h3>{{ $template['title'] }}</h3>
                        <p>{{ $template['name'] }}.blade.php</p>
                    </div>
                    <div class="email-card-body">
                        <p>{{ $template['description'] }}</p>
                        <a href="{{ route('email-test.preview', $template['name']) }}" class="btn" target="_blank">
                            Preview Email
                        </a>
                        <span class="badge">Privacy Protected</span>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="header" style="margin-top: 30px;">
            <h2 style="font-size: 20px; margin-bottom: 15px;">✨ Features</h2>
            <ul style="color: #666; line-height: 2; padding-left: 20px;">
                <li>Professional DreamCrowd branding with green gradient header (#4CAF50)</li>
                <li>Privacy-protected names using NameHelper (e.g., "John D" instead of "John Doe")</li>
                <li>Responsive design that works on all devices (mobile, tablet, desktop)</li>
                <li>Dark mode support for modern email clients</li>
                <li>Email-safe HTML (table-based layout for maximum compatibility)</li>
                <li>Professional footer with copyright and links</li>
                <li>Consistent styling across all email templates</li>
                <li>Call-to-action buttons with hover effects</li>
            </ul>
        </div>

        <div class="header" style="margin-top: 20px; background: #2c3e50; color: white;">
            <p style="color: #bdc3c7; text-align: center; margin: 0;">
                &copy; {{ date('Y') }} {{ config('app.name', 'DreamCrowd') }}. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
