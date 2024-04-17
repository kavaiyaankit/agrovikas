<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login OTP</title>
</head>
<body>
    <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2>Login OTP</h2>
        <p>Your OTP (One-Time Password) for login is:</p>
        <div style="background-color: #f4f4f4; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
            <h3 style="margin-top: 0; font-weight: bold; font-size: 24px;">{{ $otp }}</h3>
        </div>
        <p>Please use this OTP to log in to your account. Note that this OTP is valid for a single use only and will expire after a short period of time.</p>
        <p>If you did not request this OTP, please disregard this email.</p>
        <p>Thank you,<br></p>
    </div>
</body>
</html>
