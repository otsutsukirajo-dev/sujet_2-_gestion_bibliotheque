# 📚 Application de Gestion de Bibliothèque

Projet réalisé dans le cadre du module de développement web.

---

## 👤 À propos de l'auteur
* **Étudiant** : RAKOTNI
* **Établissement** : INSI
* **Niveau** : Licence 1 (L1) - Computer Science
* **Projet choisi** : Sujet 2 — Gestion de Bibliothèque

---

## 🚀 Présentation du Projet
Cette application web développée avec **Symfony 7** permet la gestion complète d'une bibliothèque. Elle gère les catalogues de livres, les auteurs, les catégories ainsi que le cycle de vie des emprunts de livres.

### ✨ Fonctionnalités clés
* **Gestion des Livres, Auteurs et Catégories (CRUD)** : Création, lecture, modification et suppression.
* **Système d'Emprunts Automatisé** :
  * Mise à jour automatique de la disponibilité du livre (**Disponible** / **Emprunté**).
  * Interdiction d'emprunter un livre déjà indisponible.
* **Moteur de recherche** : Filtrage multi-critères en temps réel sur la liste des livres (recherche par titre, nom d'auteur ou catégorie).
* **Sécurité & Authentification** : Connexion, inscription et contrôle d'accès.
* **Validation des formulaires** : Contrôle de saisie strict avec contraintes `Assert` et retours utilisateur par notifications Flash.

---

## 🛠️ Stack Technique
* **Framework Backend** : Symfony 7 (PHP 8.2+)
* **Base de Données** : MySQL / MariaDB avec Doctrine ORM
* **Frontend** : Twig, Bootstrap 5
* **Gestionnaire de paquets** : Composer

---

## ⚙️ Guide d'installation et démarrage local

Pour tester le projet localement :

1. **Cloner le projet** :
   ```bash
   git clone [https://github.com/otsutsukirajo-dev/sujet_2-_gestion_bibliotheque.git](https://github.com/otsutsukirajo-dev/sujet_2-_gestion_bibliotheque.git)
   cd sujet_2-_gestion_bibliotheque

2. **Installer les dépendances Composer** :
    ```Bash
    composer install

3.  **Configurer la base de données** :
    Créer un fichier .env.local et y renseigner votre chaîne de connexion :
    ```Extrait de code
    DATABASE_URL="mysql://root:@127.0.0.1:3306/gestion_bibliotheque?serverVersion=8.0&charset=utf8mb4"

4.  **Créer la base de données et appliquer les migrations** :
    ```Bash
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate

5.  **Lancer le serveur d'application** :
    ```Bash
    symfony server:start

    Rendez-vous ensuite sur http://127.0.0.1:8000.