$processName = "php"
$artisanServer = "artisan serve"

# Vérifier si un serveur Laravel est déjà en cours d'exécution
$existingProcess = Get-Process | Where-Object { $_.CommandLine -like "*$artisanServer*" }

if ($existingProcess) {
    Write-Host "Le serveur Laravel est déjà en cours d'exécution"
} else {
    Write-Host "Démarrage du serveur Laravel..."
    Start-Process "php" -ArgumentList "artisan serve" -NoNewWindow
    Write-Host "Serveur démarré ! Accédez à votre site sur http://localhost:8000"
}

# Garder la fenêtre ouverte
Write-Host "`nAppuyez sur une touche pour fermer le serveur..."
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")