<?php

    if (
        !empty($_REQUEST['password']) 
        and !empty($_REQUEST['password2'])
        and !empty($_REQUEST['login'])
    ) {

        //����� ����� � ������ �� ����� � ���������� (��� �������� ������):
        $login = $_REQUEST['login']; 
        $password = $_REQUEST['password']; 
        $password2 = $_REQUEST['password2']; //������������� ������

        //���� ������ � ��� ������������� ���������...
        if ($password == $password2) {
            
            $user = new \battle\models\User($db);
            $id_user = $user->add($login, $password);
            
            if ($id_user != -1) {
                header('Location: ' . BASE_URL);
                exit;
            } else {
                if ($db->errInfo[1] == 1062) {
                    $msg->setValue('������! ����������� � ����� ������ ���� � ����');
                } else {
                    $msg->setValue('������ ��� ���������� ������������');
                } 

            }
        } else {
            $msg->setValue('������ �� ���������');
        }
    } else {
//        $msg->setValue('��� ������ ��� �����������');
    }
        
require_once 'views/registration.php';
