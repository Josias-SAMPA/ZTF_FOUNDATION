@echo off
echo Demarrage du serveur ZTF Foundation...

:: Vérifier si le serveur est déjà en cours d'exécution
netstat -ano | findstr "8000" > nul
if %errorlevel% equ 0 (
    echo Le serveur est deja en cours d'execution!
    echo Ouverture du navigateur...
    START "" http://localhost:8000
    pause
    exit
)

:: Définir le titre de la fenêtre
title Serveur ZTF Foundation

:: Afficher un message plus convivial
echo ================================================
echo             ZTF FOUNDATION - Serveur
echo ================================================
echo.
echo Le serveur va demarrer...
echo Une fois lance, vous pourrez acceder a votre site sur:
echo http://localhost:8000
echo.
echo Pour arreter le serveur, fermez simplement cette fenetre.
echo ================================================
echo.

:: Démarrer le serveur Laravel
php artisan serve

:: En cas d'erreur
if %errorlevel% neq 0 (
    echo.
    echo Une erreur s'est produite lors du demarrage du serveur.
    echo Verifiez que le port 8000 n'est pas deja utilise.
    pause
)