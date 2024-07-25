<?php
use App\Core\Model;

class Model_User extends Model
{
    public function getListData()
    {
        $connection = new PDO('mysql:host=localhost;dbname=petprojects', 'root', '');
        $dbList = $connection->query('SELECT * FROM Users');

        $data['USER_LIST'] = [];
        while (($user = $dbList->fetch()) !== false)
        {
            $data['USER_LIST'][] = [
                'ID' => $user['id'],
                'LOGIN' => $user['login'],
                'EMAIL' => $user['email'],
            ];
        }

        return $data;
    }
}