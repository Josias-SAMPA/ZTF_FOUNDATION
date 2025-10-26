// Pour la confirmation de suppression
        document.querySelectorAll('.btn-remove').forEach(button => {
            button.addEventListener('click', function(e) {
                if (!confirm('ÃŠtes-vous sÃ»r de vouloir retirer ce chef de dÃ©partement ?')) {
                    e.preventDefault();
                }
            });
        });
