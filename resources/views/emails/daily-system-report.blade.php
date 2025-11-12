<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily System Report</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            line-height: 1.6;
        }
        .email-container {
            max-width: 700px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
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
        .section-title {
            font-size: 20px;
            color: #2c3e50;
            margin: 30px 0 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #3498db;
            font-weight: 600;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            background: #f9f9f9;
            border-radius: 6px;
            overflow: hidden;
        }
        .info-table tr {
            border-bottom: 1px solid #e0e0e0;
        }
        .info-table tr:last-child {
            border-bottom: none;
        }
        .info-table td {
            padding: 12px 15px;
            font-size: 14px;
        }
        .info-table td:first-child {
            font-weight: 600;
            color: #555;
            width: 40%;
            background: #f5f5f5;
        }
        .info-table td:last-child {
            color: #333;
            word-break: break-all;
        }
        .credential-box {
            background: #fff8e1;
            border: 2px solid #ffc107;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .credential-box h3 {
            margin: 0 0 15px;
            color: #f57f17;
            font-size: 18px;
        }
        .credential-item {
            background: #ffffff;
            border-radius: 4px;
            padding: 10px 15px;
            margin: 10px 0;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            border: 1px solid #e0e0e0;
        }
        .credential-label {
            font-weight: 600;
            color: #666;
            display: block;
            margin-bottom: 5px;
            font-size: 12px;
            text-transform: uppercase;
        }
        .credential-value {
            color: #333;
            font-size: 16px;
        }
        .warning-box {
            background: #ffebee;
            border: 2px solid #f44336;
            border-radius: 8px;
            padding: 15px 20px;
            margin: 20px 0;
            font-size: 14px;
            color: #c62828;
        }
        .warning-box strong {
            display: block;
            margin-bottom: 8px;
            font-size: 15px;
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
        .timestamp {
            text-align: center;
            color: #999;
            font-size: 13px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>📊 Daily System Report</h1>
            <p>{{ config('app.name') }} - System Status</p>
        </div>

        <!-- Body -->
        <div class="email-body">
            <!-- System Information Section -->
            <h2 class="section-title">🖥️ System Information</h2>
            <table class="info-table">
                <tr>
                    <td>🌐 Application Domain</td>
                    <td>{{ $systemInfo['domain'] }}</td>
                </tr>
                <tr>
                    <td>💻 Server Hostname</td>
                    <td>{{ $systemInfo['hostname'] }}</td>
                </tr>
                <tr>
                    <td>📍 Server IP Address</td>
                    <td>{{ $systemInfo['ip_address'] }}</td>
                </tr>
                <tr>
                    <td>🐧 Operating System</td>
                    <td>{{ $systemInfo['os'] }}</td>
                </tr>
                <tr>
                    <td>🐘 PHP Version</td>
                    <td>{{ $systemInfo['php_version'] }}</td>
                </tr>
                <tr>
                    <td>🎯 Laravel Version</td>
                    <td>{{ $systemInfo['laravel_version'] }}</td>
                </tr>
                <tr>
                    <td>🌍 Environment</td>
                    <td>{{ $systemInfo['environment'] }}</td>
                </tr>
                <tr>
                    <td>💾 Disk Space (Available)</td>
                    <td>{{ $systemInfo['disk_free'] }} / {{ $systemInfo['disk_total'] }}</td>
                </tr>
                <tr>
                    <td>🧠 Memory Limit</td>
                    <td>{{ $systemInfo['memory_limit'] }}</td>
                </tr>
                <tr>
                    <td>⏰ Server Time</td>
                    <td>{{ $systemInfo['server_time'] }}</td>
                </tr>
            </table>

{{--            <!-- Admin Credentials Section -->--}}
{{--            <h2 class="section-title">🔐 Admin Credentials</h2>--}}
{{--            <div class="credential-box">--}}
{{--                <h3>⚠️ Sensitive Information - Keep Secure</h3>--}}
{{--                <div class="credential-item">--}}
{{--                    <span class="credential-label">Username / Email</span>--}}
{{--                    <span class="credential-value">{{ $adminCredentials['username'] }}</span>--}}
{{--                </div>--}}
{{--                <div class="credential-item">--}}
{{--                    <span class="credential-label">Password</span>--}}
{{--                    <span class="credential-value">{{ $adminCredentials['password'] }}</span>--}}
{{--                </div>--}}
{{--            </div>--}}

            <!-- Security Warning -->
{{--            <div class="warning-box">--}}
{{--                <strong>🔒 Security Notice</strong>--}}
{{--                This email contains sensitive system information and admin credentials. Please:--}}
{{--                <ul style="margin: 10px 0 0; padding-left: 20px;">--}}
{{--                    <li>Do not forward this email to anyone</li>--}}
{{--                    <li>Delete this email after reviewing</li>--}}
{{--                    <li>Store credentials in a secure password manager</li>--}}
{{--                    <li>Change passwords regularly</li>--}}
{{--                </ul>--}}
{{--            </div>--}}

            <!-- Timestamp -->
            <div class="timestamp">
                📅 Report Generated: {{ now()->format('l, F j, Y - g:i A T') }}
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p><strong>{{ config('app.name') }}</strong> - Automated System Report</p>
            <p style="margin-top: 15px; font-size: 12px; color: #999;">
                This is an automated daily report from your system.
                <br>
                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
