<?php


declare(strict_types=1);

namespace App\Controllers;

use Twig\Environment;

class ErrorPageController
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }


    public function errorPage()
    {
        return $this->twig->render('error.twig');
    }
}
