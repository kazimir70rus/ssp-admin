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


    function add($info)
    {
        $query = '
            insert into users (name, pass, id_position, id_parent, id_organisation, is_controller, fio)
            values (:login, password(:password), :id_position, :parent, :id_org, :is_controller, :fio)';

        return $this
                    ->db
                    ->insertData($query, [
                                            'login'         => $info['login'],
                                            'password'      => $info['password'],
                                            'id_position'   => $info['id_position'],
                                            'parent'        => $info['id_parent'],
                                            'id_org'        => $info['id_org'],
                                            'is_controller' => $info['is_controller'],
                                            'fio'           => $info['fio'],
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
        $query ='select id_user, positions.name as position from users join positions using (id_position) where users.name = :login and pass = password(:pass)';

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
                id_user, users.name as name, organisations.name as org, positions.name as position, fio
            from 
                users
                left join organisations using (id_organisation)
                left join positions using (id_position)
            where 
                id_parent = :id_lead order by name';

        return $this
                    ->db
                    ->getList($query, ['id_lead' => $id_lead]);
    }


    // поиск должности по подстроке
    function seekPosition($position)
    {

        $seek = "%{$position}%";

        $query = 'select id_position, name from positions where name like :position limit 4';

        return $this
                    ->db
                    ->getList($query, ['position' => $seek]);
    }


    // возвращает id должности, если должность не существует, добавляет
    function getIdPosition($position)
    {
        $query ='select id_position from positions where name = :position';

        $result = $this->db->getRow($query, ['position' => $position]);

        if (is_array($result) > 0) {

            return $result['id_position'];
        } else {
            $query ='insert into positions (name) values (:position)';

            return $this->db->insertData($query, ['position' => $position]);
        }
    }


    // возвращает список организаций
    function getOrganisations_delete()
    {
        $query = 'select id_organisation, name from organisations order by name';

        return $this
                    ->db
                    ->getList($query);
    }


    // возвращает детельную информацию по пользователю
    // сделана заглушка: у директора возвращает его id_user
    function getUserInfo($id_user)
    {
        $query = '
            select
                id_user,
                if(id_parent = 0, id_user, id_parent) as id_parent,
                fio,
                users.name as login, 
                positions.name as position, 
                users.id_organisation as id_organisation,
                organisations.name as organisation,
                is_controller
            from
                users
                join positions using (id_position)
                join organisations using (id_organisation)
            where
                id_user = :id_user';

        return $this
                    ->db
                    ->getRow($query, ['id_user' => $id_user]);
    }


    // обновление информации о пользователе
    function update($info)
    {
       $params = [ 
                    'id_user'       => $info['id_user'],
                    'login'         => $info['login'],
                    'fio'           => $info['fio'],
                    'id_position'   => $info['id_position'],
                    'id_parent'     => $info['id_parent'],
                    'id_org'        => $info['id_org'],
                    'is_controller' => $info['is_controller'],
                 ];

        if (strlen($info['password']) != 0) {
            $new_pass = 'pass = password(:password), ';
            $params['password'] = $info['password'];
        } else {
            $new_pass = '';
        }

        $query = '
            update users
                set
                    name = :login,
                    fio = :fio,
                    id_position = :id_position,
                    id_organisation = :id_org,
                    id_parent = :id_parent,
                    ' . $new_pass . '
                    is_controller = :is_controller
            where
                id_user = :id_user';

        return $this
                    ->db
                    ->updateData($query, $params); 
    }
}

