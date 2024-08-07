<?php

    session_start();

    require_once(__DIR__.'/../Session/Session.php');
    require_once(__DIR__ . '/../Database/DBConnection.php');

    use App\Session\Session;
    use App\Database\DBConnection;
    
    $session = new Session();
    $db = new DBConnection();

    $cook = $session->getCookie('id');
    if ($cook){
        $sql = 'select * from users where id = $1';
        $result = $db->query($sql, [$cook]);
        if ($result)
        {
            $user = $db->getRow($result);
        }
    }
    else {
        header('Location: ../templates/index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Профиль</title>
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
            <form action="/app/Profile/Profile.php" method="post">
                <label >Имя</label>
                <input type="text" placeholder="Введите имя" name="name" value="<?=$user[1]?>">
                <label >Tелефон</label>
                <input type="tel" placeholder="Введите номер телефона" name="phone" value="<?=$user[2]?>">
                <label >Почта</label>
                <input type="email" placeholder="Введите почту" name="email" value="<?=$user[3]?>">
                <label >Старый пароль</label>
                <input type="password" placeholder="Введите старый пароль" name="password" value="">
                <label >Новый пароль</label>
                <input type="password" placeholder="Введите новый пароль" name="confirmPassword" value="">
                <input type="submit">
            </form>
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