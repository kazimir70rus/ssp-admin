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

    <div class="wdth">
        <h3>Авторизация</h3>
    </div>

    <form method="post">
        <input type="text" name="login">
        <input type="password" name="pass">
        <input type="submit" name="submit" value="Вход">
    </form>

    <br>
    <div><?=$msg->popValue()?></div>

</div>

</body>
</html>
