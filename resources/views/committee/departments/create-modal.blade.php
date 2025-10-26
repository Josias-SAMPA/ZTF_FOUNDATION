    <link rel="stylesheet" href="{{ asset('css/create-modal.css') }}">
<!-- Formulaire de crÃ©ation de dÃ©partement -->
<div id="departmentFormModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Nouveau DÃ©partement</h2>
            <span class="close" onclick="toggleDepartmentForm()">&times;</span>
        </div>
        <form action="{{ route('departments.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nom du dÃ©partement</label>
                <input type="text" id="name" name="name" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="code">Code du dÃ©partement</label>
                <input type="text" id="code" name="code" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-input" rows="3"></textarea>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="toggleDepartmentForm()">Annuler</button>
                <button type="submit" class="btn btn-primary">CrÃ©er le dÃ©partement</button>
            </div>
        </form>
    </div>
</div>




    <script src="{{ asset('js/create-modal.js') }}"></script>
