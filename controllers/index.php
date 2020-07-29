<?php

$name_parent = new \ssp\models\User($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Пишем логин и пароль из формы в переменные (для удобства работы)
    $json_userData = file_get_contents('php://input');
    $info = json_decode($json_userData, true);

    //Если пароль и его подтверждение совпадают...
    if ($info['password'] == $info['password2']) {

        $user = new \ssp\models\User($db);

        $info['id_position'] = $user->getIdPosition($info['position']);

        $info['is_controller'] = isset($info['is_controller']) ? 1 : 0;
        $id_user = $user->add($info);
        
        if ($id_user != -1) {
            $message = 'Пользователь добавлен';
        } else {
            if ($db->errInfo[1] == 1062) {
                $message = 'Ошибка! Пользоватль с таким именем есть в базе';
            } else {
                $message = 'Ошибка при добавлении пользователя';
            } 
        }
    } else {
        $message = 'Пароль не совпадает';
    }

    \ssp\module\Tools::send_json(['message' => $message]);
    exit;
}

$list_parent = $name_parent->getListParents();      

require_once 'views/index.php';

