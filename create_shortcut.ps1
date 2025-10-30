$WshShell = New-Object -comObject WScript.Shell
$Shortcut = $WshShell.CreateShortcut("$Home\Desktop\ZTF Foundation.lnk")
$Shortcut.TargetPath = "http://ztf.local"
$Shortcut.Save()