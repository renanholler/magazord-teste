#!/bin/bash
set -e

# Executar o script de criação do esquema
php /var/www/html/src/scripts/create-schema.php

# Iniciar o servidor embutido do PHP
php -S 0.0.0.0:8000 -t public
