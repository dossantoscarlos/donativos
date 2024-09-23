<?php

declare(strict_types=1);

namespace App\Config;

use App\Controllers\ErrorPageController;
use Twig\Environment;

class Router
{
    private static array $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => [],
        'PATCH' => [],
    ];

    private static Environment $twig;

    public function __construct(Environment $twig)
    {
        self::$twig = $twig;
    }

    private static function remove_barra_url(string $url)
    {
        return trim($url, '/');
    }

    public static function get(string $url, string $action): void
    {

        self::$routes['GET'][self::remove_barra_url($url)] = $action;
    }

    public static function post(string $url, string $action): void
    {
        self::$routes['POST'][self::remove_barra_url($url)] = $action;
    }

    public static function put(string $url, string $action): void
    {
        self::$routes['PUT'][self::remove_barra_url($url)] = $action;
    }

    public static function patch(string $url, string $action): void
    {
        self::$routes['PATCH'][self::remove_barra_url($url)] = $action;
    }

    public static function delete(string $url, string $action): void
    {
        self::$routes['DELETE'][self::remove_barra_url($url)] = $action;
    }
    public static function handleRequest(string $url, string $method): void
    {
        Logger::info(json_encode($url));
        // Remove query string (se houver)
        $url = strtok($url, '?');
        Logger::debug("URI => ".$url);
        // Inicializa uma flag para verificar se a rota foi encontrada
        $routeFound = false;

        // Primeiro, verifica rotas exatas
        if (isset(self::$routes[$method][$url])) {
            $action = self::$routes[$method][$url];
            $routeFound = self::executeAction($action);
        } else {

            // Se não encontrar a rota exata, verifica rotas com parâmetros
            foreach (self::$routes[$method] as $route => $action) {
                $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $route);
                $pattern = str_replace('/', '\/', $pattern);
                $pattern = "/^$pattern$/"; // Adiciona delimitadores para a regex

                if (preg_match($pattern, $url, $matches)) {
                    $routeFound = self::executeAction($action, $matches);
                    break; // Finaliza após encontrar uma rota correspondente
                }
            }
        }

        // Verifica se a rota foi encontrada
        if (!$routeFound) {
            // Se nenhuma rota correspondente for encontrada
            $error_page = new ErrorPageController(self::$twig);
            echo $error_page->errorPage();
        }
    }

    private static function executeAction(string $action, array $matches = []): bool
    {
        $actionParts = explode('@', $action);
        [$controllerClass, $actionMethod] = $actionParts;
        $controller = new $controllerClass(self::$twig);

        if (method_exists($controller, $actionMethod)) {
            // Passa os parâmetros extraídos para o método do controlador
            echo $controller->$actionMethod($matches);
            return true; // Ação executada com sucesso
        } else {
            echo '<style>
                .not-found {
                    display: block;
                    text-align: center;
                    margin: 0 auto;
                    margin-top: 100px;
                    width: 60%;
                    color: #CCCC;
                }
            </style>
            <div class="container">
                <div class="not-found">
                    <span class="text-center">Método não permitido</span>
                </div>
            </div>';
            return false; // Ação não encontrada
        }
    }
}
