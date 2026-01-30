.PHONY: help up down logs restart reset build clean dev prod status shell db-shell

# Variables
COMPOSE_FILE = compose.yaml
COMPOSE_DEV = docker-compose.dev.yml
COMPOSE_PROD = docker-compose.prod.yml

help: ## Affiche cette aide
	@echo "Commandes disponibles:"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-15s\033[0m %s\n", $$1, $$2}'

up: ## Lance tous les services en arrière-plan
	docker compose -f $(COMPOSE_FILE) up -d

down: ## Arrête tous les services
	docker compose -f $(COMPOSE_FILE) down

logs: ## Affiche les logs en temps réel
	docker compose -f $(COMPOSE_FILE) logs -f

restart: ## Redémarre tous les services
	docker compose -f $(COMPOSE_FILE) restart

reset: ## Arrête, supprime les volumes et relance proprement
	@echo "⚠️  Attention: Cette commande va supprimer toutes les données de la base de données!"
	@read -p "Êtes-vous sûr? (y/N) " -n 1 -r; \
	echo; \
	if [[ $$REPLY =~ ^[Yy]$$ ]]; then \
		docker compose -f $(COMPOSE_FILE) down -v; \
		docker compose -f $(COMPOSE_FILE) up -d --build; \
		echo "✅ Projet réinitialisé avec succès!"; \
	else \
		echo "❌ Annulé"; \
	fi

build: ## Construit les images Docker
	docker compose -f $(COMPOSE_FILE) build

clean: ## Supprime tous les conteneurs, volumes et images
	docker compose -f $(COMPOSE_FILE) down -v --rmi all

dev: ## Lance le projet en mode développement
	docker compose -f $(COMPOSE_DEV) up -d

prod: ## Lance le projet en mode production
	docker compose -f $(COMPOSE_PROD) up -d

status: ## Affiche le statut des conteneurs
	docker compose -f $(COMPOSE_FILE) ps

shell: ## Ouvre un shell dans le conteneur PHP
	docker compose -f $(COMPOSE_FILE) exec php bash

db-shell: ## Ouvre un shell PostgreSQL
	docker compose -f $(COMPOSE_FILE) exec database psql -U quentin -d click_and_cook

install: ## Installe les dépendances Composer
	docker compose -f $(COMPOSE_FILE) exec php composer install

migrate: ## Exécute les migrations de base de données
	docker compose -f $(COMPOSE_FILE) exec php php bin/console doctrine:migrations:migrate --no-interaction

db-create: ## Crée la base de données
	docker compose -f $(COMPOSE_FILE) exec php php bin/console doctrine:database:create

db-update: ## Met à jour le schéma de la base de données
	docker compose -f $(COMPOSE_FILE) exec php php bin/console doctrine:schema:update --force
