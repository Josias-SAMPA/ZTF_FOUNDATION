function toggleDepartmentForm() {
    const modal = document.getElementById('departmentFormModal');
    if (modal.style.display === 'none') {
        modal.style.display = 'flex';
        // EmpÃªcher le dÃ©filement du body
        document.body.style.overflow = 'hidden';
    } else {
        modal.style.display = 'none';
        // RÃ©tablir le dÃ©filement du body
        document.body.style.overflow = 'auto';
    }
}

// Fermer le modal si on clique en dehors
window.onclick = function(event) {
    const modal = document.getElementById('departmentFormModal');
    if (event.target === modal) {
        toggleDepartmentForm();
    }
}
