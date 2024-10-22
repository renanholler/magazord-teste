<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

// Carrega o EntityManager do bootstrap
$entityManager = require_once __DIR__ . '/bootstrap.php';

return ConsoleRunner::createHelperSet($entityManager);
