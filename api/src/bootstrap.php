<?php

use App\Core\Router;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use DI\ContainerBuilder;
use App\Modules\Pessoa\Repositories\PessoaRepositoryInterface;
use App\Modules\Pessoa\Repositories\PessoaRepository;
use App\Modules\Pessoa\Services\PessoaServiceInterface;
use App\Modules\Pessoa\Services\PessoaService;
use App\Modules\Contato\Repositories\ContatoRepositoryInterface;
use App\Modules\Contato\Repositories\ContatoRepository;
use App\Modules\Contato\Services\ContatoServiceInterface;
use App\Modules\Contato\Services\ContatoService;

// Carregar autoload
require_once __DIR__ . '/../vendor/autoload.php';

// Obter o EntityManager
$entityManager = require_once __DIR__ . '/../config/database.php';

// Inicializar o ContainerBuilder do PHP-DI
$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    // Interfaces de Repositório
    PessoaRepositoryInterface::class => DI\autowire(PessoaRepository::class),
    ContatoRepositoryInterface::class => DI\autowire(ContatoRepository::class),

    // Interfaces de Serviço
    PessoaServiceInterface::class => DI\autowire(PessoaService::class),
    ContatoServiceInterface::class => DI\autowire(ContatoService::class),

    // EntityManager
    Doctrine\ORM\EntityManagerInterface::class => function() use ($entityManager) {
        return $entityManager;
    },
]);

$container = $containerBuilder->build();

// Definir os cabeçalhos CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Verificar se é uma requisição de "preflight" (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Inicializar o Router
$router = new Router();

// Registrar rotas a partir dos Controladores
$router->registerRoutesFromControllers([
    App\Modules\Pessoa\Controllers\PessoaController::class,
    App\Modules\Contato\Controllers\ContatoController::class,
]);

// Criar a requisição PSR-7
$psr17Factory = new Psr17Factory();
$creator = new ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);
$request = $creator->fromGlobals();

// Despachar a rota
$response = $router->dispatch($request, $container);

// Emitir a resposta usando Laminas SapiEmitter
$emitter = new SapiEmitter();
$emitter->emit($response);
