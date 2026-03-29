<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Test Email') }}1</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .header { background-color: #0ea5e9; padding: 32px 40px; text-align: center; }
        .header h1 { color: #ffffff; margin: 0; font-size: 22px; font-weight: 700; }
        .header p { color: rgba(255,255,255,0.85); margin: 8px 0 0; font-size: 14px; }
        .body { padding: 40px; color: #374151; }
        .body h2 { font-size: 18px; font-weight: 600; color: #111827; margin-top: 0; }
        .body p { font-size: 15px; line-height: 1.7; color: #4B5563; }
        .info-box { background: #f0f9ff; border-left: 4px solid #0ea5e9; border-radius: 4px; padding: 16px 20px; margin: 24px 0; }
        .info-box p { margin: 0; font-size: 14px; color: #0369a1; }
        .info-box strong { display: block; margin-bottom: 6px; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; color: #0c4a6e; }
        .footer { background: #f9fafb; border-top: 1px solid #e5e7eb; padding: 20px 40px; text-align: center; }
        .footer p { font-size: 12px; color: #9CA3AF; margin: 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ {{ __('Test Email') }}</h1>
            <p>{{ config('app.name') }}</p>
        </div>
        <div class="body">
            <h2>{{ __('Email configuration is working!') }}</h2>
            <p>{{ __('This is a test email sent from the application settings panel to verify that the email sending configuration is working correctly.') }}</p>

            <div class="info-box">
                <strong>{{ __('Configuration details') }}</strong>
                <p>📬 {{ __('Mailer') }}: <strong>{{ config('mail.default') }}</strong></p>
                <p>🌐 {{ __('Host') }}: <strong>{{ config('mail.mailers.' . config('mail.default') . '.host', 'N/A') }}</strong></p>
                <p>🔌 {{ __('Port') }}: <strong>{{ config('mail.mailers.' . config('mail.default') . '.port', 'N/A') }}</strong></p>
                <p>📧 {{ __('From') }}: <strong>{{ config('mail.from.address') }}</strong></p>
                <p>🕒 {{ __('Sent at') }}: <strong>{{ now()->format('Y-m-d H:i:s') }} ({{ config('app.timezone') }})</strong></p>
            </div>

            <p>{{ __('If you  received this email, your SMTP settings are configured correctly. No further action is needed.') }}</p>
        </div>
        <div class="footer">
            <p>{{ __('This is an automated test message from') }} {{ config('app.name') }}. {{ __('Please do not reply.') }}</p>
        </div>
    </div>
</body>
</html>
