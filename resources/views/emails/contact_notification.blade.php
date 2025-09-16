<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Liên hệ mới</title>
</head>
<body>
    <h2>Liên hệ mới từ {{ $contact->name }}</h2>
    <p><strong>Email:</strong> {{ $contact->email }}</p>
    <p><strong>Điện thoại:</strong> {{ $contact->phone ?? 'Không có' }}</p>
    <hr>
    <p>{{ $contact->message }}</p>
</body>
</html>
