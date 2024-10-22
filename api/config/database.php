<?php

use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\EntityManager;

require_once __DIR__ . '/../vendor/autoload.php';

$paths = [__DIR__ . '/../src/Entities'];
$isDevMode = true;

// Configuração do banco de dados
$dbParams = [
    'driver'   => 'pdo_pgsql',
    'user'     => 'root',
    'password' => 'root',
    'dbname'   => 'magazord',
    'host'     => 'db',
    'port'     => 5432,
];

$config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);

$entityManager = EntityManager::create($dbParams, $config);

return $entityManager;
