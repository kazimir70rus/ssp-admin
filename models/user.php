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
        $query = '
            insert into users (name, pass, position, id_parent, id_organisation, id_position) 
            values (:login, :password, :position, :parent, :organisation)';

        return $this
                    ->db
                    ->insertData($query, [
                                            'name'         => $login, 
                                            'pass'         => $password, 
                                            'position'     => $position, 
                                            'id_parent'    => $parent, 
                                            'organisation' => $id_organisation,
                                         ]);
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


    // возвращает список подчиненных у руководителя заданного через id_lead
    function getSubordinate($id_lead)
    {
        $query ='
            select
                id_user, users.name as name, organisations.name as org
            from 
                users join organisations using (id_organisation)
            where 
                id_parent = :id_lead order by name';

        return $this
                    ->db
                    ->getList($query, ['id_lead' => $id_lead]);
    }


    // возвращает информацию о руководителе
    // сделана заглушка: у директора возвращает его id_user
    function getLead($id_lead)
    {
        $query ='
            select
                id_user, users.name as name, if(id_parent = 0, id_user, id_parent) as id_parent, organisations.name as org
            from
                users join organisations using (id_organisation)
            where
                id_user = :id_lead';

        return $this
                    ->db
                    ->getRow($query, ['id_lead' => $id_lead]);
    }
}
