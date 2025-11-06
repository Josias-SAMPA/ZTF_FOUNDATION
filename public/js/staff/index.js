document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const staffTable = document.querySelector('.staff-table tbody');
    const rows = staffTable.querySelectorAll('tr');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });

        // Show/hide empty state message
        const visibleRows = Array.from(rows).filter(row => row.style.display !== 'none');
        if (visibleRows.length === 0) {
            let emptyMessage = staffTable.querySelector('.empty-search-results');
            if (!emptyMessage) {
                emptyMessage = document.createElement('tr');
                emptyMessage.className = 'empty-search-results';
                emptyMessage.innerHTML = `
                    <td colspan="7" class="text-center py-4">
                        <div class="flex flex-col items-center justify-center space-y-2">
                            <i class="fas fa-search text-gray-400 text-4xl"></i>
                            <p class="text-gray-500">Aucun résultat trouvé pour "${searchTerm}"</p>
                        </div>
                    </td>
                `;
                staffTable.appendChild(emptyMessage);
            }
        } else {
            const emptyMessage = staffTable.querySelector('.empty-search-results');
            if (emptyMessage) {
                emptyMessage.remove();
            }
        }
    });

    // Alert auto-dismiss
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease-out';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });

    // Delete confirmation enhancement
    document.querySelectorAll('form[action*="destroy"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            const button = form.querySelector('button[type="submit"]');
            if (!button.hasAttribute('data-confirmed')) {
                e.preventDefault();
                if (confirm('Êtes-vous sûr de vouloir retirer cet employé du département ?')) {
                    button.setAttribute('data-confirmed', 'true');
                    form.submit();
                }
            }
        });
    });
});