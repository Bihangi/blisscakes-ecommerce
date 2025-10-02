<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(to right, #ec4899, #ef4444); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #fdf2f8; padding: 30px; border-radius: 0 0 10px 10px; }
        .code-box { background: white; border: 3px solid #ec4899; padding: 20px; text-align: center; border-radius: 10px; margin: 20px 0; }
        .code { font-size: 36px; font-weight: bold; color: #ec4899; letter-spacing: 8px; }
        .footer { text-align: center; color: #666; font-size: 12px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Login Verification Code</h1>
        </div>
        <div class="content">
            <p>Hello {{ $user->name }},</p>
            <p>Someone is trying to log into your BlissCakes account. Use the code below to complete your login:</p>
            
            <div class="code-box">
                <p style="margin: 0; color: #666;">Your Verification Code</p>
                <p class="code">{{ $code }}</p>
                <p style="margin: 0; color: #666; font-size: 14px;">Valid for 10 minutes</p>
            </div>
            
            <p><strong>Security Tips:</strong></p>
            <ul>
                <li>Never share this code with anyone</li>
                <li>BlissCakes staff will never ask for this code</li>
                <li>If you didn't attempt to log in, change your password immediately</li>
            </ul>
            
            <p>Thank you,<br>BlissCakes Security Team</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} BlissCakes. All rights reserved.</p>
        </div>
    </div>
</body>
</html>