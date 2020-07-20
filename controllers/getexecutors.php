<?php

$id_lead = (int)$param[1];

$users = new \ssp\models\User($db);

$list_subordinate = $users->getSubordinate($id_lead);

\ssp\module\Tools::send_json($list_subordinate);

