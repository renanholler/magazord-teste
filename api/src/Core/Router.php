<?php

namespace App\Core;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7\Response;
use Psr\Container\ContainerInterface;

class Router
{
    private array $routes = [];

    public function registerRoutesFromControllers(array $controllerClasses): void
    {
        foreach ($controllerClasses as $controllerClass) {
            $reflectionClass = new \ReflectionClass($controllerClass);
            foreach ($reflectionClass->getMethods() as $method) {
                $attributes = $method->getAttributes(Route::class);
                foreach ($attributes as $attribute) {
                    /** @var Route $routeAttr */
                    $routeAttr = $attribute->newInstance();
                    $this->routes[$routeAttr->method][$routeAttr->path] = [$controllerClass, $method->getName()];
                }
            }
        }
    }

    public function dispatch(ServerRequestInterface $request, ContainerInterface $container): ResponseInterface
    {
        $method = $request->getMethod();
        $path = $request->getUri()->getPath();

        // Redirecionar a rota raiz para "/pessoas"
        if ($path === '/') {
            return new Response(302, ['Location' => '/pessoas']);
        }

        // Verificar se a rota possui parâmetros dinâmicos {param}
        foreach ($this->routes[$method] as $route => $controllerData) {
            // Substitui todos os parâmetros dinâmicos {param} por uma regex que captura números ou strings
            $pattern = preg_replace('/{(\w+)}/', '(\d+)', $route);

            // Se a rota casar com o padrão
            if (preg_match("#^{$pattern}$#", $path, $matches)) {
                array_shift($matches); // Remove o caminho completo do resultado

                // Obter a classe e método do controlador
                [$controllerClass, $controllerMethod] = $controllerData;
                $controller = $container->get($controllerClass);

                // Passar os parâmetros capturados para o método do controlador
                return $controller->$controllerMethod($request, ...$matches);
            }
        }

        // Retorna 404 se a rota não for encontrada
        return new Response(404, ['Content-Type' => 'application/json'], json_encode(['message' => 'Not Found']));
    }
}
