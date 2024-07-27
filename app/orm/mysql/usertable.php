<?php
namespace App\Orm\Mysql;

use App\Core\Database;

class UserTable
{
    public static function getList() : array
    {
        $dbList = Database::getConnection()->query('SELECT * FROM Users');
        $users = [];
        while (($user = $dbList->fetch()) !== false)
        {
            $users[] = [
                'ID' => $user['id'] ?? '',
                'LOGIN' => $user['login'] ?? '',
                'EMAIL' => $user['email'] ?? '',
                'PASSWORD' => $user['password'] ?? '',
            ];
        }

        return $users;
    }

    public static function update(int $id, array $params) : bool
    {
        $values = [];
        foreach ($params as $key => $value)
        {
            $lower = mb_strtolower($key);
            $values[] = "$lower = :$lower";
        }

        $sql = 'UPDATE Users SET ';
        $sql .= join(", ", $values);
        $sql .= ' WHERE id = :id';

        $prepare = Database::getConnection()->prepare($sql);
        $prepare->bindValue(':id', $id);
        foreach ($params as $key => $value)
        {
            $lower = mb_strtolower($key);
            $prepare->bindValue(":$lower", $value);
        }

        return $prepare->execute();
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

    public static function getByEmail(string $email) : array
    {
        $prepare = Database::getConnection()->prepare('SELECT * FROM Users WHERE email = :email');
        $prepare->bindValue(':email', $email);
        $prepare->execute();

        $users = [];
        foreach ($prepare as $row)
        {
            $users[] = [
                'ID' => $row['id'] ?? '',
                'LOGIN' => $row['login'] ?? '',
                'EMAIL' => $row['email'] ?? '',
                'PASSWORD' => $row['password'] ?? '',
            ];
        }

        return $users;
    }

    public static function getByLogin(string $login) : array
    {
        $prepare = Database::getConnection()->prepare('SELECT * FROM Users WHERE login = :login');
        $prepare->bindValue(':login', $login);
        $prepare->execute();

        $users = [];
        foreach ($prepare as $row)
        {
            $users[] = [
                'ID' => $row['id'] ?? '',
                'LOGIN' => $row['login'] ?? '',
                'EMAIL' => $row['email'] ?? '',
                'PASSWORD' => $row['password'] ?? '',
            ];
        }

        return $users;
    }

    public static function deleteById(int $id) : bool
    {
        $prepare = Database::getConnection()->prepare('DELETE FROM Users WHERE id = :id');
        $prepare->bindValue(':id', $id);
        return $prepare->execute();
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