<?php 

declare(strict_types=1);

namespace App\Controllers;

use Twig\Environment;


class HomeController {
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function index()
    {
        echo $this->twig->render('home.twig', ['name' => 'Jane Doe']);
    }
}