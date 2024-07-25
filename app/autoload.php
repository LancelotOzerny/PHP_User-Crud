<?php
function Autoload($classname)
{
    global $HOME;

    $classPath = "$HOME/$classname.php";
    $filepath = str_replace('\\', '/', $classPath);
    $filepath = mb_strtolower($filepath);

    if (file_exists($filepath))
    {
        require_once $filepath;
    }
}

spl_autoload_register('Autoload');