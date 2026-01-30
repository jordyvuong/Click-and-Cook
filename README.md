# 🍳 Click and Cook

Une application de recette de cuisine construite avec **PHP (Symfony)**, **PostgreSQL**, **Bootstrap** et **Alpine.js**.

Projet entièrement dockerisé : **une seule commande pour tout lancer** ! 🚀

## 🚀 Fonctionnalités

- 📖 Voir des recettes de cuisine
- ✏️ CRUD complet : Ajouter, modifier et supprimer des recettes
- 💬 Mettre des avis et commentaires
- 📝 Consulter, ajouter, modifier et supprimer des articles de blog
- 🔐 Système d'authentification

## 🛠 Prérequis

- **Docker** (version 20.10+)
- **Docker Compose** (version 2.0+)
- **Git**
- Navigateur web moderne
- (Optionnel) **Make** pour les commandes simplifiées

## ⚡ Installation rapide

### 1. Clonez le repository

```bash
git clone https://github.com/jordyvuong/Click-and-Cook.git
cd Click-and-Cook
```

### 2. Copiez le fichier d'environnement

```bash
# Linux/Mac
cp .env.example .env

# Windows
copy .env.example .env
```

**Important :** Modifiez le fichier `.env` si nécessaire (credentials, ports, etc.)

### 3. Lancez l'application

```bash
# Avec docker compose
docker compose up -d

# OU avec make (si installé)
make up
```

C'est tout ! L'application démarre automatiquement avec healthchecks. ✨

### 4. Vérifiez que tout fonctionne

```bash
# Voir les logs en temps réel
docker compose logs -f

# Vérifier le statut des conteneurs
docker compose ps
```

Tous les services doivent être "Up" et le service database doit être "healthy".

## 🌐 Accès aux services

Une fois démarré, vous pouvez accéder à :

| Service | URL | Identifiants |
|---------|-----|--------------|
| **Application** | http://localhost:8080 | - |
| **pgAdmin** | http://localhost:8081 | Email: `admin@admin.com`<br>Mot de passe: `admin` |

### Configuration de pgAdmin

1. Connectez-vous à http://localhost:8081 avec les identifiants ci-dessus
2. Ajoutez un nouveau serveur :
   - **Name** : Click and Cook
   - **Host** : `database`
   - **Port** : `5432`
   - **Database** : `click_and_cook`
   - **Username** : `quentin`
   - **Password** : `bdd77`

## 🚀 Commandes Docker (méthode manuelle)

```bash
# Démarrer l'application
docker compose up

# Démarrer en arrière-plan
docker compose up -d

# Arrêter l'application
docker compose down

# Reconstruire les images
docker compose up --build

# Voir les logs en temps réel
docker compose logs -f

# Voir les logs d'un service spécifique
docker compose logs php
docker compose logs database

# Voir le statut des conteneurs
docker compose ps

# Arrêter et supprimer les volumes (⚠️ supprime les données)
docker compose down -v
```

## ⚡ Commandes Makefile (méthode rapide)

Si vous avez **Make** installé, utilisez ces commandes simplifiées :

```bash
make help      # Affiche toutes les commandes disponibles
make up        # Lance tous les services
make down      # Arrête tous les services
make logs      # Affiche les logs en temps réel
make restart   # Redémarre les services
make reset     # Reset complet (⚠️ supprime tout et relance)
make status    # Affiche le statut des conteneurs
make shell     # Ouvre un shell dans le conteneur PHP
make db-shell  # Ouvre un shell PostgreSQL
make migrate   # Exécute les migrations
make build     # Reconstruit les images
make clean     # Supprime tout (conteneurs, volumes, images)
```

## 📄 Modes d'exécution

Le projet propose **3 configurations Docker Compose** différentes :

### 🔧 Mode Standard (`compose.yaml`)

**Quand l'utiliser :** Configuration par défaut, équilibrée.

```bash
docker compose up -d
# OU
make up
```

**Caractéristiques :**
- Volumes bind mounts pour le code
- Variables d'environnement en dur (pas de .env nécessaire)
- Idéal pour tester rapidement

### 💻 Mode Développement (`docker-compose.dev.yml`)

**Quand l'utiliser :** Pour développer activement sur le projet.

```bash
docker compose -f docker-compose.dev.yml up -d
# OU
make dev
```

