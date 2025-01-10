## Application Click and Cook
Une application de recette de cuisine construite avec PHP(symfony) et PostgreSQL, Bootstrap, Alpine.js.

## 🚀 Fonctionnalités
Voir des recettes de cuisine

Crud complet:

Ajouter, modifier et supprimer des recettes

Mettre des avis et commentaires

Consulter, ajouter, modifier et supprimerles blogs 

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
git clone https://github.com/jordyvuong/Click-and-Cook.git
cd Click-and-Cook
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
CLICK-AND-COOK/

├── assets/
├── bin/
├── config/
├── init.sql
├── migrations/
├── public/
│ ├── assets/
│ │ ├── img/
│ │ ├── javascript/
│ │ └── styles/
│ ├── uploads/
│ │ ├── articles/
│ │ ├── profile_pictures/
│ │ └── recipes/
│ └── index.php
├── src/
│ ├── Controller/
│ │ ├── ArticleController.php
│ │ ├── HomeController.php
│ │ ├── ProfileController.php
│ │ ├── RecipeController.php
│ │ ├── RegistrationController.php
│ │ └── SecurityController.php
│ ├── Entity/
│ │ ├── Article.php
│ │ ├── Category.php
│ │ ├── Cuisine.php
│ │ ├── Ingredient.php
│ │ ├── Instruction.php
│ │ ├── Recipe.php
│ │ ├── Review.php
│ │ └── User.php
│ ├── Form/
│ │ ├── ArticleType.php
│ │ ├── IngredientType.php
│ │ ├── InstructionType.php
│ │ ├── RecipeType.php
│ │ ├── RegistrationFormType.php
│ │ └── ReviewType.php
│ ├── Repository/
│ │ ├── ArticleRepository.php
│ │ ├── CategoryRepository.php
│ │ ├── CuisineRepository.php
│ │ ├── IngredientRepository.php
│ │ ├── InstructionRepository.php
│ │ ├── RecipeRepository.php
│ │ ├── ReviewRepository.php
│ │ └── UserRepository.php
│ ├── Security/
│ │ └── UsersAuthenticator.php
│ └── Kernel.php
├── templates/
│ ├── blog/
│ │ ├── add.html.twig
│ │ ├── blog.html.twig
│ │ └── detail.html.twig
│ ├── home/
│ │ ├── about.html.twig
│ │ ├── index.html.twig
│ │ └── profil.html.twig
│ ├── profile/
│ │ └── edit.html.twig
│ ├── recipe/
│ │ ├── add.html.twig
│ │ ├── detail.html.twig
│ │ ├── edit.html.twig
│ │ └── list.html.twig
│ ├── registration/
│ │ └── register.html.twig
│ ├── security/
│ │ └── login.html.twig
│ ├── base.html.twig
│ └── tests/
├── .env
├── .env.dev
├── .env.test
├── .gitignore
├── compose.override.yaml
├── docker-compose.yml
└── README.md
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
