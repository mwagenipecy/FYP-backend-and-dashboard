<?php
namespace App\Services;

// Method 1: Using Laravel's Mail facade with raw HTML content
use Illuminate\Support\Facades\Mail;

class DirectEmailService
{
    /**
     * Send email using Mail::raw() - Simple text email
     */
    public static function sendSimpleEmail($to, $subject, $message)
    {
        try {
            Mail::raw($message, function ($mail) use ($to, $subject) {
                $mail->to($to)
                     ->subject($subject)
                     ->from(config('mail.from.address'), config('mail.from.name'));
            });
            
            return ['success' => true, 'message' => 'Email sent successfully'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Failed to send email: ' . $e->getMessage()];
        }
    }

    /**
     * Send HTML email using Mail::html() - Rich HTML content
     */
    public static function sendHtmlEmail($to, $subject, $htmlContent, $attachments = [])
    {
        try {
            Mail::html($htmlContent, function ($mail) use ($to, $subject, $attachments) {
                $mail->to($to)
                     ->subject($subject)
                     ->from(config('mail.from.address'), config('mail.from.name'));
                
                // Add attachments if provided
                foreach ($attachments as $attachment) {
                    if (isset($attachment['path'])) {
                        $mail->attach($attachment['path'], [
                            'as' => $attachment['name'] ?? basename($attachment['path']),
                            'mime' => $attachment['mime'] ?? null
                        ]);
                    }
                }
            });
            
            return ['success' => true, 'message' => 'HTML email sent successfully'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Failed to send email: ' . $e->getMessage()];
        }
    }

    /**
     * Send email with inline template (no view file needed)
     */
    public static function sendTemplatedEmail($to, $subject, $data = [])
    {
        $htmlTemplate = self::getEmailTemplate($data);
        
        try {
            Mail::html($htmlTemplate, function ($mail) use ($to, $subject) {
                $mail->to($to)
                     ->subject($subject)
                     ->from(config('mail.from.address'), config('mail.from.name'));
            });
            
            return ['success' => true, 'message' => 'Templated email sent successfully'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Failed to send email: ' . $e->getMessage()];
        }
    }

    /**
     * Send welcome email to new users
     */
    public static function sendWelcomeEmail($user, $password = null)
    {
        $subject = 'Welcome to ' . config('app.name');
        
        $htmlContent = self::buildWelcomeEmailTemplate([
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_type' => ucfirst($user->userType ?? 'User'),
            'password' => $password,
            'login_url' => url('/login'),
            'app_name' => config('app.name'),
            'app_url' => config('app.url')
        ]);

        return self::sendHtmlEmail($user->email, $subject, $htmlContent);
    }

    /**
     * Send password reset email
     */
    public static function sendPasswordResetEmail($user, $newPassword)
    {
        $subject = 'Password Reset - ' . config('app.name');
        
        $htmlContent = self::buildPasswordResetTemplate([
            'user_name' => $user->name,
            'new_password' => $newPassword,
            'login_url' => url('/login'),
            'app_name' => config('app.name')
        ]);

        return self::sendHtmlEmail($user->email, $subject, $htmlContent);
    }

    /**
     * Send account status change notification
     */
    public static function sendStatusChangeEmail($user, $oldStatus, $newStatus, $reason = null)
    {
        $subject = 'Account Status Update - ' . config('app.name');
        
        $htmlContent = self::buildStatusChangeTemplate([
            'user_name' => $user->name,
            'old_status' => ucfirst($oldStatus),
            'new_status' => ucfirst($newStatus),
            'reason' => $reason,
            'app_name' => config('app.name'),
            'support_email' => config('mail.from.address')
        ]);

        return self::sendHtmlEmail($user->email, $subject, $htmlContent);
    }

    /**
     * Send bulk emails to multiple recipients
     */
    public static function sendBulkEmail($recipients, $subject, $htmlContent)
    {
        $results = [];
        
        foreach ($recipients as $recipient) {
            $email = is_array($recipient) ? $recipient['email'] : $recipient;
            $name = is_array($recipient) ? $recipient['name'] ?? '' : '';
            
            // Personalize content if name is provided
            $personalizedContent = $name ? str_replace('{{name}}', $name, $htmlContent) : $htmlContent;
            
            $result = self::sendHtmlEmail($email, $subject, $personalizedContent);
            $results[] = [
                'email' => $email,
                'success' => $result['success'],
                'message' => $result['message']
            ];
        }
        
        return $results;
    }

    /**
     * Generic email template
     */
    private static function getEmailTemplate($data)
    {
        $title = $data['title'] ?? 'Notification';
        $content = $data['content'] ?? 'This is a notification email.';
        $buttonText = $data['button_text'] ?? null;
        $buttonUrl = $data['button_url'] ?? null;
        $appName = config('app.name');

        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1'>
            <title>{$title}</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
                .container { max-width: 600px; margin: 0 auto; background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
                .header { text-align: center; padding: 20px 0; border-bottom: 1px solid #eee; }
                .content { padding: 20px 0; }
                .button { display: inline-block; padding: 12px 24px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px; margin: 20px 0; }
                .footer { text-align: center; padding: 20px 0; border-top: 1px solid #eee; font-size: 12px; color: #666; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>{$appName}</h1>
                </div>
                <div class='content'>
                    <h2>{$title}</h2>
                    <p>{$content}</p>
                    " . ($buttonText && $buttonUrl ? "<a href='{$buttonUrl}' class='button'>{$buttonText}</a>" : "") . "
                </div>
                <div class='footer'>
                    <p>&copy; " . date('Y') . " {$appName}. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>";
    }

    /**
     * Welcome email template
     */
    private static function buildWelcomeEmailTemplate($data)
    {
        $passwordSection = $data['password'] ? "
            <div style='background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;'>
                <h4 style='margin: 0 0 10px 0; color: #495057;'>Your Login Credentials:</h4>
                <p style='margin: 5px 0;'><strong>Email:</strong> {$data['user_email']}</p>
                <p style='margin: 5px 0;'><strong>Password:</strong> <code style='background-color: #e9ecef; padding: 2px 6px; border-radius: 3px;'>{$data['password']}</code></p>
                <p style='margin: 10px 0 0 0; font-size: 12px; color: #6c757d;'>Please change your password after first login for security.</p>
            </div>
        " : "";

        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1'>
            <title>Welcome to {$data['app_name']}</title>
            <style>
                body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f8f9fa; }
                .container { max-width: 600px; margin: 20px auto; background-color: #fff; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1); overflow: hidden; }
                .header { background: linear-gradient(135deg, #007bff, #0056b3); color: #fff; padding: 30px 20px; text-align: center; }
                .content { padding: 30px 20px; }
                .button { display: inline-block; padding: 12px 30px; background: linear-gradient(135deg, #28a745, #20c997); color: #fff; text-decoration: none; border-radius: 25px; margin: 20px 0; font-weight: bold; }
                .footer { background-color: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; color: #6c757d; }
                .welcome-badge { background-color: #28a745; color: white; padding: 5px 15px; border-radius: 15px; font-size: 12px; display: inline-block; margin-bottom: 20px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1 style='margin: 0; font-size: 28px;'>Welcome to {$data['app_name']}!</h1>
                    <p style='margin: 10px 0 0 0; opacity: 0.9;'>Your account has been created successfully</p>
                </div>
                <div class='content'>
                    <div class='welcome-badge'>{$data['user_type']} Account</div>
                    <h2 style='color: #007bff; margin-bottom: 20px;'>Hello {$data['user_name']}!</h2>
                    <p>We're excited to have you join our platform. Your account has been set up and you're ready to get started.</p>
                    
                    {$passwordSection}
                    
                    <p>To access your account, simply click the button below:</p>
                    <div style='text-align: center;'>
                        <a href='{$data['login_url']}' class='button'>Login to Your Account</a>
                    </div>
                    
                    <p style='margin-top: 30px; font-size: 14px; color: #6c757d;'>
                        If you have any questions or need assistance, please don't hesitate to contact our support team.
                    </p>
                </div>
                <div class='footer'>
                    <p>&copy; " . date('Y') . " {$data['app_name']}. All rights reserved.</p>
                    <p>This email was sent to {$data['user_email']}</p>
                </div>
            </div>
        </body>
        </html>";
    }

    /**
     * Password reset email template
     */
    private static function buildPasswordResetTemplate($data)
    {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1'>
            <title>Password Reset - {$data['app_name']}</title>
            <style>
                body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f8f9fa; }
                .container { max-width: 600px; margin: 20px auto; background-color: #fff; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1); overflow: hidden; }
                .header { background: linear-gradient(135deg, #dc3545, #c82333); color: #fff; padding: 30px 20px; text-align: center; }
                .content { padding: 30px 20px; }
                .password-box { background-color: #f8f9fa; border-left: 4px solid #dc3545; padding: 20px; margin: 20px 0; border-radius: 5px; }
                .button { display: inline-block; padding: 12px 30px; background: linear-gradient(135deg, #007bff, #0056b3); color: #fff; text-decoration: none; border-radius: 25px; margin: 20px 0; font-weight: bold; }
                .footer { background-color: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; color: #6c757d; }
                .warning { background-color: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; margin: 20px 0; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1 style='margin: 0; font-size: 28px;'>🔐 Password Reset</h1>
                    <p style='margin: 10px 0 0 0; opacity: 0.9;'>Your password has been reset</p>
                </div>
                <div class='content'>
                    <h2 style='color: #dc3545; margin-bottom: 20px;'>Hello {$data['user_name']}</h2>
                    <p>Your password has been reset by an administrator. Here are your new login credentials:</p>
                    
                    <div class='password-box'>
                        <h4 style='margin: 0 0 10px 0; color: #495057;'>🔑 New Password:</h4>
                        <p style='font-size: 18px; font-weight: bold; color: #dc3545; font-family: monospace; margin: 10px 0;'>{$data['new_password']}</p>
                    </div>
                    
                    <div class='warning'>
                        <p style='margin: 0; font-size: 14px;'><strong>⚠️ Security Notice:</strong> Please change this password immediately after logging in for security purposes.</p>
                    </div>
                    
                    <div style='text-align: center;'>
                        <a href='{$data['login_url']}' class='button'>Login Now</a>
                    </div>
                    
                    <p style='margin-top: 30px; font-size: 14px; color: #6c757d;'>
                        If you did not request this password reset, please contact support immediately.
                    </p>
                </div>
                <div class='footer'>
                    <p>&copy; " . date('Y') . " {$data['app_name']}. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>";
    }

    /**
     * Status change email template
     */
    private static function buildStatusChangeTemplate($data)
    {
        $statusColors = [
            'Active' => '#28a745',
            'Inactive' => '#6c757d',
            'Disabled' => '#ffc107',
            'Blocked' => '#dc3545',
            'Pending' => '#007bff'
        ];

        $statusColor = $statusColors[$data['new_status']] ?? '#007bff';
        $reasonSection = $data['reason'] ? "<p><strong>Reason:</strong> {$data['reason']}</p>" : "";

        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1'>
            <title>Account Status Update - {$data['app_name']}</title>
            <style>
                body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f8f9fa; }
                .container { max-width: 600px; margin: 20px auto; background-color: #fff; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1); overflow: hidden; }
                .header { background: linear-gradient(135deg, {$statusColor}, " . self::darkenColor($statusColor, 20) . "); color: #fff; padding: 30px 20px; text-align: center; }
                .content { padding: 30px 20px; }
                .status-change { background-color: #f8f9fa; border-left: 4px solid {$statusColor}; padding: 20px; margin: 20px 0; border-radius: 5px; }
                .footer { background-color: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; color: #6c757d; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1 style='margin: 0; font-size: 28px;'>📢 Account Status Update</h1>
                </div>
                <div class='content'>
                    <h2 style='color: {$statusColor}; margin-bottom: 20px;'>Hello {$data['user_name']}</h2>
                    <p>Your account status has been updated. Here are the details:</p>
                    
                    <div class='status-change'>
                        <p><strong>Previous Status:</strong> <span style='color: #6c757d;'>{$data['old_status']}</span></p>
                        <p><strong>New Status:</strong> <span style='color: {$statusColor}; font-weight: bold;'>{$data['new_status']}</span></p>
                        {$reasonSection}
                    </div>
                    
                    <p style='margin-top: 30px; font-size: 14px; color: #6c757d;'>
                        If you have questions about this change, please contact our support team at {$data['support_email']}.
                    </p>
                </div>
                <div class='footer'>
                    <p>&copy; " . date('Y') . " {$data['app_name']}. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>";
    }

    /**
     * Helper function to darken a hex color
     */
    private static function darkenColor($hex, $percent)
    {
        $hex = str_replace('#', '', $hex);
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        
        $r = max(0, min(255, $r - ($r * $percent / 100)));
        $g = max(0, min(255, $g - ($g * $percent / 100)));
        $b = max(0, min(255, $b - ($b * $percent / 100)));
        
        return sprintf("#%02x%02x%02x", $r, $g, $b);
    }
}

// Usage Examples:

// Example 1: Simple text email
/*
$result = DirectEmailService::sendSimpleEmail(
    'user@example.com',
    'Simple Notification',
    'This is a simple text email message.'
);
*/

// Example 2: HTML email with custom content
/*
$htmlContent = '<h1>Welcome!</h1><p>This is an HTML email with <strong>formatting</strong>.</p>';
$result = DirectEmailService::sendHtmlEmail(
    'user@example.com',
    'HTML Newsletter',
    $htmlContent
);
*/

// Example 3: Send welcome email to new user
/*
$user = User::find(1);
$password = 'temp123';
$result = DirectEmailService::sendWelcomeEmail($user, $password);
*/

// Example 4: Send password reset email
/*
$user = User::find(1);
$newPassword = Str::random(8);
$result = DirectEmailService::sendPasswordResetEmail($user, $newPassword);
*/

// Example 5: Send status change notification
/*
$user = User::find(1);
$result = DirectEmailService::sendStatusChangeEmail(
    $user, 
    'active', 
    'disabled', 
    'Account disabled due to policy violation'
);
*/

// Example 6: Send bulk emails
/*
$recipients = [
    ['email' => 'user1@example.com', 'name' => 'John Doe'],
    ['email' => 'user2@example.com', 'name' => 'Jane Smith'],
    'user3@example.com' // Without name
];

$htmlContent = '<h1>Hello {{name}}!</h1><p>This is a bulk email.</p>';
$results = DirectEmailService::sendBulkEmail($recipients, 'Bulk Notification', $htmlContent);
*/

// Example 7: Custom templated email
/*
$result = DirectEmailService::sendTemplatedEmail(
    'user@example.com',
    'Custom Notification',
    [
        'title' => 'Important Update',
        'content' => 'Your account has been updated with new features.',
        'button_text' => 'View Changes',
        'button_url' => 'https://example.com/updates'
    ]
);
*/