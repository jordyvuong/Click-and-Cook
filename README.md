# Click-Cook

# Étape 1
-Cloner le repository github :

git clone https://github.com/jordyvuong/Click-and-Cook.git

# Étape 2
-Avoir php version 8.0 ou plus récente
-Avoir composer

-Vérifier la version de php :

php -v

-Vérifier la version de composer :

composer -v

-Installer composer avec le terminal :

composer install

# Étape 3
-Se connecter à la base de données

-Aller dans .env

-Et changer la connexion à la bdd d'un autre (Ligne 29) avec votre propre base de données

-Exemple :

DATABASE_URL="mysql://user:password@127.0.0.1:3306/db_name"

# Étape 4 
Créer la base de données avec :

php bin/console doctrine:database:create

# Étape 5
-Lancer le projet avec :

symfony server:start
