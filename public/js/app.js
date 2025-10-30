// Function to show selected section and hide others
function showSection(sectionId) {
    // Hide all sections
    document.querySelectorAll('section[id^="section-"]').forEach(section => {
        section.style.display = 'none';
    });

    // Show the selected section
    const selectedSection = document.getElementById(`section-${sectionId}`);
    if (selectedSection) {
        selectedSection.style.display = 'block';
    }
}

// Initialize form validation
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                e.preventDefault();
            }
        });
    });
});

// Handle file inputs
document.querySelectorAll('input[type="file"]').forEach(input => {
    input.addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        const fileLabel = input.nextElementSibling;
        
        if (fileLabel && fileLabel.classList.contains('file-label')) {
            fileLabel.textContent = fileName || 'Choisir un fichier';
        }
    });
});

// Initialize tooltips
const tooltips = document.querySelectorAll('[data-tooltip]');
tooltips.forEach(tooltip => {
    tooltip.addEventListener('mouseenter', e => {
        const tip = document.createElement('div');
        tip.className = 'tooltip';
        tip.textContent = e.target.dataset.tooltip;
        document.body.appendChild(tip);
        
        const rect = e.target.getBoundingClientRect();
        tip.style.top = rect.top - tip.offsetHeight - 10 + 'px';
        tip.style.left = rect.left + (rect.width - tip.offsetWidth) / 2 + 'px';
    });
    
    tooltip.addEventListener('mouseleave', () => {
        const tips = document.querySelectorAll('.tooltip');
        tips.forEach(tip => tip.remove());
    });
});