<?php
namespace ViaCep\Src\Core;

class Web
{
    /***
     * @param array $data data to view
     * @param string $view the name of the view in the Public/View folder WITHOUT the extension
     */
    public static function View(array $data, string $view)
    {
        extract($data);
        $viewPath = "./View/" . $view . ".php";
        if (file_exists($viewPath)){
            require $viewPath;
        }
    }
}