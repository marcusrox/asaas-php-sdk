FROM php:7.4-apache

# Habilitando mod_rewrite do apache
RUN cp /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/rewrite.load

# Instalando pacotes do linux
RUN apt update && apt install git wget -y

# Copiando php.ini
RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Instalando extensões do php
#RUN docker-php-ext-install mysqli pdo pdo_mysql
#RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg
#RUN docker-php-ext-install -j$(nproc) gd
#RUN docker-php-ext-install gettext

# Copiando aplicação para dentro do docker
COPY . /var/www/html/

# Composer
RUN wget -cO - https://getcomposer.org/composer-stable.phar > /usr/local/bin/composer && \
    chmod +x /usr/local/bin/composer && \
    composer install --no-dev --prefer-dist --no-scripts --ignore-platform-reqs --no-progress --optimize-autoloader --no-interaction
