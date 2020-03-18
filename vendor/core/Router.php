<?php

namespace vendor\core;

class Router
{

    protected static $routes = [];
    protected static $route = [];

    public static function add($regexp, $route = [])
    {

        self::$routes[$regexp] = $route;
    }

    public static function getRoutes()
    {

        return self::$routes;
    }

    public static function getRoute()
    {

        return self::$route;
    }

    /*
     * Перенапрвляет URL по коректному маршруту
     * @param string $url входящий URL
     * @return void
     */
    public static function marchRoute($url)
    {

        foreach (self::$routes as $pattern => $route) {
            if (preg_match("~$pattern~", $url, $matches)) {

                foreach ($matches as $k => $v) {
                    if (is_string($k)) {
                        $route[$k] = $v;
                    }
                }
                if (!isset($route['action'])) {
                    $route['action'] = 'index';
                }
                self::$route = $route;

                return true;
            }
        }
        return false;

    }

    public static function dispatch($url)
    {
        $url = self::removeQueryString($url);
        if (self::marchRoute($url)) {
            $controller = CONTROLLERS . self::$route['controller'];

            if (class_exists($controller)) {
                $controllerObj = new $controller(self::$route);
                $action = self::$route['action'] . 'Action';
                if (method_exists($controllerObj, $action)) {
                    $controllerObj->$action();
                } else {
                    echo "Контроллер <b>$action</b> не найден " . "<br>";
                }
            } else {
                echo "Контроллер <b>$controller</b> не найден " . "<br>";
            }
        } else {
            http_response_code(404);
            include '404.html';
        }
    }

    protected static function upperCamelCase($name)
    {
        $name = str_replace('-', ' ', $name);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);

        return $name;
    }

    protected static function removeQueryString($url)
    {
        if ($url) {
            $params = explode('&', $url, 2);
            if (false === strpos($params[0], '=')) {
                return rtrim($params[0], '/');
            } else {
                return '';
            }
        }
        debug($url);
        return $url;
    }
}