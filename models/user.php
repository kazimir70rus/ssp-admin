<?php

namespace ssp\models;

Class User
{
    private $db;

    private $id_user;

    public $name;

    function __construct($db, $id_user = 0, $position = '')
    {
        $this->db = $db;

        if ($id_user) {
            $this->id_user = $id_user;
            $result = $this->getInfo($id_user);
            $this->$name = $result['name'];
        }
    }

    function add($login, $password)
    {
        $query = 'INSERT INTO users (name, pass, position, id_parent, id_organisation, id_position) values (:login, :password, :position, :parent, :organisation)';

        return $this
                    ->db
                    ->insertData($query, ['name' => $login, 'pass' => $password, 'position' => $position, 'id_parent' => $parent, 'organisation' => $id_organisation]);
    }

    function getInfo($id_user)
    {
        $query = 'select name from users where id_user = :id_user';

        return $this
                    ->db
                    ->getRow($query, ['id_user' => $id_user]);
    }
    function check($login, $pass)
    {
        $query ='select id_user, position from users where name = :login and pass = password(:pass)';

        return $this
                    ->db
                    ->getRow($query, ['login' => $login, 'pass' => $pass]);
    }

    function getListParents()
    {
        $query ='select id_user, name from users where id_parent like 1 order by name';

        return $this
                    ->db
                    ->getList($query);
    }

}
