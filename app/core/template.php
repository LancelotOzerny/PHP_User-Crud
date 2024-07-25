<?php
namespace App\Core;

use App\Classes\Traits\Singleton;

class Template
{
    use Singleton;

    public function IncludeHeader(string $template)
    {
        global $HOME;
        $header_path = "$HOME/app/templates/$template/header.php";
        if (file_exists($header_path))
        {
            require_once $header_path;
        }
        else
        {
            echo "Header of \"$template\" is not founded!";
        }
    }

    public function IncludeFooter(string $template)
    {
        global $HOME;
        $footer_path = "$HOME/app/templates/$template/footer.php";
        if (file_exists($footer_path))
        {
            require_once $footer_path;
        }
        else
        {
            echo "Footer of \"$template\" is not founded!";
        }
    }
}