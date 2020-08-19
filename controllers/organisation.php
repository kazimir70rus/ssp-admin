<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['name'])) {
        $name = htmlspecialchars($_POST['name'], ENT_NOQUOTES);
        $id = (int)$_POST['id'];

        $organisation = new \ssp\models\Organisation($db);

        if ($id) {
            // update
            $result = $organisation->updateName($name, $id);
        } else {
            // new
            $result = $organisation->add($name);
        }

        if ($result >= 0) {
            header('Location: ' . BASE_URL);
            exit;
        }
    }
}

require_once 'views/organisation.php';