**Caractéristiques :**
- ✅ Bind mounts étendus (code, config, assets)
- ✅ Rechargement à chaud du code
- ✅ Variables d'environnement depuis `.env`
- ✅ APP_ENV=dev
- ✅ pgAdmin inclus pour déboguer la DB
- ⚠️ Ne PAS utiliser en production

**Avantages :** Modifiez votre code et voyez les changements immédiatement sans rebuild.

### 🚀 Mode Production (`docker-compose.prod.yml`)

**Quand l'utiliser :** Pour déployer en production.

```bash
docker compose -f docker-compose.prod.yml up -d
# OU
make prod
```

**Caractéristiques :**
- ✅ Code embarqué dans l'image Docker (pas de bind mounts)
- ✅ Variables d'environnement obligatoires via `.env`
- ✅ APP_ENV=prod
- ✅ Restart policy configurée
- ✅ Pas de pgAdmin (sécurité)
- ✅ Images optimisées

**Avantages :** Sécurisé, portable, performant.

### 📊 Comparaison rapide

| Critère | Standard | Dev | Prod |
|---------|----------|-----|------|
| Bind mounts | ✅ Partiel | ✅ Complet | ❌ Aucun |
| .env requis | ❌ | ✅ | ✅ |
| pgAdmin | ✅ | ✅ | ❌ |
| Rechargement code | ✅ | ✅ | ❌ |
| Sécurité | ⚠️ | ⚠️ | ✅ |
| Usage | Test | Développement | Production |

## 🔄 Scripts de reset

### Windows

```bash
reset.bat
```

### Linux/Mac

```bash
chmod +x reset.sh
./reset.sh
```

Ces scripts effectuent un reset complet :
- Arrêt des services
- Suppression des volumes
- Reconstruction des images
- Redémarrage des services

## 🛠 Troubleshooting

### ❌ Le conteneur PHP ne démarre pas

**Symptômes :** Le conteneur PHP s'arrête immédiatement ou redémarre en boucle.

**Solutions :**

1. Vérifiez les logs du conteneur :
```bash
docker compose logs php
```

2. Vérifiez que le port 8080 n'est pas déjà utilisé :
```bash
# Windows
netstat -ano | findstr :8080

# Linux/Mac
lsof -i :8080
```

3. Si le port est utilisé, modifiez-le dans `compose.yaml` :
```yaml
services:
  php:
    ports:
      - "9000:80"  # Utilisez un autre port
```

4. Vérifiez les permissions sur les fichiers :
```bash
# Linux/Mac uniquement
chmod -R 755 public/ src/ templates/
```

### ⏳ La base de données n'est pas prête

**Symptômes :** Erreur "Connection refused" ou "Could not connect to database".

**Solutions :**

Le healthcheck garantit normalement que PHP attend PostgreSQL. Si le problème persiste :

1. Vérifiez l'état du healthcheck :
```bash
docker compose ps
# La colonne "Status" doit afficher "Up (healthy)" pour database
```

2. Vérifiez les logs de la base de données :
```bash
docker compose logs database
```

3. Redémarrez le service database :
```bash
docker compose restart database
```

4. Attendez quelques secondes puis relancez PHP :
```bash
docker compose restart php
```

### 🔌 Erreurs de connexion à la base de données

**Symptômes :** "SQLSTATE[08006] Connection refused" ou erreurs d'authentification.

**Solutions :**

1. Vérifiez que les variables d'environnement sont correctes dans `.env` :
```env
POSTGRES_DB=click_and_cook
POSTGRES_USER=quentin
POSTGRES_PASSWORD=bdd77
DATABASE_URL="postgresql://${POSTGRES_USER}:${POSTGRES_PASSWORD}@database:5432/${POSTGRES_DB}?serverVersion=16&charset=utf8"
```

2. Vérifiez que les mêmes variables sont utilisées dans `compose.yaml` et `.env`

3. Testez la connexion manuellement depuis le conteneur PHP :
```bash
docker compose exec php bash
php bin/console dbal:run-sql "SELECT 1"
```

4. Si tout échoue, reset complet :
```bash
docker compose down -v
docker compose up -d --build
```

### 🔄 Les modifications du code ne sont pas prises en compte

