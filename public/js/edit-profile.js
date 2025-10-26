// Validation cÃ´tÃ© client
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const passwordConfirm = document.getElementById('password_confirmation').value;

            if (password && password !== passwordConfirm) {
                e.preventDefault();
                alert('Les mots de passe ne correspondent pas');
            }
        });
