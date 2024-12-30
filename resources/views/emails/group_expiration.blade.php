
<!DOCTYPE html>
<html>
<head>
    <title>Уведомление об истечении участия в группе</title>
</head>
<body>
    <p>Здравствуйте, {{ $userName }}!</p>
<p>Истекло время вашего участия в группе {{ $groupName }}.</p>
<p>С уважением, команда {{ config('app.name') }}.</p>
</body>
</html>
