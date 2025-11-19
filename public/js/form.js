document.getElementById('registrationForm').addEventListener('submit', function(e) {
                // Récupérer les valeurs avant soumission
                const firstName = document.getElementById('name').value;
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;
                
                // Enregistrer dans sessionStorage pour utilisation ultérieure
                sessionStorage.setItem('firstName', firstName);
                sessionStorage.setItem('email', email);
                sessionStorage.setItem('password', password);
                
                // Vider les champs après soumission
                setTimeout(() => {
                    document.getElementById('name').value = '';
                    document.getElementById('email').value = '';
                    document.getElementById('password').value = '';
                }, 100);
            });