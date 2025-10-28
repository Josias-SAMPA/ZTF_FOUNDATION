document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.querySelector('form');
    const departmentModal = new bootstrap.Modal(document.getElementById('departmentModal'));
    const modalErrors = document.getElementById('modalErrors');

    loginForm.addEventListener('submit', function(e) {
        const matricule = document.getElementById('matricule').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        // Vérifier si c'est un matricule CM-HQ-CD
        if (matricule.toUpperCase() === 'CM-HQ-CD') {
            e.preventDefault(); // Empêcher la soumission normale du formulaire

            // Vérifier que tous les champs sont remplis
            if (!email || !password) {
                return; // Laisser la validation HTML5 s'en occuper
            }

            // Afficher le modal
            departmentModal.show();
        }
    });

    // Gestion de la soumission du modal
    document.getElementById('saveDepartment').addEventListener('click', function() {
        const departmentName = document.getElementById('department_name').value;
        const departmentCode = document.getElementById('department_code').value;

        if(!departmentName || !departmentCode) {
            modalErrors.style.display = 'block';
            modalErrors.textContent = 'Tous les champs sont obligatoires';
            return;
        }

        // Préparer toutes les données
        const formData = {
            _token: document.querySelector('input[name="_token"]').value,
            matricule: document.getElementById('matricule').value,
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
            department_name: departmentName,
            department_code: departmentCode.toUpperCase()
        };

        // Envoyer la requête AJAX
        fetch('/login', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                modalErrors.style.display = 'block';
                modalErrors.textContent = data.error;
            } else if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            modalErrors.style.display = 'block';
            modalErrors.textContent = 'Une erreur est survenue. Veuillez réessayer.';
        });
    });

    // Réinitialiser les erreurs quand le modal est fermé
    document.getElementById('departmentModal').addEventListener('hidden.bs.modal', function() {
        modalErrors.style.display = 'none';
        modalErrors.textContent = '';
        document.getElementById('departmentForm').reset();
    });
});