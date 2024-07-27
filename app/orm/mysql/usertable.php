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
                'ID' => $user['id'] ?? '',
                'LOGIN' => $user['login'] ?? '',
                'EMAIL' => $user['email'] ?? '',
            ];
        }

        return $users;
    }

    public static function create(array $params = []) : void
    {
        $prepare = Database::getConnection()->prepare(
            'INSERT INTO Users (`email`, `login`, `password`) VALUES (:email, :login, :password)');
        $prepare->bindValue(':email', $params['EMAIL']);
        $prepare->bindValue(':login', $params['LOGIN']);
        $prepare->bindValue(':password', $params['PASSWORD']);

        $prepare->execute();
    }

    public static function deleteById(int $id) : void
    {

    }

    public static function getById(int $id) : array
    {
        $user = [];
        $prepare = Database::getConnection()->prepare('SELECT * FROM Users WHERE id = :id');
        $prepare->bindValue(':id', $id);

        if ($prepare->execute())
        {
            $dbUser = $prepare->fetch();

            if ($dbUser === false)
            {
                return $user;
            }

            $user['ID'] = $dbUser['id'];
            $user['LOGIN'] = $dbUser['login'];
            $user['EMAIL'] = $dbUser['email'];
            $user['PASSWORD'] = $dbUser['password'];
        }
        return $user;
    }
}