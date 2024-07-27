<?php

class Controller_User extends \App\Core\Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Model_User();
    }

    public function action_index() : array
    {
        return $this->action_list();
    }

    public function action_list() : array
    {
        $data = [];

        if (isset($_SESSION['user-deleted']))
        {
            if ($_SESSION['user-deleted'] === 'Y')
            {
                $data['SUCCESS'][] = 'Удаление пользователя прошло успешно!';
            }

            if ($_SESSION['user-deleted'] === 'N')
            {
                $data['ERROR'][] = 'Ошибка при удалении пользователя';
            }
        }

        $data = $this->model->getListData();
        $this->view->generate('user_list', 'crud', $data);

        return $data;
    }

    public function action_delete()
    {
        $this->model->deleteUser();
    }

    public function action_create()
    {
        $data = $this->model->getCreateUserData();
        $this->view->generate('user_create', 'crud', $data);
    }

    public function action_edit()
    {
        $data = $this->model->getEditData();
        $this->view->generate('user_edit', 'crud', $data);
    }
}