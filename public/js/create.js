// Form validation and handling
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.service-form');
    
    if (form) {
        // Real-time validation
        const inputs = form.querySelectorAll('input, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                if (this.classList.contains('error')) {
                    validateField(this);
                }
            });
        });

        // Form submission
        form.addEventListener('submit', function(e) {
            let isValid = true;
            
            // Validate all fields
            inputs.forEach(input => {
                if (!validateField(input)) {
                    isValid = false;
                }
            });

            if (!isValid) {
                e.preventDefault();
                // Scroll to first error
                const firstError = form.querySelector('.error');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
    }
});

function validateField(field) {
    const value = field.value.trim();
    let isValid = true;
    let errorMessage = '';

    // Required field validation
    if (field.hasAttribute('required') && !value) {
        isValid = false;
        errorMessage = 'Ce champ est obligatoire';
    }
    
    // Email validation
    if (field.type === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            isValid = false;
            errorMessage = 'Veuillez entrer une adresse email valide';
        }
    }
    
    // Phone validation
    if (field.type === 'tel' && value) {
        const phoneRegex = /^[+]?[\d\s-]{8,}$/;
        if (!phoneRegex.test(value)) {
            isValid = false;
            errorMessage = 'Veuillez entrer un numéro de téléphone valide';
        }
    }

    // Update UI
    const container = field.closest('.form-group');
    if (container) {
        const errorElement = container.querySelector('.error-message');
        
        if (!isValid) {
            field.classList.add('error');
            if (errorElement) {
                errorElement.textContent = errorMessage;
            } else {
                const newError = document.createElement('div');
                newError.className = 'error-message';
                newError.textContent = errorMessage;
                container.appendChild(newError);
            }
        } else {
            field.classList.remove('error');
            if (errorElement) {
                errorElement.remove();
            }
        }
    }

    return isValid;
}

// Navigation confirmation
window.addEventListener('beforeunload', function(e) {
    const form = document.querySelector('.service-form');
    if (form && isFormDirty(form)) {
        e.preventDefault();
        e.returnValue = '';
    }
});

function isFormDirty(form) {
    const inputs = form.querySelectorAll('input, textarea');
    for (let input of inputs) {
        if (input.type === 'checkbox') {
            if (input.checked !== input.defaultChecked) return true;
        } else if (input.value !== input.defaultValue) return true;
    }
    return false;
}
