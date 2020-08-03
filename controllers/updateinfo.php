<?php

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Пишем логин и пароль из формы в переменные (для удобства работы)
    $json_userData = file_get_contents('php://input');
    $info = json_decode($json_userData, true);

    $info['password'] = $info['password'] ?? '';
    $info['password2'] = $info['password2'] ?? '';

    //Если пароль и его подтверждение совпадают...
    if ($info['password'] == $info['password2']) {

        $user = new \ssp\models\User($db);

        $info['id_position'] = $user->getIdPosition($info['position']);

        $info['is_controller'] = ($info['is_controller'] == true) ? 1 : 0;

        $result = $user->update($info);

        if ($result != -1) {
            $message = 'Данные пользователя обновлены';
        } else {
            if ($db->errInfo[1] == 1062) {
                $message = 'Ошибка! Пользоватeль с таким именем зарегистрирован';
            } else {
                $message = 'Ошибка при обновлении данных';
            } 
        }
    } else {
        $message = 'Пароль не совпадает';
    }
}

\ssp\module\Tools::send_json(['message' => $message]);

