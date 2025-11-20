<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добро пожаловать в нашу платформу!</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #923A3A;">Добро пожаловать в нашу платформу!</h1>
        
        <p>Здравствуйте, {{ $user->name }}!</p>
        
        <p>Благодарим вас за регистрацию на нашей платформе в качестве продавца.</p>
        
        <p>Ваши данные для входа:</p>
        
        <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
            <tr>
                <td style="border: 1px solid #ddd; padding: 10px; font-weight: bold;">Email:</td>
                <td style="border: 1px solid #ddd; padding: 10px;">{{ $user->email }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #ddd; padding: 10px; font-weight: bold;">Пароль:</td>
                <td style="border: 1px solid #ddd; padding: 10px;">{{ $password }}</td>
            </tr>
        </table>
        
        <p>
            <a href="{{ route('login') }}" 
               style="display: inline-block; padding: 10px 20px; background-color: #923A3A; color: white; text-decoration: none; border-radius: 5px;">
                Войти в личный кабинет
            </a>
        </p>
        
        <p>После входа в систему мы настоятельно рекомендуем вам изменить пароль в настройках профиля.</p>
        
        <p>Если у вас возникнут какие-либо вопросы, пожалуйста, не стесняйтесь обращаться в нашу службу поддержки.</p>
        
        <p>С уважением,<br>
        Команда платформы</p>
    </div>
</body>
</html>