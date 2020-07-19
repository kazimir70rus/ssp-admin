<?php

    if (
        !empty($_REQUEST['password']) 
        and !empty($_REQUEST['password2'])
        and !empty($_REQUEST['login'])
    ) {

        //Пишем логин и пароль из формы в переменные (для удобства работы):
        $login = $_REQUEST['login']; 
        $password = $_REQUEST['password']; 
        $password2 = $_REQUEST['password2']; //подтверждение пароля

        //Если пароль и его подтверждение совпадают...
        if ($password == $password2) {
            
            $user = new \battle\models\User($db);
            $id_user = $user->add($login, $password);
            
            if ($id_user != -1) {
                header('Location: ' . BASE_URL);
                exit;
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
    } else {
//        $msg->setValue('Нет данных для регистрации');
    }
        
require_once 'views/registration.php';
