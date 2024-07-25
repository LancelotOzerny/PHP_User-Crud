<?php
namespace App\Core;

class Route
{
    public static function Start()
    {
        $controller_name = 'main';
        $controller_action = 'index';

        $uri = $_SERVER['REQUEST_URI'];
        $path = explode('/', $uri);

        if (empty($path[1]) === false)
        {
            $controller_name = $path[1];
        }

        if (empty($path[2]) === false)
        {
            $controller_action = $path[2];
        }

        global $HOME;
        $controller_name = "controller_$controller_name";
        $controller_path = "$HOME/app/controllers/$controller_name.php";
        $controller_action = "action_$controller_action";

        if (file_exists($controller_path))
        {
            include $controller_path;
            $controller = new $controller_name();

            if (method_exists($controller, $controller_action))
            {
                $controller->$controller_action();
                return;
            }
        }

        echo 'Page 404';
    }
}