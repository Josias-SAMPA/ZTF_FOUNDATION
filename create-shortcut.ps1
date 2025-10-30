$WshShell = New-Object -comObject WScript.Shell
$Shortcut = $WshShell.CreateShortcut("$Home\Desktop\ZTF Foundation - Serveur.lnk")
$Shortcut.TargetPath = "s:\php(Laravel)\ZTF_FOUNDATION\start-server.bat"
$Shortcut.WorkingDirectory = "s:\php(Laravel)\ZTF_FOUNDATION"
$Shortcut.WindowStyle = 1
$Shortcut.Description = "Démarre le serveur de développement ZTF Foundation"
# Utilise l'icône de l'application
$Shortcut.IconLocation = "s:\php(Laravel)\ZTF_FOUNDATION\public\favicon.ico"
$Shortcut.Save()