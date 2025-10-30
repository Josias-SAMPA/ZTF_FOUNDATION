<div class="settings-card">
    <h3>
        <i class="fas fa-file-pdf"></i>
        Documentation du département
    </h3>
    <div class="settings-form">
        <div class="form-group">
            <label class="form-label">État des effectifs et des services</label>
            <p class="text-muted" style="margin-bottom: 1rem;">
                Générez un rapport détaillé de l'organisation du département, incluant la liste des services et du personnel.
            </p>
            <div style="display: flex; gap: 1rem;">
                <a href="{{ route('departments.pdf.generate') }}" class="btn-save" style="text-decoration: none;">
                    <i class="fas fa-download"></i>
                    Générer le rapport PDF
                </a>
                <a href="{{ route('departments.pdf.history') }}" class="btn-save" style="background-color: #64748b; text-decoration: none;">
                    <i class="fas fa-history"></i>
                    Historique des générations
                </a>
            </div>
        </div>
    </div>
</div>