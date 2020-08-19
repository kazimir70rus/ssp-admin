<?php

namespace ssp\models;

Class Organisation
{
    private $db;


    function __construct($db)
    {
        $this->db = $db;
    }


    // возвращает список организаций
    function getList()
    {
        $query = 'select id_organisation, name from organisations order by name';

        return $this->db->getList($query);
    }
}

