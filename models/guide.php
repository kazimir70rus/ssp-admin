<?php

namespace ssp\models;

Class Guide
{
    private $db;


    function __construct($db)
    {
        $this->db = $db;
    }


    // возвращает список видов результата
    function getTypeResults()
    {
        $query = 'select id_result, name from type_result where visible = 1 order by name';

        return $this->db->getList($query);
    }


    // обновляем наименование организации
    function updateName($name, $id)
    {
        $query = 'update organisations set name = :name where id_organisation = :id';

        return $this->db->updateData($query, ['name' => $name, 'id' => $id]);
    }

    // возвращает список организаций
    function getList()
    {
        $query = 'select id_organisation, name from organisations order by name';

        return $this->db->getList($query);
    }
}

