<?php

use Doctrine\ORM\Tools\SchemaTool;
use App\Entities\Pessoa;
use App\Entities\Contato;

require_once __DIR__ . '/../../vendor/autoload.php';

$entityManager = require_once __DIR__ . '/../../config/database.php';

$schemaTool = new SchemaTool($entityManager);
$classes = [
    $entityManager->getClassMetadata(Pessoa::class),
    $entityManager->getClassMetadata(Contato::class),
];

try {
    $schemaTool->updateSchema($classes, true);
    echo "Esquema do banco de dados criado com sucesso.\n";
} catch (\Exception $e) {
    echo "Erro ao criar o esquema: " . $e->getMessage() . "\n";
}
