<?php 
    session_start();
    require_once(__DIR__.'/../Session/Session.php');

    use App\Session\Session;

    $session = new Session();

    $cook = $session->getCookie('id');
    if ($cook){
        header('Location: ../templates/index.php');
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <script src="https://smartcaptcha.yandexcloud.net/captcha.js" defer></script>
    <title>Авторизация</title>
</head>
<body>
<div class="button-group">
        <a href="/app/templates/reg.php" class="button">Зарегистрироваться</a>
        <a href="/app/templates/auth.php" class="button">Войти</a>
        <a href="/app/templates/index.php" class="button">Главная</a>
        <a href="/app/templates/profile.php" class="button">Профиль</a>
        <a href="/app/Auth/Logout.php" class="button">Выход</a>
    </div>
<div class="container">
        <div class="form_top">
            <form action="/app/Auth/Authentication.php" method="POST">
                <label >Логин</label>
                <input placeholder="Введите номер телефона или почту" name="login">
                <label >Пароль</label>
                <input type="password" placeholder="Введите пароль" name="password">
                <div
                    id="captcha-container"
                    class="smart-captcha"
                    data-sitekey=""
                    data-hl="en"
                    data-callback="callback"
                >
                <input type="hidden" name="smart-token" >
            </div>
                <input type="submit" value="Войти">
            </form>
            <div><a href="/app/templates/reg.php">Зарегистрироваться</a></div>
            <?php
             if ($_SESSION['err'])
             {
                echo ' <div class="err">'.$_SESSION['err'].'</div>';
                unset($_SESSION['err']);
             }
            ?>
        </div>
    </div>

    </div>

    </div>
</body>
</html>