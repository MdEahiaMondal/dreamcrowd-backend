<?php

namespace App\Console\Commands;

use App\Mail\DailySystemReport;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendDailySystemReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:send-daily-system-report {--dry-run : Run without sending email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily system information report via email including domain info, machine details, and admin credentials';

    /**
     * Notification service instance
     *
     * @var NotificationService
     */
    protected $notificationService;

    /**
     * Create a new command instance.
     *
     * @param NotificationService $notificationService
     * @return void
     */
    public function __construct(NotificationService $notificationService)
    {
        parent::__construct();
        $this->notificationService = $notificationService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $isDryRun = $this->option('dry-run');

        if ($isDryRun) {
            $this->info('🔍 Running in DRY RUN mode - no actual email will be sent');
        }

        Log::info('========================================');
        Log::info('Daily system report command started', [
            'timestamp' => now()->toDateTimeString(),
            'dry_run' => $isDryRun
        ]);

        try {
            $this->info('📊 Collecting system information...');

            // Collect system information
            $systemInfo = $this->collectSystemInfo();

            // Get admin credentials
            $adminCredentials = $this->getAdminCredentials();

            // Get recipient email from environment variable
            $recipientEmail = env('DAILY_REPORT_EMAIL');

            if (!$recipientEmail) {
                $this->error('❌ DAILY_REPORT_EMAIL not configured in .env file');
                Log::error('Daily system report failed: DAILY_REPORT_EMAIL not configured');
                return 1;
            }

            $this->info('✓ System information collected');
            $this->line('  - Domain: ' . $systemInfo['domain']);
            $this->line('  - Hostname: ' . $systemInfo['hostname']);
            $this->line('  - Environment: ' . $systemInfo['environment']);

            if (!$isDryRun) {
                // Send email
                $this->info('📧 Sending daily system report to: ' . $recipientEmail);
$this->info('email koi');
                Mail::to($recipientEmail)->send(new DailySystemReport($systemInfo, $adminCredentials));

                $this->info('✓ Daily system report email sent successfully');
            } else {
                $this->info('📧 [DRY RUN] Would send email to: ' . $recipientEmail);
            }

            Log::info('Daily system report command completed', [
                'timestamp' => now()->toDateTimeString(),
                'recipient' => $recipientEmail,
                'domain' => $systemInfo['domain'],
                'environment' => $systemInfo['environment'],
                'dry_run' => $isDryRun
            ]);

            return 0;

        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            Log::error('Daily system report command failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Notify admins of command failure
            $adminIds = User::where('role', 2)->pluck('id')->toArray();
            if (!empty($adminIds) && !$isDryRun) {
                $this->notificationService->sendToMultipleUsers(
                    userIds: $adminIds,
                    type: 'system',
                    title: 'Scheduled Command Failed',
                    message: "Scheduled command 'reports:send-daily-system-report' failed. Error: {$e->getMessage()}",
                    data: [
                        'command' => $this->signature,
                        'error' => $e->getMessage(),
                        'timestamp' => now()->toISOString()
                    ],
                    sendEmail: true
                );
            }

            return 1;
        }
    }

    /**
     * Collect system information
     *
     * @return array
     */
    protected function collectSystemInfo()
    {
        // Get domain/URL
        $domain = config('app.url');

        // Get server hostname
        $hostname = gethostname();

        // Get server IP address
        $ipAddress = gethostbyname($hostname);

        // Get operating system information
        $os = php_uname();

        // Get PHP version
        $phpVersion = phpversion();

        // Get Laravel version
        $laravelVersion = App::version();

        // Get environment
        $environment = config('app.env');

        // Get disk space
        $diskTotal = $this->formatBytes(disk_total_space('/'));
        $diskFree = $this->formatBytes(disk_free_space('/'));

        // Get memory limit
        $memoryLimit = ini_get('memory_limit');

        // Get server time
        $serverTime = now()->format('Y-m-d H:i:s T');

        return [
            'domain' => $domain,
            'hostname' => $hostname,
            'ip_address' => $ipAddress,
            'os' => $os,
            'php_version' => $phpVersion,
            'laravel_version' => $laravelVersion,
            'environment' => $environment,
            'disk_total' => $diskTotal,
            'disk_free' => $diskFree,
            'memory_limit' => $memoryLimit,
            'server_time' => $serverTime,
        ];
    }

    /**
     * Get admin credentials
     *
     * @return array
     */
    protected function getAdminCredentials()
    {
        // Try to get from environment variables first
        $adminUsername = env('ADMIN_USERNAME', 'Not configured');
        $adminPassword = env('ADMIN_PASSWORD', 'Not configured');

        // If not in env, try to get first admin user from database
        if ($adminUsername === 'Not configured') {
            $adminUser = User::where('role', 2)->first();
            if ($adminUser) {
                $adminUsername = $adminUser->email;
                $adminPassword = '(Stored in database - hashed)';
            }
        }

        return [
            'username' => $adminUsername,
            'password' => $adminPassword,
        ];
    }

    /**
     * Format bytes to human readable format
     *
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    protected function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
