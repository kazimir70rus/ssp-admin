<?php

$organisations = new \ssp\models\Organisation($db);

$list_organisations = $organisations->getList();

\ssp\module\Tools::send_json($list_organisations);

