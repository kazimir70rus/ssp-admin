<?php

$name_parent = new \ssp\models\User($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Пишем логин и пароль из формы в переменные (для удобства работы):
    $login = htmlspecialchars($_POST['login']); 
    $password = htmlspecialchars($_POST['password']);
    $password2 = htmlspecialchars($_POST['password2']); //подтверждение пароля

    //Если пароль и его подтверждение совпадают...
    if ($password == $password2) {

        $user = new \ssp\models\User($db);
        $info = [];
        $info['login'] = htmlspecialchars($_POST['login']);
        $info['password'] = htmlspecialchars($_POST['password']);

        $info['id_position'] = $user->getIdPosition(htmlspecialchars($_POST['position']));

        $info['id_parent'] = (int)$_POST['id_parent'];
        $info['id_org'] = (int)$_POST['id_org'];
        $info['is_controller'] = isset($_POST['is_controller']) ? 1 : 0;
        $id_user = $user->add($info);
        
        if ($id_user != -1) {
            $msg->setValue('Пользователь добавлен');
        } else {
            if ($db->errInfo[1] == 1062) {
                $msg->setValue('Ошибка! Пользоватль с таким именем есть в базе');
            } else {
                $msg->setValue('Ошибка при добавлении пользователя');
            } 
        }
    } else {
        $msg->setValue('Пароль не совпадает');
    }
}

$list_parent = $name_parent->getListParents();      

require_once 'views/index.php';

