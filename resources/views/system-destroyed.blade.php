<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Destroyed</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d0000 100%);
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            max-width: 700px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid #ff0000;
            border-radius: 12px;
            padding: 50px;
            text-align: center;
            box-shadow: 0 0 50px rgba(255, 0, 0, 0.3);
        }
        .icon {
            font-size: 100px;
            margin-bottom: 20px;
        }
        h1 {
            font-size: 48px;
            margin: 0 0 20px;
            color: #ff4444;
            text-shadow: 0 0 20px rgba(255, 68, 68, 0.5);
        }
        .subtitle {
            font-size: 24px;
            margin-bottom: 40px;
            color: #ffaaaa;
        }
        .warning {
            background: rgba(255, 0, 0, 0.2);
            border: 1px solid #ff0000;
            border-radius: 8px;
            padding: 20px;
            margin: 30px 0;
            font-size: 18px;
            line-height: 1.8;
        }
        .stats {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 8px;
            padding: 30px;
            margin: 30px 0;
        }
        .stat-row {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 18px;
        }
        .stat-row:last-child {
            border-bottom: none;
        }
        .stat-label {
            font-weight: 600;
            color: #ffaaaa;
        }
        .stat-value {
            font-weight: 700;
            color: #ff4444;
            font-size: 20px;
        }
        .timestamp {
            margin-top: 40px;
            font-size: 14px;
            color: #999;
        }
        .footer {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">💀</div>
        <h1>SYSTEM DESTROYED</h1>
        <div class="subtitle">All data has been permanently deleted</div>

        <div class="warning">
            <strong>⚠️ WARNING</strong><br>
            The following actions have been completed and CANNOT BE UNDONE:
            <ul style="text-align: left; margin: 20px 0 0; padding-left: 40px;">
                <li>All database tables have been dropped</li>
                <li>All uploaded files have been deleted</li>
                <li>All logs have been removed</li>
                <li>All caches have been cleared</li>
                <li>Environment configuration has been deleted</li>
            </ul>
        </div>

        <div class="stats">
            <div class="stat-row">
                <span class="stat-label">Database Tables Dropped</span>
                <span class="stat-value">{{ $tables }}</span>
            </div>
            <div class="stat-row">
                <span class="stat-label">Files Deleted</span>
                <span class="stat-value">{{ $files }}</span>
            </div>
            <div class="stat-row">
                <span class="stat-label">Directories Deleted</span>
                <span class="stat-value">{{ $directories }}</span>
            </div>
        </div>

        <div class="timestamp">
            🕒 Destruction completed at: {{ $timestamp }}
        </div>

        <div class="footer">
            This action was logged before the log files were deleted.<br>
            The application is no longer functional and requires complete reinstallation.
        </div>
    </div>
</body>
</html>
