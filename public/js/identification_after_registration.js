(function() {
            'use strict';

            let codeInputs = [];
            let timerInterval = null;
            let timeLeft = 120; // 2 minutes

            // Initialisation au chargement du DOM
            document.addEventListener('DOMContentLoaded', init);

            function init() {
                codeInputs = Array.from(document.querySelectorAll('.code-digit'));
                const verificationCodeInput = document.getElementById('verification_code');
                const form = document.querySelector('form');

                if (!codeInputs.length || !verificationCodeInput || !form) {
                    console.error('Éléments DOM manquants');
                    return;
                }

                // Attacher les événements à chaque input
                codeInputs.forEach((input, index) => {
                    attachInputEvents(input, index);
                });

                // Événement de soumission du formulaire
                form.addEventListener('submit', handleFormSubmit);

                // Démarrer le timer
                startTimer();

                // Focus initial
                if (codeInputs.length > 0) {
                    codeInputs[0].focus();
                }
            }

            /**
             * Attacher les événements à un input
             */
            function attachInputEvents(input, index) {
                // Événement input (saisie de caractères)
                input.addEventListener('input', function(e) {
                    const value = this.value;

                    // Accepter uniquement les chiffres
                    if (value && !/^\d$/.test(value)) {
                        this.value = '';
                        return;
                    }

                    // Auto-focus au chiffre suivant
                    if (value) {
                        if (index < codeInputs.length - 1) {
                            codeInputs[index + 1].focus();
                        }
                    }

                    updateHiddenField();
                });

                // Événement keydown (clavier)
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace') {
                        e.preventDefault();
                        this.value = '';

                        // Retour au chiffre précédent
                        if (index > 0) {
                            codeInputs[index - 1].focus();
                            codeInputs[index - 1].value = '';
                        }

                        updateHiddenField();
                    } 
                    else if (e.key === 'ArrowRight' && index < codeInputs.length - 1) {
                        e.preventDefault();
                        codeInputs[index + 1].focus();
                    } 
                    else if (e.key === 'ArrowLeft' && index > 0) {
                        e.preventDefault();
                        codeInputs[index - 1].focus();
                    }
                });

                // Événement paste (collage)
                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const pastedText = (e.clipboardData || window.clipboardData).getData('text').trim();

                    if (/^\d{8}$/.test(pastedText)) {
                        pastedText.split('').forEach((digit, i) => {
                            if (i < codeInputs.length) {
                                codeInputs[i].value = digit;
                            }
                        });
                        codeInputs[codeInputs.length - 1].focus();
                        updateHiddenField();
                    } else {
                        alert('Veuillez coller un code à 8 chiffres');
                    }
                });

                // Prévention de copier non-numérique
                input.addEventListener('keypress', function(e) {
                    if (!/\d/.test(e.key)) {
                        e.preventDefault();
                    }
                });
            }

            /**
             * Mettre à jour le champ caché avec le code complet
             */
            function updateHiddenField() {
                const verificationCodeInput = document.getElementById('verification_code');
                const code = codeInputs.map(input => input.value).join('');
                verificationCodeInput.value = code;
            }

            /**
             * Gestion de la soumission du formulaire
             */
            function handleFormSubmit(e) {
                const code = codeInputs.map(input => input.value).join('');

                if (code.length !== 8) {
                    e.preventDefault();
                    alert('Veuillez entrer les 8 chiffres du code d\'identification.');
                    codeInputs[0].focus();
                }
            }

            /**
             * Démarrer le minuteur de 2 minutes
             */
            function startTimer() {
                const timerElement = document.getElementById('timer');

                // Mettre le timer en rouge dès le départ
                timerElement.style.color = '#dc3545';
                timerElement.style.fontWeight = 'bold';

                timerInterval = setInterval(() => {
                    const minutes = Math.floor(timeLeft / 60);
                    const seconds = timeLeft % 60;
                    const displayTime = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

                    timerElement.textContent = displayTime;

                    // À l'expiration
                    if (timeLeft === 0) {
                        clearInterval(timerInterval);
                        handleTimerExpired();
                    }

                    timeLeft--;
                }, 1000);
            }

            /**
             * Gestion de l'expiration du timer
             */
            function handleTimerExpired() {
                const timerElement = document.getElementById('timer');
                const submitButton = document.querySelector('.submit-button');

                timerElement.textContent = 'Expiré';
                timerElement.style.color = '#dc3545';

                // Désactiver tous les inputs
                codeInputs.forEach(input => {
                    input.disabled = true;
                });

                // Désactiver le bouton de soumission
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.textContent = 'Code expiré';
                    submitButton.style.opacity = '0.5';
                }
            }
        })();
