<?php

namespace src\Infra\public;

use src\Aplicacao\Response;
use src\Infra\Categoria\CategoriaController;
use src\Infra\LoginController;
use src\Infra\Video\VideoController;

class IndexController
{
    public static function setHeaders() {
        header('Access-Control-Allow-Origin: http://localhost:5173');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, oasys-token');
        header('Access-Control-Allow-Credentials: false');
    }

    public static function setOptionsHeaders() {
        header('HTTP/1.1 200 OK');
        exit;
    }

    public static function processaRequisicao() {
        self::processaRota();
    }

    private static function processaRota() {
        $method = $_SERVER['REQUEST_METHOD'];
        $controllers = [
            'videos' => new VideoController(),
            'categorias' => new CategoriaController(),
            'login' => LoginController::class
        ];
        $routes = [
            'GET' => [
                '/videos/(\d+)' => 'videos@getForId',
                '/videos' => 'videos@getAll',
                '/categorias' => 'categorias@getAll',
                '/categorias/(\d+)' => 'categorias@getForId',
                '/categorias/(\d+)/videos' => 'videos@getVideosPorCategoria',
                '/videos/free' => 'videos@getVideosFree'
            ],
            'DELETE' => [
                '/videos/(\d+)' => 'videos@delete',
                '/categorias/(\d+)' => 'categorias@delete'
            ],
            'POST' => [
                '/videos' => 'videos@add',
                '/categorias' => 'categorias@add',
                '/login' => 'login@'
            ],
            'PUT' => [
                '/videos/(\d+)' => 'videos@update',
                '/categorias/(\d+)' => 'categorias@update'
            ]
        ];

        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($routes[$method] as $routePattern => $methodName) {
            $routePattern = rtrim($routePattern, '/');
            if (preg_match('#^' . $routePattern . '$#', $requestUri, $matches)) {
                array_shift($matches);

                $methodName = explode('@', $methodName);
                $class =  $controllers[$methodName[0]];

                if ($class == \src\Infra\LoginController::class) self::processaLogin(new $class);

                $methodName = $methodName[1];

                if($methodName != 'getVideosFree') Autenticator::verifyToken();

                call_user_func_array([$class, $methodName], $matches);
            }
        }

        Response::error('Rota não encontrada', 404);
    }

    private static function processaLogin(\src\Infra\LoginController $loginController) {
        $authorization = $loginController->processaLogin();
        Response::success(['token' => $authorization]);
    }
}