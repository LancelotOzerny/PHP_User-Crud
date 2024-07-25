<?php
use App\Core\Model;
use App\Orm\Mysql\UserTable;

class Model_User extends Model
{
    public function getListData() : array
    {
        $data = [];
        $data['USER_LIST'] = UserTable::getList();
        return $data;
    }

    public function getEditData() : array
    {
        $user_id = intval($_GET['id']);
        $user = UserTable::getById($user_id);

        return [
            'USER' => $user,
        ];
    }
}