<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Contact Message</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
            margin: 0;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 3px solid #7c3aed;
        }
        .header h2 {
            color: #7c3aed;
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px 0;
        }
        .content p {
            margin: 8px 0;
            color: #333;
        }
        .content .label {
            font-weight: bold;
            color: #555;
        }
        .message-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #7c3aed;
            margin-top: 10px;
            color: #333;
            line-height: 1.6;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 12px;
            color: #6b7280;
        }
        .footer p {
            margin: 5px 0;
        }
    </style>
</head>
<body>

    <div class="container">

        {{-- HEADER --}}
        <div class="header">
            <h2>📬 New Contact Message</h2>
        </div>

        {{-- CONTENT --}}
        <div class="content">

            <p><span class="label">👤 From:</span> {{ $name }}</p>
            <p><span class="label">📧 Email:</span> <a href="mailto:{{ $email }}" style="color: #7c3aed;">{{ $email }}</a></p>
            <p><span class="label">📌 Subject:</span> {{ $subject }}</p>

            <p style="margin-top: 16px; font-weight: bold; color: #555;">💬 Message:</p>
            <div class="message-box">
                {{ $user_message }}
            </div>

        </div>

        {{-- FOOTER --}}
        <div class="footer">
            <p>This message was sent from the <strong>NovaCart</strong> Contact Form</p>
            <p>© {{ date('Y') }} NovaCart. All rights reserved.</p>
        </div>

    </div>

</body>
</html>