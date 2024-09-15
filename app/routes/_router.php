<?php

use App\config\Router;

$twig = require __DIR__."/../../app/config/twig.php";

// Inicializar o roteador
$router = new Router($twig);

// Obter a URL da requisição
$url = $_GET['url'] ?? '/';

$method = $_SERVER['REQUEST_METHOD'];

// Processar a requisição
Router::handleRequest($url, $method);
