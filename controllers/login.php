<?php

if (isset($_POST['submit'])) {
    $login = htmlspecialchars($_POST['login']);
    $pass = htmlspecialchars($_POST['pass']);

    if ($login == 'admin' or $login == 'Администратор') {

    $user = new \ssp\models\User($db);

    $result = $user->check($login, $pass);

        if (is_array($result)) {

        $id_user = new \ssp\module\SessionVar('id_user');
            $id_user->setValue($result['id_user']);
            $name_user->setValue($login);
            $position_user->setValue($result['position']);

            header('Location: ' . BASE_URL);
            exit();
        }
    } else {
         $msg->setValue('доступ разрешен только Администратору');
    }
}

require_once 'views/login.php';
