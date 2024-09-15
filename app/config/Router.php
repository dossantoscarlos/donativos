<?php

declare(strict_types=1);

namespace App\Config;

use Twig\Environment;

use App\Config\Logger;

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

    public function __construct(Environment $twig) {
        self::$twig = $twig;
    }

    private static function remove_barra_url(string $url)
    {
        return trim($url, '/');
    }

    public static function get(string $url, string $action): void {

        self::$routes['GET'][self::remove_barra_url($url)] = $action;
    }

    public static function post(string $url, string $action): void {
        self::$routes['POST'][self::remove_barra_url($url)] = $action;
    }

    public static function put(string $url, string $action): void {
        self::$routes['PUT'][self::remove_barra_url($url)] = $action;
    }

    public static function patch(string $url, string $action): void {
        self::$routes['PATCH'][self::remove_barra_url($url)] = $action;
    }

    public static function delete(string $url, string $action): void {
        self::$routes['DELETE'][self::remove_barra_url($url)] = $action;
    }

    public static function handleRequest(string $url, string $method): void
    {
        Logger::info(json_encode($url));
        // Remove query string (se houver)
        $url = strtok($url, '?');
        
    

        if (isset(self::$routes[$method][$url])) {
            $action = self::$routes[$method][$url];
            list($controllerClass, $actionMethod) = explode('@', $action);
            $controller = new $controllerClass(self::$twig);
            if (method_exists($controller, $actionMethod)) {
                $controller->$actionMethod();
            } else {
                echo 'Method not found';
            }
        } else {
            echo '404 Not Found';
        }
    }
}
