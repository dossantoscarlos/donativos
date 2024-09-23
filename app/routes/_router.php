<?php

use App\Config\Logger;
use App\config\Router;

$twig = require __DIR__.'/../../app/config/twig.php';

// Inicializar o roteador
$router = new Router($twig);

// Obter a URL da requisição
$url = $_GET['url'] ?? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
Logger::debug("URL:  {$url}");

$url = trim($url, '/');

$url = $url === '' ? '/' : $url;

Logger::debug("URL sem barra: {$url}");

$method = $_SERVER['REQUEST_METHOD'];

// Processar a requisição
Router::handleRequest($url, $method);
