<?php 

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Configurar o Twig
$loader = new FilesystemLoader(__DIR__.'/../../resources/views');
$twig = new Environment($loader, [
    'cache' => __DIR__.'/../../cache', // Defina o diretório de cache para compilar templates
]);


return $twig;