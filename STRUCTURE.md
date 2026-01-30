## 📁 Structure du projet

```
CLICK-AND-COOK/
├── assets/                    # Assets frontend
│   ├── controllers/
│   └── styles/
├── bin/                       # Exécutables Symfony
├── config/                    # Configuration Symfony
│   ├── packages/
│   └── routes/
├── migrations/                # Migrations de base de données
├── public/                    # Point d'entrée web
│   ├── assets/
│   │   ├── img/
│   │   ├── javascript/
│   │   └── styles/
│   ├── uploads/
│   │   ├── articles/
│   │   ├── profile_pictures/
│   │   └── recipes/
│   └── index.php
├── src/                       # Code source PHP
│   ├── Controller/            # Contrôleurs
│   ├── Entity/                # Entités Doctrine
│   ├── Form/                  # Formulaires
│   ├── Repository/            # Repositories
│   ├── Security/              # Sécurité
│   └── Kernel.php
├── templates/                 # Templates Twig
│   ├── blog/
│   ├── home/
│   ├── profile/
│   ├── recipe/
│   ├── registration/
│   ├── security/
│   └── base.html.twig
├── tests/                     # Tests
├── .env                       # Variables d'environnement (non versionné)
├── .env.example              # Template des variables d'environnement
├── compose.yaml              # Configuration Docker Compose principale
├── docker-compose.dev.yml    # Configuration développement
├── docker-compose.prod.yml   # Configuration production
├── Dockerfile                # Image Docker personnalisée
├── Makefile                  # Commandes simplifiées
├── reset.sh                  # Script de reset (Linux/Mac)
├── reset.bat                 # Script de reset (Windows)
└── README.md                 # Documentation
```

## 🔧 Configuration technique

### Stack technique

- **Backend** : PHP 8.2 + Symfony 6.x
- **Base de données** : PostgreSQL 16
- **Serveur web** : Apache 2.4
- **Gestionnaire de dépendances** : Composer
- **Administration DB** : pgAdmin 4

### Extensions PHP installées

- `pdo`
- `pdo_pgsql`
- `mod_rewrite` (Apache)

### Ports exposés

| Service | Port Host | Port Container |
|---------|-----------|----------------|
| Application PHP | 8080 | 80 |
| pgAdmin | 8081 | 80 |
| PostgreSQL | - | 5432 (interne) |

## 🛡 Bonnes pratiques Docker

✅ **Healthchecks** : La base de données a un healthcheck actif  
✅ **Dépendances** : PHP attend que PostgreSQL soit prêt  
✅ **Volumes** : Persistance des données garantie  
✅ **Variables d'env** : Centralisées dans `.env`  
✅ **Bind mounts** : Rechargement à chaud en développement  
✅ **Multi-stage** : Séparation dev/prod  
✅ **One command** : `docker compose up -d` suffit  

## 🤝 Contribution

1. Forkez le projet
2. Créez votre branche (`git checkout -b feature/AmazingFeature`)
3. Committez vos changements (`git commit -m 'Add some AmazingFeature'`)
4. Pushez vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrez une Pull Request

## 📝 Licence

Ce projet est sous licence libre pour usage éducatif.

## 👥 Auteurs

- **Quentin** - [quentin](https://github.com/jordyvuong)

## 🙏 Remerciements

- Symfony pour le framework
- Docker pour la conteneurisation
- PostgreSQL pour la base de données
- La communauté open source

---

**Note** : Ce projet a été dockerisé dans le cadre du cours "De la virtualisation à la conteneurisation" avec pour objectif : **1 commande pour lancer** ✨
