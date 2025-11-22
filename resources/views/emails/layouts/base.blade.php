<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', config('app.name', 'DreamCrowd'))</title>
    <style>
        /* Reset Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', 'Helvetica', 'Segoe UI', sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f4f6f9;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        img {
            border: 0;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
            max-width: 100%;
            height: auto;
        }

        a {
            color: #4CAF50;
            text-decoration: none;
        }

        a:hover {
            color: #45a049;
            text-decoration: underline;
        }

        /* Main Container */
        .email-wrapper {
            width: 100%;
            background-color: #f4f6f9;
            padding: 20px 0;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        /* Header */
        .email-header {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            padding: 30px 20px;
            text-align: center;
        }

        .email-header .logo {
            max-width: 180px;
            height: auto;
            margin-bottom: 10px;
        }

        .email-header h1 {
            color: #ffffff;
            font-size: 24px;
            font-weight: 600;
            margin: 15px 0 0 0;
            padding: 0;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .email-header .subtitle {
            color: rgba(255,255,255,0.9);
            font-size: 14px;
            margin-top: 8px;
        }

        /* Content Area */
        .email-body {
            padding: 40px 30px;
            background-color: #ffffff;
        }

        .email-body h2 {
            color: #333333;
            font-size: 22px;
            font-weight: 600;
            margin: 0 0 20px 0;
            padding-bottom: 15px;
            border-bottom: 2px solid #4CAF50;
        }

        .email-body h3 {
            color: #333333;
            font-size: 18px;
            font-weight: 600;
            margin: 25px 0 15px 0;
        }

        .email-body p {
            color: #555555;
            font-size: 15px;
            line-height: 1.8;
            margin: 0 0 15px 0;
        }

        .email-body p.lead {
            font-size: 16px;
            color: #333333;
            font-weight: 500;
        }

        .email-body ul,
        .email-body ol {
            color: #555555;
            font-size: 15px;
            line-height: 1.8;
            margin: 15px 0;
            padding-left: 25px;
        }

        .email-body li {
            margin-bottom: 8px;
        }

        /* Info Box */
        .info-box {
            background-color: #f9f9f9;
            border-left: 4px solid #4CAF50;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }

        .info-box p {
            margin: 8px 0;
        }

        .info-box strong {
            color: #333333;
            font-weight: 600;
        }

        .info-box ul {
            margin: 10px 0;
            padding-left: 20px;
        }

        /* Alert Box */
        .alert-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }

        .alert-box p {
            color: #856404;
            margin: 8px 0;
        }

        /* Success Box */
        .success-box {
            background-color: #d4edda;
            border-left: 4px solid #28a745;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }

        .success-box p {
            color: #155724;
            margin: 8px 0;
        }

        /* Error Box */
        .error-box {
            background-color: #f8d7da;
            border-left: 4px solid #dc3545;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }

        .error-box p {
            color: #721c24;
            margin: 8px 0;
        }

        /* Button */
        .btn {
            display: inline-block;
            padding: 14px 32px;
            margin: 20px 0;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
            text-align: center;
        }

        .btn-primary {
            background-color: #4CAF50;
            color: #ffffff !important;
            box-shadow: 0 2px 8px rgba(76, 175, 80, 0.3);
        }

        .btn-primary:hover {
            background-color: #45a049;
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.4);
        }

        .btn-secondary {
            background-color: #6c757d;
            color: #ffffff !important;
            box-shadow: 0 2px 8px rgba(108, 117, 125, 0.3);
        }

        .btn-danger {
            background-color: #dc3545;
            color: #ffffff !important;
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
        }

        .btn-block {
            display: block;
            width: 100%;
            text-align: center;
        }

        /* Divider */
        .divider {
            height: 1px;
            background-color: #e0e0e0;
            margin: 30px 0;
        }

        /* Data Table */
        .data-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }

        .data-table th,
        .data-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        .data-table th {
            background-color: #f9f9f9;
            font-weight: 600;
            color: #333333;
        }

        .data-table td {
            color: #555555;
        }

        /* Footer */
        .email-footer {
            background-color: #2c3e50;
            padding: 30px 20px;
            text-align: center;
        }

        .email-footer p {
            color: #bdc3c7;
            font-size: 13px;
            line-height: 1.6;
            margin: 8px 0;
        }

        .email-footer a {
            color: #4CAF50;
            text-decoration: none;
        }

        .email-footer a:hover {
            color: #45a049;
            text-decoration: underline;
        }

        .email-footer .footer-links {
            margin: 15px 0;
        }

        .email-footer .footer-links a {
            margin: 0 10px;
        }

        /* Responsive */
        @media only screen and (max-width: 600px) {
            .email-wrapper {
                padding: 10px 0;
            }

            .email-body {
                padding: 25px 20px !important;
            }

            .email-header {
                padding: 25px 15px !important;
            }

            .email-header h1 {
                font-size: 20px !important;
            }

            .email-body h2 {
                font-size: 18px !important;
            }

            .email-body h3 {
                font-size: 16px !important;
            }

            .email-body p {
                font-size: 14px !important;
            }

            .btn {
                padding: 12px 24px !important;
                font-size: 14px !important;
            }

            .info-box,
            .alert-box,
            .success-box,
            .error-box {
                padding: 15px !important;
            }
        }

        /* Dark Mode Support */
        @media (prefers-color-scheme: dark) {
            body {
                background-color: #1a1a1a;
            }

            .email-wrapper {
                background-color: #1a1a1a;
            }

            .email-container {
                background-color: #2d2d2d;
            }

            .email-body {
                background-color: #2d2d2d;
            }

            .email-body h2,
            .email-body h3,
            .email-body p.lead {
                color: #f5f5f5;
            }

            .email-body p,
            .email-body li {
                color: #d0d0d0;
            }

            .info-box {
                background-color: #3a3a3a;
            }

            .data-table th {
                background-color: #3a3a3a;
                color: #f5f5f5;
            }

            .data-table td {
                color: #d0d0d0;
                border-bottom-color: #444;
            }
        }
    </style>
</head>
<body>
    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" class="email-wrapper">
        <tr>
            <td align="center">
                <table class="email-container" role="presentation" cellpadding="0" cellspacing="0" border="0">

                    <!-- Header -->
                    <tr>
                        <td class="email-header">
                            @php
                                $logoPath = public_path('assets/public-site/images/navlogo.png');
                                $logoUrl = asset('assets/public-site/images/navlogo.png');
                            @endphp

                            @if(file_exists($logoPath))
                                <img src="{{ $logoUrl }}" alt="{{ config('app.name', 'DreamCrowd') }}" class="logo" />
                            @else
                                <div style="margin: 0; color: #ffffff; font-size: 32px; font-weight: bold;">
                                    {{ config('app.name', 'DreamCrowd') }}
                                </div>
                            @endif

                            @hasSection('header_title')
                                <h1>@yield('header_title')</h1>
                            @endif

                            @hasSection('header_subtitle')
                                <div class="subtitle">@yield('header_subtitle')</div>
                            @endif
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td class="email-body">
                            @yield('content')
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td class="email-footer">
                            <p style="margin-bottom: 15px;">
                                <strong style="color: #ffffff; font-size: 16px;">
                                    {{ config('app.name', 'DreamCrowd') }}
                                </strong>
                            </p>

                            <p>
                                &copy; {{ date('Y') }} {{ config('app.name', 'DreamCrowd') }}. All rights reserved.
                            </p>

                            <p style="margin-top: 15px;">
                                This is an automated message. Please do not reply to this email.
                            </p>

                            <div class="footer-links">
                                <a href="{{ url('/') }}">Visit Website</a> |
                                <a href="{{ url('/contact') }}">Contact Support</a> |
                                <a href="{{ url('/privacy-policy') }}">Privacy Policy</a>
                            </div>

                            @hasSection('footer_extra')
                                <div style="margin-top: 15px;">
                                    @yield('footer_extra')
                                </div>
                            @endif
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
