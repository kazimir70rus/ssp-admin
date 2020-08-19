<?php

namespace ssp\models;

Class Organisation
{
    private $db;


    function __construct($db)
    {
        $this->db = $db;
    }


    // добавляет организацию
    function add($name)
    {
        $query = 'insert into organisations (name) values (:name)';

        return $this->db->insertData($query, ['name' => $name]);
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

