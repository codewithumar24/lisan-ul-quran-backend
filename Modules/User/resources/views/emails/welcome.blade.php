<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Lisan-ul-Quran</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #4CAF50; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #777; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Welcome to Lisan-ul-Quran</h1>
    </div>
    <div class="content">
        <p>Assalamu Alaikum {{ $user->first_name }},</p>
        <p>Thank you for registering with Lisan-ul-Quran. We're excited to have you on this journey to learn Quranic Arabic.</p>
        <p>Your account has been successfully created. You can now log in and start your learning journey.</p>
        <p>If you have any questions, please don't hesitate to contact us.</p>
        <p>JazakAllah Khair,<br>Lisan-ul-Quran Team</p>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} Lisan-ul-Quran. All rights reserved.
    </div>
</div>
</body>
</html>
