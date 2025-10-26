    <link rel="stylesheet" href="{{ asset('css/settings.css') }}">
@once
    
@endonce

<div class="settings-container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <div class="settings-grid">
        @include('departments.partials.pdf-download')
        
        <!-- ParamÃ¨tres du DÃ©partement -->
        <div class="settings-card">
            <h3>
                <i class="fas fa-building"></i>
                Informations du DÃ©partement
            </h3>
            <form class="settings-form" action="{{ route('departments.update.settings') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nom du dÃ©partement</label>
                    <input type="text" class="form-input" value="{{ $department->name ?? 'Non assignÃ©' }}" readonly>
                </div>
                <div class="form-group">
                    <label class="form-label">Code du dÃ©partement</label>
                    <input type="text" class="form-input" value="{{ $department->code ?? 'Non assignÃ©' }}" readonly>
                </div>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea class="form-input" rows="3" name="description">{{ $department->description ?? '' }}</textarea>
                </div>
                @if(!$department)
                    <div class="alert alert-warning">
                        Vous n'Ãªtes pas encore assignÃ© Ã  un dÃ©partement. Contactez un administrateur.
                    </div>
                @endif
                <button type="submit" class="btn-save">Enregistrer les modifications</button>
            </form>
        </div>

        <!-- ParamÃ¨tres de Notification -->
        <div class="settings-card">
            <h3>
                <i class="fas fa-bell"></i>
                Notifications
            </h3>
            <form class="settings-form" action="{{ route('departments.update.notifications') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Notifications par email</label>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <label class="toggle-switch">
                            <input type="checkbox" name="email_notifications" checked>
                            <span class="toggle-slider"></span>
                        </label>
                        <span>ActivÃ©</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">FrÃ©quence des rapports</label>
                    <select class="form-select" name="report_frequency">
                        <option value="daily">Quotidien</option>
                        <option value="weekly">Hebdomadaire</option>
                        <option value="monthly">Mensuel</option>
                    </select>
                </div>
                <button type="submit" class="btn-save">Enregistrer les prÃ©fÃ©rences</button>
            </form>
        </div>

        <!-- ParamÃ¨tres de SÃ©curitÃ© -->
        <div class="settings-card">
            <h3>
                <i class="fas fa-shield-alt"></i>
                SÃ©curitÃ©
            </h3>
            <form class="settings-form" action="{{ route('departments.update.security') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Authentification Ã  deux facteurs</label>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <label class="toggle-switch">
                            <input type="checkbox" name="two_factor">
                            <span class="toggle-slider"></span>
                        </label>
                        <span>DÃ©sactivÃ©</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Session timeout (minutes)</label>
                    <input type="number" class="form-input" name="session_timeout" value="30" min="15" max="120">
                </div>
                <button type="submit" class="btn-save">Mettre Ã  jour la sÃ©curitÃ©</button>
            </form>
        </div>

        <!-- ParamÃ¨tres d'Apparence -->
        <div class="settings-card">
            <h3>
                <i class="fas fa-paint-brush"></i>
                Apparence
            </h3>
            <form class="settings-form" action="{{ route('departments.update.appearance') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">ThÃ¨me</label>
                    <select class="form-select" name="theme">
                        <option value="light">Clair</option>
                        <option value="dark">Sombre</option>
                        <option value="system">SystÃ¨me</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Langue</label>
                    <select class="form-select" name="language">
                        <option value="fr">FranÃ§ais</option>
                        <option value="en">English</option>
                    </select>
                </div>
                <button type="submit" class="btn-save">Appliquer</button>
            </form>
        </div>
    </div>
</div>
