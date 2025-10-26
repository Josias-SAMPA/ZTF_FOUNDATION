$viewsPath = "resources/views"
$cssPath = "public/css"
$jsPath = "public/js"

# Fonction pour extraire les assets et mettre à jour le fichier
function Extract-Assets {
    param (
        [string]$filePath
    )
    
    $content = Get-Content -Path $filePath -Raw
    $fileName = [System.IO.Path]::GetFileNameWithoutExtension($filePath).Replace(".blade", "")
    $modified = $false
    
    # Extraire le CSS
    if ($content -match "(?s)<style[^>]*>(.*?)</style>") {
        $cssContent = $matches[1].Trim()
        $cssFilePath = "$cssPath/$fileName.css"
        $cssContent | Out-File -FilePath $cssFilePath -Encoding UTF8
        
        # Remplacer la balise style par le lien CSS
        $content = $content -replace "(?s)<style[^>]*>.*?</style>", ""
        
        # Ajouter le lien CSS
        if ($content -match "</head>") {
            $content = $content -replace "</head>", "    <link rel=`"stylesheet`" href=`"{{ asset('css/$fileName.css') }}`">`n</head>"
        } else {
            $content = "    <link rel=`"stylesheet`" href=`"{{ asset('css/$fileName.css') }}`">`n" + $content
        }
        $modified = $true
        Write-Host "CSS extrait vers $cssFilePath"
    }
    
    # Extraire le JavaScript
    if ($content -match "(?s)<script[^>]*>(.*?)</script>") {
        $jsContent = $matches[1].Trim()
        $jsFilePath = "$jsPath/$fileName.js"
        $jsContent | Out-File -FilePath $jsFilePath -Encoding UTF8
        
        # Remplacer la balise script par le lien JS
        $content = $content -replace "(?s)<script[^>]*>.*?</script>", ""
        
        # Ajouter le lien JS
        if ($content -match "</body>") {
            $content = $content -replace "</body>", "    <script src=`"{{ asset('js/$fileName.js') }}`"></script>`n</body>"
        } else {
            $content = $content + "`n    <script src=`"{{ asset('js/$fileName.js') }}`"></script>"
        }
        $modified = $true
        Write-Host "JavaScript extrait vers $jsFilePath"
    }
    
    # Sauvegarder le fichier modifié si nécessaire
    if ($modified) {
        $content | Out-File -FilePath $filePath -Encoding UTF8
        Write-Host "Fichier $filePath mis à jour"
    }
}

# Parcourir tous les fichiers .blade.php récursivement
Get-ChildItem -Path $viewsPath -Filter *.blade.php -Recurse | ForEach-Object {
    Write-Host "Traitement de $($_.FullName)..."
    Extract-Assets -filePath $_.FullName
}