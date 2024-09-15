<?php 

declare(strict_types=1);

namespace App\Controllers;

use App\Service\HomeService;
use Twig\Environment;


class HomeController {
    private Environment $twig;

    private HomeService $service;
    
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;

        $this->service = new HomeService();
    }

    public function index()
    {
        $items = $this->service->all();
        echo $this->twig->render('home.twig', ['homes' =>$items, 'title' => 'Home page']);
    }
}