**Symptômes :** Vous modifiez le code mais rien ne change dans l'application.

**Solutions :**

1. **En mode développement**, assurez-vous d'utiliser le bon fichier compose :
```bash
docker compose -f docker-compose.dev.yml up -d
# OU
make dev
```

2. Videz le cache Symfony :
```bash
docker compose exec php php bin/console cache:clear
```

3. Redémarrez le service PHP :
```bash
docker compose restart php
```

### 📦 Erreur "Volume is in use"

**Symptômes :** Impossible de supprimer les volumes.

**Solutions :**

1. Arrêtez tous les conteneurs :
```bash
docker compose down
```

2. Vérifiez qu'aucun conteneur n'utilise les volumes :
```bash
docker ps -a
```

3. Supprimez les volumes manuellement :
```bash
docker volume rm click-and-cook_postgres_data
docker volume rm click-and-cook_pgadmin_data
```

### 🚪 Impossible d'accéder à pgAdmin (port 8081)

**Solutions :**

1. Vérifiez que le conteneur pgadmin est bien lancé :
```bash
docker compose ps pgadmin
```

2. Vérifiez que le port 8081 n'est pas utilisé :
```bash
# Windows
netstat -ano | findstr :8081

# Linux/Mac
lsof -i :8081
```

3. Vérifiez les logs pgAdmin :
```bash
docker compose logs pgadmin
```

### 🔐 Erreur d'authentification pgAdmin

**Solutions :**

Utilisez les identifiants définis dans votre `.env` ou par défaut :
- Email : `admin@admin.com`
- Mot de passe : `admin`

Pour se connecter à la base de données dans pgAdmin :
- Host : `database` (nom du service Docker)
- Port : `5432`
- Database : `click_and_cook`
- Username : `quentin`
- Password : `bdd77`

### 🔨 Reset complet du projet

Si rien ne fonctionne, effectuez un reset complet :

```bash
# Méthode 1 : Script automatique (recommandé)
# Windows
reset.bat

# Linux/Mac
chmod +x reset.sh
./reset.sh

# Méthode 2 : Commande Make
make reset

# Méthode 3 : Manuellement
docker compose down -v          # Arrête et supprime les volumes
docker compose build --no-cache # Reconstruit les images
docker compose up -d            # Relance tout
```

### 📋 Commandes de diagnostic utiles

```bash
# Voir tous les conteneurs (actifs et arrêtés)
docker compose ps -a

# Voir les logs de tous les services
docker compose logs

# Voir les logs d'un service spécifique
docker compose logs php
docker compose logs database
docker compose logs pgadmin

# Suivre les logs en temps réel
docker compose logs -f

# Inspecter un conteneur
docker compose exec php bash

# Voir les volumes
docker volume ls

# Voir les réseaux
docker network ls

# Voir l'utilisation des ressources
docker stats
```

## 🔨 Commandes Symfony utiles

```bash
# Accéder au conteneur PHP
docker compose exec php bash

# Une fois dans le conteneur :
php bin/console doctrine:migrations:migrate  # Exécuter les migrations
php bin/console doctrine:schema:update --force  # Mettre à jour le schéma
php bin/console cache:clear  # Vider le cache
composer install  # Installer les dépendances
```

## 📦 Architecture Docker

### Services

| Service | Image | Rôle |
|---------|-------|------|
| **php** | Custom (PHP 8.2-Apache) | Serveur web + Application Symfony |
| **database** | postgres:16 | Base de données PostgreSQL |
| **pgadmin** | dpage/pgadmin4 | Interface d'administration DB |

### Volumes

- `postgres_data` : Persistance des données PostgreSQL
- `pgadmin_data` : Configuration pgAdmin
- Bind mounts (dev) : `./public`, `./src`, `./templates`, `./migrations`, `./config`, `./assets`

### Healthchecks

Le service **database** a un healthcheck actif :
- Commande : `pg_isready -U quentin -d click_and_cook`
- Intervalle : 10s
- Timeout : 5s
- Retries : 5
- Start period : 30s

Le service **php** attend que la database soit "healthy" avant de démarrer grâce à :
```yaml
depends_on:
  database:
    condition: service_healthy
```

## 🔐 Variables d'environnement

