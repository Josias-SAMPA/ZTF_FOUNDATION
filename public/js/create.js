// Ajout de la validation cÃ´tÃ© client
        document.querySelector('form').addEventListener('submit', function(e) {
            let isValid = true;
            const name = document.getElementById('name');
            const description = document.getElementById('display_name');
            const head_id = document.getElementById('description');

            // Validation du nom
            if (!name.value.trim()) {
                isValid = false;
                name.classList.add('border-red-500');
            } else {
                name.classList.remove('border-red-500');
            }

            // Validation de la description
            if (!description.value.trim()) {
                isValid = false;
                description.classList.add('border-red-500');
            } else {
                description.classList.remove('border-red-500');
            }

            if (!display_name.value.trim()) {
                isValid = false;
                display_name.classList.add('border-red-500');
            } else {
                display_name.classList.remove('border-red-500');
            }
        });
