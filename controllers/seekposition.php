<?php

$position = htmlspecialchars($param[1]);

$users = new \ssp\models\User($db);

$positions = $users->seekPosition($position);

\ssp\module\Tools::send_json($positions);

