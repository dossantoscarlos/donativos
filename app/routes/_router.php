<?php


use App\Config\Logger; 
use App\config\Router;

$twig = require __DIR__."/../../app/config/twig.php";

// Inicializar o roteador
$router = new Router($twig);

// Obter a URL da requisição
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
Logger::debug('URL: ' . $url);

$url = $url === '' ? '/' : trim($url, '/'); // Remove possíveis barras no início e no final da URL

Logger::debug('URL: ' . $url);

$method = $_SERVER['REQUEST_METHOD'];

// Processar a requisição
Router::handleRequest($url, $method);
