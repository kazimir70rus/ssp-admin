<?php

$id_user = (int)$param[1];

$users = new \ssp\models\User($db);

$info = $users->getUserInfo($id_user);

\ssp\module\Tools::send_json($info);

