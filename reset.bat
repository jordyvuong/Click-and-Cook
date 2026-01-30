@echo off
REM Script de reset complet du projet Click and Cook pour Windows
REM Ce script arrête tous les services, supprime les volumes et relance tout proprement

echo ========================================
echo   Click and Cook - Script de Reset
echo ========================================
echo.

echo [ATTENTION] Cette operation va :
echo   - Arreter tous les conteneurs
echo   - Supprimer tous les volumes (donnees de la base de donnees)
echo   - Reconstruire les images
echo   - Relancer tous les services
echo.

set /p confirm="Etes-vous sur de vouloir continuer? (y/N) "
if /i not "%confirm%"=="y" (
    echo [X] Operation annulee
    exit /b 1
)

echo.
echo [*] Arret des services...
docker compose down

echo.
echo [*] Suppression des volumes...
docker compose down -v

echo.
echo [*] Reconstruction des images...
docker compose build --no-cache

echo.
echo [*] Demarrage des services...
docker compose up -d

echo.
echo [*] Attente du demarrage de la base de donnees...
timeout /t 10 /nobreak >nul

echo.
echo [OK] Reset termine avec succes!
echo.
echo Services disponibles:
echo   - Application: http://localhost:8080
echo   - pgAdmin: http://localhost:8081
echo.
echo Pour voir les logs: docker compose logs -f
echo Pour verifier le statut: docker compose ps
