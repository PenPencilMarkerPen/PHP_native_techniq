<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Регистрация</title>
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
            <form action="/app/Auth/Registration.php" method="post">
                <label >Имя</label>
                <input type="text" placeholder="Введите имя" name="name">
                <label >Tелефон</label>
                <input type="tel" placeholder="Введите номер телефона" name="phone">
                <label >Почта</label>
                <input type="email" placeholder="Введите почту" name="email">
                <label >Пароль</label>
                <input type="password" placeholder="Введите пароль" name="password">
                <label >Повтор пароля</label>
                <input type="password" placeholder="Подтвердите пароль" name="confirmPassword">
                <button type="submit">Зарегистрироваться </button>
            </form>
            <div><a href="/app/templates/auth.php">Авторизоваться</a></div>
            <?php
             if ($_SESSION['err'])
             {
                echo ' <div class="err">'.$_SESSION['err'].'</div>';
                unset($_SESSION['err']);
             }
            ?>
        </div>
    </div>
</body>
</html>