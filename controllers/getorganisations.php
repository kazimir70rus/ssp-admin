<?php

$users = new \ssp\models\User($db);

$organisations = $users->getOrganisations();

\ssp\module\Tools::send_json($organisations);

