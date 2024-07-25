<?php
namespace App\Core;

class View
{
    public function generate(string $view, string $template, array $data = []) : void
    {
        global $HOME;
        $viewPath = "$HOME/app/views/view_$view.php";
        if (file_exists($viewPath))
        {
            include $viewPath;
            return;
        }

        echo "View $view is not founded!";
    }
}