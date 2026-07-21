FROM php:8.2-apache

# Installation des dépendances système et des extensions PHP
RUN apt-get update && apt-get install -y \
    git zip unzip libpng-dev libicu-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql intl opcache

# Activation du module rewrite d'Apache (nécessaire pour les routes Symfony)
RUN a2enmod rewrite

# Copie des fichiers de l'application
COPY . /var/www/html

# Configuration du point d'entrée Apache sur le dossier /public de Symfony
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/conf-available/*.conf

# Installation de Composer et téléchargement des dépendances
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN composer install --no-dev --optimize-autoloader

# Gestion des permissions sur le dossier var de Symfony
RUN chown -R www-data:www-data var/

EXPOSE 80