<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $isUserCopy ? 'Thank you for contacting us' : 'New Contact Form Submission' }}</title>
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
            background-color: #1a56db;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f8fafc;
            padding: 20px;
            border: 1px solid #e2e8f0;
            border-radius: 0 0 5px 5px;
        }
        .message-box {
            background-color: white;
            padding: 15px;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            margin-top: 15px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #64748b;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ $isUserCopy ? 'Thank you for contacting us' : 'New Contact Form Submission' }}</h2>
    </div>
    
    <div class="content">
        @if($isUserCopy)
            <p>Dear {{ $contact->name }},</p>
            <p>Thank you for contacting Chemico. We have received your message and will get back to you as soon as possible.</p>
            <p>Here's a copy of your message:</p>
        @else
            <p>A new contact form submission has been received:</p>
        @endif

        <div class="message-box">
            <p><strong>Name:</strong> {{ $contact->name }}</p>
            <p><strong>Email:</strong> {{ $contact->email }}</p>
            <p><strong>Subject:</strong> {{ $contact->subject }}</p>
            <p><strong>Message:</strong></p>
            <p style="white-space: pre-wrap;">{{ $contact->message }}</p>
        </div>
        
        @if($isUserCopy)
            <p>If you have any additional questions, please don't hesitate to contact us.</p>
        @endif
    </div>

    <div class="footer">
        <p> {{ date('Y') }} Chemico. All rights reserved.</p>
    </div>
</body>
</html>