Fichiers disponibles :
- `.env` : Configuration active (non versionné)
- `.env.example` : Template à copier avec toutes les variables documentées
- `.env.dev` : Spécifique au développement
- `.env.test` : Pour les tests

### Variables principales

```env
# Application Symfony
APP_ENV=dev
APP_SECRET=votre_secret_key

# PostgreSQL (pour Docker Compose)
POSTGRES_DB=click_and_cook
POSTGRES_USER=quentin
POSTGRES_PASSWORD=bdd77

# Connexion DB (pour Symfony)
DATABASE_URL="postgresql://${POSTGRES_USER}:${POSTGRES_PASSWORD}@database:5432/${POSTGRES_DB}?serverVersion=16&charset=utf8"

# pgAdmin
PGADMIN_EMAIL=admin@admin.com
PGADMIN_PASSWORD=admin
```

**Important :** 
- En mode dev/prod, les variables sont lues depuis `.env`
- En mode standard, elles sont définies directement dans `compose.yaml`
- Le fichier `.env.example` contient toutes les variables nécessaires

## 🛡 Bonnes pratiques Docker

✅ **Healthchecks** : La base de données a un healthcheck actif  
✅ **Dépendances** : PHP attend que PostgreSQL soit prêt  
✅ **Volumes** : Persistance des données garantie  
✅ **Variables d'env** : Centralisées dans `.env`  
✅ **Bind mounts** : Rechargement à chaud en développement  
✅ **Multi-stage** : Séparation dev/prod  
✅ **One command** : `docker compose up -d` suffit  
✅ **Reproductibilité** : Fonctionne sur n'importe quelle machine avec Docker  
✅ **Scripts de reset** : Réinitialisation facile  
✅ **Makefile** : Commandes simplifiées  

## 📁 Structure du projet

```
CLICK-AND-COOK/
├── assets/              # Fichiers frontend (JS, CSS)
├── bin/                 # Exécutables (console Symfony, phpunit)
├── config/              # Configuration Symfony
│   ├── packages/        # Configuration des bundles
│   └── routes/          # Routes de l'application
├── migrations/          # Migrations de base de données
├── public/              # Répertoire web public
│   ├── assets/          # Assets compilés
│   │   ├── img/         # Images
│   │   ├── javascript/  # Scripts JS
│   │   └── styles/      # Feuilles de style
│   ├── uploads/         # Fichiers uploadés
│   │   ├── articles/    # Images des articles
│   │   ├── profile_pictures/  # Photos de profil
│   │   └── recipes/     # Images des recettes
│   └── index.php        # Point d'entrée
├── src/                 # Code source PHP
│   ├── Controller/      # Contrôleurs MVC
│   ├── Entity/          # Entités Doctrine
│   ├── Form/            # Formulaires Symfony
│   ├── Repository/      # Repositories Doctrine
│   ├── Security/        # Authentification
│   └── Kernel.php       # Kernel Symfony
├── templates/           # Templates Twig
│   ├── base.html.twig   # Template de base
│   ├── blog/            # Pages blog
│   ├── home/            # Pages accueil
│   ├── profile/         # Pages profil
│   ├── recipe/          # Pages recettes
│   ├── registration/    # Pages inscription
│   └── security/        # Pages login
├── tests/               # Tests PHPUnit
├── .env                 # Variables d'environnement (non versionné)
├── .env.example         # Template de configuration
├── compose.yaml         # Docker Compose principal
├── docker-compose.dev.yml   # Configuration développement
├── docker-compose.prod.yml  # Configuration production
├── Dockerfile           # Image PHP personnalisée
├── Makefile             # Commandes simplifiées
├── reset.sh             # Script de reset (Linux/Mac)
├── reset.bat            # Script de reset (Windows)
└── README.md            # Ce fichier
```

## 🤝 Contribution

1. Forkez le projet
2. Créez votre branche (`git checkout -b feature/AmazingFeature`)
3. Committez vos changements (`git commit -m 'Add some AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrez une Pull Request

## 📝 Licence

Ce projet est sous licence MIT.

## 👥 Auteurs

- **Quentin** - [quentin](https://github.com/jordyvuong)

## 🙏 Remerciements

- Symfony pour le framework PHP
- Docker pour la conteneurisation
- PostgreSQL pour la base de données
- Bootstrap pour le design
- Alpine.js pour l'interactivité
