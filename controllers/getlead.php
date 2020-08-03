<?php

$id_lead = (int)$param[1];

$users = new \ssp\models\User($db);

$info_lead = $users->getUserInfo($id_lead);

\ssp\module\Tools::send_json($info_lead);

