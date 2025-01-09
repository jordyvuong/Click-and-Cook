## Application Click and Cook
Une application de recette de cuisine construite avec PHP et PostgreSQL.

## 🚀 Fonctionnalités
Voir des recettes de cuisine

Consulter les blogs 

Se connecter 


## 🛠 Prérequis
Docker

Symfony 

Docker Compose

Git

Navigateur web pour pgAdmin

## 📦 Installation
Clonez le repository :
```
git clone [url-du-repo]
cd [nom-du-dossier]
```
Lancez l'application avec Docker Compose :

```
docker compose up --build
```

Installer Composer 

```
Composer Install
```

## 🌐 Utilisation
Accédez à l'application via votre navigateur : http://localhost:8080

## 📊 Accès à pgAdmin ou phpmyadmin
pgAdmin est accessible via votre navigateur : http://localhost:8081

pour phpmyadmin: -Aller dans .env

-Et changer la connexion à la bdd d'un autre (Ligne 29) avec votre propre base de données

-Exemple :

DATABASE_URL="mysql://user:password@127.0.0.1:3306/db_name"

Puis créer la bdd avec :

php bin/console doctrine:database:create

## 📁 Structure du projet
# Structure du projet

```
Click-and-Cook/
├── assets/                  # Fichiers front-end (CSS, JS)
│   ├── css/                 # Fichiers CSS
│   ├── js/                  # Fichiers JavaScript
│   └── images/              # Fichiers d'images
├── bin/                     # Scripts Symfony (console, etc.)
├── config/                  # Configuration du projet (routes, services, etc.)
│   ├── packages/            # Configurations des packages (doctrine.yaml, mailer.yaml)
│   ├── routes/              # Configuration des routes
│   │   ├── annotations.yaml # Routes définies avec annotations
│   │   └── security.yaml    # Routes spécifiques à la sécurité
│   └── services.yaml        # Définition des services
├── migrations/              # Fichiers de migration Doctrine
├── public/                  # Fichiers accessibles publiquement
│   ├── index.php            # Point d'entrée principal
│   ├── uploads/             # Dossier pour les fichiers uploadés
│   └── assets/              # Fichiers compilés de Webpack Encore
├── src/                     # Code source principal
│   ├── Controller/          # Contrôleurs pour gérer les routes
│   │   ├── HomeController.php
│   │   └── UserController.php
│   ├── Entity/              # Entités Doctrine (modèles de données)
│   │   └── User.php
│   ├── Form/                # Classes de formulaires
│   │   └── RegistrationFormType.php
│   ├── Repository/          # Requêtes personnalisées Doctrine
│   └── Security/            # Classes liées à la sécurité (authentification, etc.)
├── templates/               # Templates Twig
│   ├── base.html.twig       # Template de base
│   ├── home/                # Pages pour l'accueil
│   │   └── index.html.twig
│   └── security/            # Pages liées à la sécurité (connexion, inscription)
├── tests/                   # Tests unitaires et fonctionnels
├── translations/            # Fichiers de traduction
├── var/                     # Fichiers temporaires (cache, logs)
├── vendor/                  # Dépendances installées via Composer
├── .env                     # Variables d'environnement
├── composer.json            # Dépendances PHP
└── README.md                # Documentation du projet
```


## 🔧 Configuration
Variables d'environnement (docker compose.yml)

Relier le php avec:

docker exec -it nom_du_conteneur_php php bin/console doctrine:migrations:migrate



## 🔨 Développement
Pour le développement, les volumes Docker sont configurés pour refléter les changements en temps réel :

volumes:

  - ./public:/var/www/html/public
    
  - ./src:/var/www/html/src
    
  - ./templates:/var/www/html/templates
## 🚀 Commandes utiles
# Démarrer l'application
```
docker compose up

# Démarrer l'application en arrière-plan
docker compose up -d

# Arrêter l'application
docker compose down

# Reconstruire les containers
docker compose up --build

# Voir les logs
docker compose logs

# Accéder au container PHP
docker compose exec php bash

# Accéder à la base de données
docker compose exec db psql -U postgres -d todolist

# Accéder à pgAdmin
http://localhost:8081

# Redémarrer pgAdmin si nécessaire
docker compose restart pgadmin
```
# Configuration initiale de pgAdmin
Connectez-vous avec :

Email: admin@admin.com
Mot de passe: admin

## 🔨 Services Docker
L'application utilise trois services Docker :

PHP/Apache : Serveur web et application PHP
PostgreSQL : Base de données
pgAdmin : Interface d'administration de la base de données
## 🛡 Sécurité
Échappement des données HTML
Requêtes préparées pour la base de données
Validation des entrées utilisateur
## 🤝 Contribution
Fork le projet
Créez votre branche (git checkout -b feature/AmazingFeature)
Committez vos changements (git commit -m 'Add some AmazingFeature')
Push vers la branche (git push origin feature/AmazingFeature)
Ouvrez une Pull Request
