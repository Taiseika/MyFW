<?php
error_reporting(-1);

use vendor\core\Router;

$query = rtrim($_SERVER['QUERY_STRING'], '/');

define('WWW', __DIR__);
define('CORE', dirname(__DIR__) . '/vendor/core');
define('ROOT', dirname(__DIR__));
define('APP', dirname(__DIR__) . '/app');
define('CONTROLLERS', 'app\controllers\\');

require '../vendor/core/Router.php';
require '../vendor/libs/functions.php';

spl_autoload_register(function ($class) {
    $file = ROOT . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_file($file)) {
        require_once $file;
    }
});

Router::add('^store/product/(?P<action>[a-z-]+)$', ['controller' => 'store\Product']);
Router::add('^page/(?P<action>[a-z-]+)/(?P<alias>[a-z]+)$', ['controller' => 'Main']);
Router::add('^user/(?P<action>[a-z-]+)/(?P<alias>[a-z]+)', ['controller' => 'User']);


// Default routs
Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

Router::dispatch($query);

