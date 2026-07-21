FROM php:8.2-apache

# Installation des dépendances et de dos2unix
RUN apt-get update && apt-get install -y \
    git zip unzip libpng-dev libicu-dev libpq-dev libzip-dev dos2unix \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql intl opcache zip

# Activation de la réécriture d'URL Apache
RUN a2enmod rewrite
# Autoriser la lecture du .htaccess dans /var/www/html/public
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Copie du projet
COPY . /var/www/html

# Configuration de la racine Web Symfony (/public)
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/conf-available/*.conf

# Variables temporaires pour la construction
ENV APP_ENV=prod
ENV APP_SECRET=dummysymfonysecret32character!

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
ENV COMPOSER_ALLOW_SUPERUSER 1

# Installation sans exécuter les scripts Symfony au build
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Création explicite du dossier var et attribution des permissions
RUN mkdir -p var && chown -R www-data:www-data var/

# Script de démarrage + nettoyage du format Windows (dos2unix)
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN dos2unix /usr/local/bin/entrypoint.sh && chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]