<?php

class Controller_Main extends \App\Core\Controller
{
    public function action_index()
    {
        $this->view->generate("index", "crud");
    }
}