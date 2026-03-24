<!DOCTYPE html>
<html>
<head>
    <title>Account Created</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #2196F3; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .credentials { background: #e3f2fd; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #777; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Account Created Successfully</h1>
    </div>
    <div class="content">
        <p>Assalamu Alaikum {{ $user->first_name }},</p>
        <p>An account has been created for you on Lisan-ul-Quran platform.</p>

        <div class="credentials">
            <h3>Your Login Credentials:</h3>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Password:</strong> {{ $password }}</p>
            <p><em>Please change your password after logging in for security.</em></p>
        </div>

        <p>You can log in to your account and start your learning journey.</p>
        <p>If you have any questions, please contact the administrator.</p>
        <p>JazakAllah Khair,<br>Lisan-ul-Quran Team</p>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} Lisan-ul-Quran. All rights reserved.
    </div>
</div>
</body>
</html>
