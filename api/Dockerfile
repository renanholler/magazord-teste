FROM php:8.2-cli

# Instalar extensões necessárias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir diretório de trabalho
WORKDIR /var/www/html

# Copiar arquivos do projeto
COPY . .

# Instalar dependências do Composer
RUN composer install --no-interaction --prefer-dist --no-suggest --no-progress

# Copiar o script de entrada
COPY entrypoint.sh /usr/local/bin/entrypoint.sh

# Tornar o script executável
RUN chmod +x /usr/local/bin/entrypoint.sh

# Definir o entrypoint
ENTRYPOINT ["entrypoint.sh"]

# Expor a porta 8000
EXPOSE 8000
