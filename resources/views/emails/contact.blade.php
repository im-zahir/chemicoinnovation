<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Contact Form Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #0d6efd;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f8f9fa;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 0 0 5px 5px;
        }
        .field {
            margin-bottom: 15px;
        }
        .label {
            font-weight: bold;
            color: #495057;
        }
        .value {
            margin-top: 5px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>New Contact Form Submission</h2>
    </div>
    
    <div class="content">
        <div class="field">
            <div class="label">Name:</div>
            <div class="value">{{ $name }}</div>
        </div>

        <div class="field">
            <div class="label">Email:</div>
            <div class="value">{{ $email }}</div>
        </div>

        @if(isset($phone))
        <div class="field">
            <div class="label">Phone:</div>
            <div class="value">{{ $phone }}</div>
        </div>
        @endif

        <div class="field">
            <div class="label">Subject:</div>
            <div class="value">{{ $subject }}</div>
        </div>

        <div class="field">
            <div class="label">Message:</div>
            <div class="value">{{ $message }}</div>
        </div>
    </div>

    <div class="footer">
        <p>This email was sent from the contact form at {{ config('app.name') }}</p>
        <p>{{ now()->format('Y-m-d H:i:s') }}</p>
    </div>
</body>
</html>
