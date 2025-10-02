<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(to right, #fb7185, #ec4899);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9fafb;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .otp-box {
            background: white;
            border: 3px solid #fb7185;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            margin: 20px 0;
        }
        .otp-code {
            font-size: 36px;
            font-weight: bold;
            color: #fb7185;
            letter-spacing: 8px;
        }
        .footer {
            text-align: center;
            color: #666;
            font-size: 12px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>BlissCakes Password Reset</h1>
        </div>
        <div class="content">
            <p>Hello {{ $user->name }},</p>
            <p>You requested to reset your password. Use the OTP code below to proceed:</p>
            
            <div class="otp-box">
                <p style="margin: 0; color: #666;">Your OTP Code</p>
                <p class="otp-code">{{ $otp }}</p>
                <p style="margin: 0; color: #666; font-size: 14px;">Valid for 10 minutes</p>
            </div>
            
            <p><strong>Security Tips:</strong></p>
            <ul>
                <li>Never share this code with anyone</li>
                <li>BlissCakes will never ask for your OTP via phone or email</li>
                <li>If you didn't request this, please ignore this email</li>
            </ul>
            
            <p>Thank you,<br>BlissCakes Team</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} BlissCakes. All rights reserved.</p>
        </div>
    </div>
</body>
</html>