<?php

class Controller_User extends \App\Core\Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Model_User();
    }

    public function action_index()
    {
        $this->action_list();
    }

    public function action_list()
    {
        $data = $this->model->getListData();
        $this->view->generate('user_list', 'crud', $data);
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