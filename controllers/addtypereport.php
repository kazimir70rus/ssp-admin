<?php

$guide = new \ssp\models\Guide($db);

$data = json_decode(file_get_contents('php://input'), true);

if ((int)$data['id_result'] > 0) {
    \ssp\module\Tools::send_json($guide->updateReport($data['id_report'], $data['name']));
} else {
    \ssp\module\Tools::send_json($guide->addReport($data['name']));
}

