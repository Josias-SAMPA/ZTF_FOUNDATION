// Gestion des toggles
document.addEventListener('DOMContentLoaded', function() {
    const toggleInputs = document.querySelectorAll('.toggle-input');
    
    // Initialiser l'Ã©tat des toggles au chargement
    toggleInputs.forEach(input => {
        const slider = input.nextElementSibling;
        slider.style.backgroundColor = input.checked ? '#2ecc71' : '#e74c3c';
    });

    // GÃ©rer les changements d'Ã©tat
    toggleInputs.forEach(input => {
        input.addEventListener('change', function() {
            const slider = this.nextElementSibling;
            if (this.checked) {
                slider.style.backgroundColor = '#2ecc71';  // Vert pour actif
            } else {
                slider.style.backgroundColor = '#e74c3c';  // Rouge pour inactif
            }
        });
    });
});

function triggerBackup() {
    if(confirm('Voulez-vous crÃ©er une nouvelle sauvegarde ?')) {
        // Logique de sauvegarde
        alert('Sauvegarde en cours...');
    }
}

function clearCache() {
    if(confirm('Voulez-vous nettoyer le cache du systÃ¨me ?')) {
        // Logique de nettoyage du cache
        alert('Nettoyage du cache en cours...');
    }
}

function confirmMaintenance() {
    if(confirm('Voulez-vous activer le mode maintenance ? Le site sera inaccessible aux utilisateurs.')) {
        // Logique de mode maintenance
        alert('Activation du mode maintenance...');
    }
}
