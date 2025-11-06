document.addEventListener('DOMContentLoaded', function() {
    // Variables globales pour le modal
    const modal = document.getElementById('addUsersModal');
    const usersList = document.querySelector('.users-list');
    const searchInput = document.getElementById('userSearchInput');
    const assignForm = document.getElementById('assignUsersForm');
    let currentServiceId = null;
    
    // Récupérer l'ID du département depuis la page
    const departmentId = document.querySelector('meta[name="department-id"]')?.content;

    // Fonction pour ouvrir le modal
    window.openUsersModal = async function(serviceId) {
        if (!departmentId) {
            console.error('ID du département non trouvé');
            alert('Erreur: ID du département non trouvé');
            return;
        }

        currentServiceId = serviceId;
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';

        try {
            console.log(`Chargement des utilisateurs pour le service ${serviceId} du département ${departmentId}`);
            const response = await fetch(`/departments/${departmentId}/services/${serviceId}/unassigned-users`);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            console.log('Données reçues:', data);
            
            if (data.users && data.users.length > 0) {
                renderUsersList(data.users);
            } else {
                usersList.innerHTML = `
                    <div class="no-users">
                        <p>Aucun employé disponible pour affectation</p>
                    </div>
                `;
            }
        } catch (error) {
            console.error('Erreur détaillée lors du chargement des utilisateurs:', error);
            usersList.innerHTML = `
                <div class="error-message">
                    <p>Une erreur est survenue lors du chargement des utilisateurs</p>
                    <small>${error.message}</small>
                </div>
            `;
        }
    };

    // Fonction pour fermer le modal
    window.closeModal = function() {
        modal.style.display = 'none';
        document.body.style.overflow = '';
        searchInput.value = '';
        currentServiceId = null;
    };

    // Fermer le modal en cliquant en dehors
    window.onclick = function(event) {
        if (event.target === modal) {
            closeModal();
        }
    };

    // Fonction pour rendre la liste des utilisateurs
    function renderUsersList(users) {
        usersList.innerHTML = users.map(user => `
            <div class="user-item">
                <input type="checkbox" 
                       name="users[]" 
                       value="${user.id}" 
                       id="user-${user.id}" 
                       class="user-checkbox">
                <label for="user-${user.id}" class="user-info">
                    <div class="user-name">${user.name}</div>
                    <div class="user-email">${user.email}</div>
                    <div class="user-matricule">${user.matricule}</div>
                </label>
            </div>
        `).join('');
    }

    // Fonction pour filtrer les utilisateurs
    window.filterUsers = function() {
        const searchTerm = searchInput.value.toLowerCase();
        const userItems = usersList.querySelectorAll('.user-item');
        
        userItems.forEach(item => {
            const userName = item.querySelector('.user-name').textContent.toLowerCase();
            const userEmail = item.querySelector('.user-email').textContent.toLowerCase();
            const userMatricule = item.querySelector('.user-matricule').textContent.toLowerCase();
            
            if (userName.includes(searchTerm) || 
                userEmail.includes(searchTerm) || 
                userMatricule.includes(searchTerm)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    };

    // Gestionnaire de soumission du formulaire
    assignForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        const selectedUsers = Array.from(document.querySelectorAll('input[name="users[]"]:checked'))
            .map(checkbox => checkbox.value);

        if (selectedUsers.length === 0) {
            alert('Veuillez sélectionner au moins un employé');
            return;
        }

        try {
            const response = await fetch(`/departments/${departmentId}/services/${currentServiceId}/assign-users`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ users: selectedUsers })
            });

            const data = await response.json();

            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Une erreur est survenue lors de l\'affectation des employés');
            }
        } catch (error) {
            console.error('Erreur lors de l\'affectation des employés:', error);
            alert('Une erreur est survenue lors de l\'affectation des employés');
        }
    });

    // Confirmation de suppression d'un service
    window.confirmDeleteService = function(departmentId, serviceId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer ce service ? Cette action est irréversible.')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/departments/${departmentId}/services/${serviceId}`;
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
            form.appendChild(csrfInput);

            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);

            document.body.appendChild(form);
            form.submit();
        }
    };

    // Animation des cartes au survol
    const cards = document.querySelectorAll('.service-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.1)';
        });
    });

    // Gestion des messages flash
    const alertElement = document.querySelector('.alert');
    if (alertElement) {
        setTimeout(() => {
            alertElement.style.opacity = '0';
            setTimeout(() => alertElement.remove(), 300);
        }, 5000);
    }
});