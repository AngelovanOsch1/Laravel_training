<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>New Contact Us Message</title>
</head>
<body>
    <h2>New message from {{ $name }}</h2>

    <p><strong>Email:</strong> {{ $email }}</p>

    <p><strong>Message:</strong></p>
    <p>{{ $messageContent }}</p>
</body>
</html>
