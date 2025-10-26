function confirmDeleteService() {
            if (confirm('ÃŠtes-vous sÃ»r de vouloir supprimer ce service ?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('departments.services.destroy', ['department' => $department->id, 'service' => $service->id]) }}';
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }
