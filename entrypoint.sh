#!/bin/sh
set -e

# Préparation du cache Symfony
echo "--> Vuidage et réchauffement du cache..."
php bin/console cache:clear
php bin/console cache:warmup

# Exécution des migrations BDD
echo "--> Exécution des migrations..."
php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration

# Démarrage d'Apache
echo "--> Démarrage du serveur Apache..."
exec apache2-foreground