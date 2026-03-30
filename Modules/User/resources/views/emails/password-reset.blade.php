<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #FF9800; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background: #FF9800;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #777; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Password Reset Request</h1>
    </div>
    <div class="content">
        <p>Assalamu Alaikum {{ $user->first_name }},</p>
        <p>We received a request to reset your password for your Lisan-ul-Quran account.</p>

        <p>Click the button below to reset your password:</p>

        <p style="text-align: center;">
            <a href="{{ url('/reset-password?token=' . $token . '&email=' . urlencode($user->email)) }}" class="button">
                Reset Password
            </a>
        </p>

        <p>This password reset link will expire in 60 minutes.</p>
        <p>If you didn't request a password reset, please ignore this email or contact support.</p>

        <p>JazakAllah Khair,<br>Lisan-ul-Quran Team</p>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} Lisan-ul-Quran. All rights reserved.
    </div>
</div>
</body>
</html>
