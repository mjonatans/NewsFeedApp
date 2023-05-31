<?php

namespace App\Core;

use App\Repositories\Comment\CommentRepository;
use App\Repositories\Comment\JsonPlaceholderCommentRepository;
use App\Repositories\Post\JsonPlaceholderPostRepository;
use App\Repositories\Post\PostRepository;
use App\Repositories\User\JsonPlaceholderUserRepository;
use App\Repositories\User\UserRepository;
use FastRoute;
class Router
{
    public static function route()
    {
        $builder = new \DI\ContainerBuilder();
        $builder->addDefinitions([
            PostRepository::class => new JsonPlaceholderPostRepository(),
            UserRepository::class => new JsonPlaceholderUserRepository(),
            CommentRepository::class => new JsonPlaceholderCommentRepository()
        ]);

        $container = $builder->build();

        $dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
            $r->addRoute('GET', '/', [\App\Controllers\PostController::class, 'index']);
            $r->addRoute('GET', '/articles', [\App\Controllers\PostController::class, 'index']);
            $r->addRoute('GET', '/users', [\App\Controllers\UserController::class, 'index']);
            $r->addRoute('GET', '/articles/{id:\d+}', [\App\Controllers\PostController::class, 'show']);
            $r->addRoute('GET', '/users/{id:\d+}', [\App\Controllers\UserController::class, 'show']);
        });

        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);

        switch ($routeInfo[0]) {

            case FastRoute\Dispatcher::NOT_FOUND:
                return new View('notFound', []);

            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                return $routeInfo[1];

            case FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];

                [$controllerName, $methodName] = $handler;

                $controller = $container->get($controllerName);

                return $controller->{$methodName}($vars);
        }
        return null;
    }
}