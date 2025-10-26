document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('input:not([type="radio"]), select');

            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    validateField(this);
                });
            });

            form.addEventListener('submit', function(e) {
                let isValid = true;
                inputs.forEach(input => {
                    if (!validateField(input)) {
                        isValid = false;
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                }
            });

            function validateField(input) {
                if (input.disabled) return true;
                
                const errorDiv = input.nextElementSibling;
                let isValid = true;

                if (errorDiv && errorDiv.classList.contains('error-message')) {
                    errorDiv.remove();
                }

                if (input.required && !input.value) {
                    showError(input, 'Ce champ est requis');
                    isValid = false;
                } else if (input.type === 'email' && input.value) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(input.value)) {
                        showError(input, 'Adresse email invalide');
                        isValid = false;
                    }
                } else if (input.id === 'password' && input.value) {
                    if (input.value.length < 8) {
                        showError(input, 'Le mot de passe doit contenir au moins 8 caractÃ¨res');
                        isValid = false;
                    }
                } else if (input.id === 'password_confirmation' && input.value) {
                    const password = document.getElementById('password');
                    if (input.value !== password.value) {
                        showError(input, 'Les mots de passe ne correspondent pas');
                        isValid = false;
                    }
                }

                return isValid;
            }

            function showError(input, message) {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error-message';
                errorDiv.textContent = message;
                input.parentNode.insertBefore(errorDiv, input.nextSibling);
            }
        });
