<?php

$guide = new \ssp\models\Guide($db);

$data = json_decode(file_get_contents('php://input'), true);

if ((int)$data['id_result'] > 0) {
    \ssp\module\Tools::send_json($guide->updateResult($data['id_result'], $data['name']));
} else {
    \ssp\module\Tools::send_json($guide->addResult($data['name']));
}

