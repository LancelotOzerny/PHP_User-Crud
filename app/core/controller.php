<?php
namespace App\Core;

abstract class Controller
{
    protected $view;
    protected $model;

    public function __construct()
    {
        $this->view = new View();
    }

    public abstract function action_index();
}