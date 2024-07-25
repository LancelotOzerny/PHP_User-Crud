<?php
use App\Core\Model;

class Model_User extends Model
{
    public function getListData()
    {
        $data = [];
        $data['USER_LIST'] = \App\Orm\Mysql\UserTable::getList();
        return $data;
    }
}