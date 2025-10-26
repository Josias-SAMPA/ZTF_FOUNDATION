document.addEventListener('DOMContentLoaded', function() {
            // Gestion des Ã©tapes
            const steps = document.querySelectorAll('.step');
            const stages = document.querySelectorAll('.form-stage');
            let currentStep = 1;
            
            // Fonction pour gÃ©rer les formulaires avec Ajax
            function handleForm(formId, url, nextStep) {
                const form = document.getElementById(formId);
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(form);
                    const button = form.querySelector('button[type="submit"]');
                    button.classList.add('loading');

                    fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (data.testCode) {
                                // Auto-remplir le code pour le test
                                document.getElementById('code').value = data.testCode;
                            }
                            if (data.redirect) {
                                window.location.href = data.redirect;
                            } else {
                                updateSteps(nextStep);
                            }
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Une erreur est survenue');
                    })
                    .finally(() => {
                        button.classList.remove('loading');
                    });
                });
            }

            function updateSteps(step) {
                steps.forEach(s => {
                    const stepNum = parseInt(s.dataset.step);
                    if (stepNum < step) {
                        s.classList.add('completed');
                        s.classList.remove('active');
                    } else if (stepNum === step) {
                        s.classList.add('active');
                        s.classList.remove('completed');
                    } else {
                        s.classList.remove('active', 'completed');
                    }
                });

                stages.forEach((stage, index) => {
                    if (index + 1 === step) {
                        stage.classList.add('active');
                    } else {
                        stage.classList.remove('active');
                    }
                });
            }

            // Animation du bouton lors du clic
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    this.classList.add('loading');
                    setTimeout(() => {
                        this.classList.remove('loading');
                    }, 2000);
                });
            });

            // Formatage automatique du code de vÃ©rification
            const codeInput = document.getElementById('code');
            if (codeInput) {
                codeInput.addEventListener('input', function() {
                    this.value = this.value.replace(/\D/g, '').slice(0, 12);
                });
            }

            // Timer
            let countdown;
            function startTimer(duration) {
                const countdownDisplay = document.getElementById('countdown');
                let timer = duration;

                countdown = setInterval(() => {
                    countdownDisplay.textContent = timer;
                    
                    if (--timer < 0) {
                        clearInterval(countdown);
                        alert('Le code a expirÃ©. Veuillez demander un nouveau code.');
                        updateSteps(1);
                    }
                }, 1000);
            }

            // DÃ©marrer le timer quand l'Ã©tape 2 est active
            if (document.getElementById('stage2').classList.contains('active')) {
                startTimer(30);
            }

            // Initialiser les gestionnaires de formulaire
            handleForm('emailForm', '{{ route("sendCode") }}', 2);
            handleForm('verificationForm', '{{ route("verifyCode") }}', 3);

            // Nettoyage lors de la destruction
            return () => {
                if (countdown) clearInterval(countdown);
            };
        });
