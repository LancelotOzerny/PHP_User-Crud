<?php
use App\Core\Model;
use App\Core\Database;

class Model_User extends Model
{
    public function getListData()
    {
        $dbList = Database::getConnection()->query('SELECT * FROM Users');

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