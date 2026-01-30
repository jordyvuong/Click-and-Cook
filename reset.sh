#!/bin/bash

# Script de reset complet du projet Click and Cook
# Ce script arrête tous les services, supprime les volumes et relance tout proprement

echo "========================================"
echo "  Click and Cook - Script de Reset"
echo "========================================"
echo ""

# Couleurs pour les messages
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Demande de confirmation
echo -e "${YELLOW}⚠️  ATTENTION: Cette opération va :${NC}"
echo "  - Arrêter tous les conteneurs"
echo "  - Supprimer tous les volumes (données de la base de données)"
echo "  - Reconstruire les images"
echo "  - Relancer tous les services"
echo ""
read -p "Êtes-vous sûr de vouloir continuer? (y/N) " -n 1 -r
echo ""

if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo -e "${RED}❌ Opération annulée${NC}"
    exit 1
fi

echo ""
echo -e "${YELLOW}🛑 Arrêt des services...${NC}"
docker compose down

echo ""
echo -e "${YELLOW}🗑️  Suppression des volumes...${NC}"
docker compose down -v

echo ""
echo -e "${YELLOW}🏗️  Reconstruction des images...${NC}"
docker compose build --no-cache

echo ""
echo -e "${YELLOW}🚀 Démarrage des services...${NC}"
docker compose up -d

echo ""
echo -e "${YELLOW}⏳ Attente du démarrage de la base de données...${NC}"
sleep 10

echo ""
echo -e "${GREEN}✅ Reset terminé avec succès!${NC}"
echo ""
echo "Services disponibles:"
echo "  - Application: http://localhost:8080"
echo "  - pgAdmin: http://localhost:8081"
echo ""
echo "Pour voir les logs: docker compose logs -f"
echo "Pour vérifier le statut: docker compose ps"
