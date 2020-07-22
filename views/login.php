<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link href="<?=BASE_URL?>css/main.css" rel="stylesheet" type="text/css">
</head>
<body>

<div id="app">

<form method="post">

    <h3>Авторизация</h3><br>

    <form method="post">
        Логин:<br>
        <input type="text" name="login" class="input input_text"><br>
        Пароль:<br>
        <input type="password" name="pass" class="input input_text"><br>
        <input type="submit" name="submit" value="Вход" class="input input_button"><br>
    </form>

    <br>
    <div><?=$msg->popValue()?></div>

</div>

</body>
</html>
