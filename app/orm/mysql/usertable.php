<?php
namespace App\Orm\Mysql;

use App\Core\Database;

class UserTable
{
    public static function getList(array $params = []) : array
    {
        $dbList = Database::getConnection()->query('SELECT * FROM Users');
        $users = [];
        while (($user = $dbList->fetch()) !== false)
        {
            $users[] = [
                'ID' => $user['id'],
                'LOGIN' => $user['login'],
                'EMAIL' => $user['email'],
            ];
        }

        return $users;
    }

    public static function create(array $params = []) : void
    {

    }

    public static function deleteById(int $id) : void
    {

    }

    public static function getById(int $id) : void
    {

    }
}