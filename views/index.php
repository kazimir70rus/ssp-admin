<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link href="<?=BASE_URL?>css/main.css" rel="stylesheet" type="text/css">

</head>
<body>
<?php require_once 'logout.html' ?>

<h3>страница для Админа</h3>

<!--<div align="center">-->
    <form method="post">
        Логин:<br><input type="text" name="login" id="login"><br>
        Должность:<br><input type="text" name="position" id="position"><br>
        Родитель:<br><input type="text" name="parent" id="parent"><br>
        Организация:<br><input type="text" name="organisation" id="organisation"><br>
        Пароль:<br><input type="password" name="password" id="pass"><br>
        Подтверждение:<br><input type="password" name="password2" id="re_pass" ><br>
        <input type="submit" name="GO" value="Регистрация">
    </form>
<!--</div>-->

<div><?=$msg->popValue()?></div>

</body>
</html>