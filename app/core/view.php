<?php
namespace App\Core;
use App\Core\Template;

class View
{
    public function generate(string $view, string $template, array $data = []) : void
    {
        global $HOME;
        $viewPath = "$HOME/app/views/view_$view.php";
        if (file_exists($viewPath))
        {
            Template::Instance()->IncludeHeader($template);
            include $viewPath;
            Template::Instance()->IncludeFooter($template);
            return;
        }

        echo "View $view is not founded!";
    }
}