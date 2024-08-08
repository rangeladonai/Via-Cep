<?php
namespace ViaCep\Src\Controller;
use ViaCep\Src\Core\Web;

class HomeController
{
    public function Home()
    {
        Web::View(['Teste' => 'Testado'], 'Home');
    }
}