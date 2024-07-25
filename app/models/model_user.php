<?php
use App\Core\Model;

class Model_User extends Model
{
    public function getListData()
    {
        $connection = new PDO('mysql:host=localhost;dbname=petprojects', 'root', '');
        $dbList = $connection->query('SELECT * FROM Users');

        $userList = [];
        while (($user = $dbList->fetch()) !== false)
        {
            $userList[] = [
                'ID' => $user['id'],
                'LOGIN' => $user['login'],
                'EMAIL' => $user['email'],
            ];
        }

        return $userList;
    }
}