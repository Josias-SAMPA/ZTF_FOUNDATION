function toggleDepartmentForm() {
    const modal = document.getElementById('departmentFormModal');
    if (modal) {
        const currentDisplay = window.getComputedStyle(modal).display;
        if (currentDisplay === 'none') {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden'; // EmpÃªcher le dÃ©filement
        } else {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto'; // RÃ©tablir le dÃ©filement
        }
    }
}

// Fermer le modal si on clique en dehors
// Gestion des modals
document.addEventListener('DOMContentLoaded', function() {
    // Gestion du modal dÃ©partement
    const departmentModal = document.getElementById('departmentFormModal');
    if (departmentModal) {
        departmentModal.addEventListener('click', function(event) {
            if (event.target === departmentModal) {
                toggleDepartmentForm();
            }
        });
    }

    // Gestion du modal chef de dÃ©partement
    const headModal = document.getElementById('assignHeadModal');
    if (headModal) {
        headModal.addEventListener('click', function(event) {
            if (event.target === headModal) {
                toggleAssignHeadModal();
            }
        });

        const form = document.getElementById('assignHeadForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const departmentId = form.getAttribute('data-department-id');
                const formAction = `${window.location.origin}/departments/${departmentId}/head/assign`;
                form.action = formAction;
                form.submit();
            });
        }
    }

    // Gestion de la touche Echap pour tous les modals
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            if (departmentModal && window.getComputedStyle(departmentModal).display !== 'none') {
                toggleDepartmentForm();
            }
            if (headModal && window.getComputedStyle(headModal).display !== 'none') {
                toggleAssignHeadModal();
            }
        }
    });
});

// Fonction pour ouvrir le modal d'assignation de chef
function openAssignHeadModal(departmentId) {
    const modal = document.getElementById('assignHeadModal');
    const form = document.getElementById('assignHeadForm');
    if (modal && form) {
        form.setAttribute('data-department-id', departmentId);
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

// Fonction pour fermer le modal d'assignation de chef
function toggleAssignHeadModal() {
    const modal = document.getElementById('assignHeadModal');
    if (modal) {
        const currentDisplay = window.getComputedStyle(modal).display;
        if (currentDisplay === 'none') {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        } else {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    }
}
