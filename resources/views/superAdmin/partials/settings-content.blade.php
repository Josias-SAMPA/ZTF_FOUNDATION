    <link rel="stylesheet" href="{{ asset('css/settings-content.css') }}">
<div class="settings-container">
    <!-- ParamÃ¨tres du site -->
    <div class="settings-section">
        <h2 class="settings-title">
            <i class="fas fa-globe"></i>
            ParamÃ¨tres du site
        </h2>
        <div class="settings-content">
            <form action="{{ route('settings.site.update') }}" method="POST" class="settings-form">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Nom du site</label>
                    <input type="text" name="site_name" value="{{ config('app.name') }}" class="form-input">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="site_description" class="form-input" rows="3">{{ config('app.description') }}</textarea>
                </div>
                <div class="form-group">
                    <label>Email de contact</label>
                    <input type="email" name="contact_email" value="{{ config('mail.from.address') }}" class="form-input">
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
            </form>
        </div>
    </div>

    <!-- ParamÃ¨tres de sÃ©curitÃ© -->
    <div class="settings-section">
        <h2 class="settings-title">
            <i class="fas fa-shield-alt"></i>
            ParamÃ¨tres de sÃ©curitÃ©
        </h2>
        <div class="settings-content">
            <form action="{{ route('settings.security.update') }}" method="POST" class="settings-form">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="toggle-label">
                        <input type="checkbox" name="two_factor_auth" class="toggle-input">
                        <span class="toggle-slider"></span>
                        Authentification Ã  deux facteurs
                    </label>
                </div>
                <div class="form-group">
                    <label class="toggle-label">
                        <input type="checkbox" name="force_password_change" class="toggle-input">
                        <span class="toggle-slider"></span>
                        Forcer le changement de mot de passe aprÃ¨s 90 jours
                    </label>
                </div>
                <div class="form-group">
                    <label>DurÃ©e de session (minutes)</label>
                    <input type="number" name="session_lifetime" value="120" class="form-input" min="1">
                </div>
                <button type="submit" class="btn btn-primary">Mettre Ã  jour la sÃ©curitÃ©</button>
            </form>
        </div>
    </div>

    <!-- ParamÃ¨tres de notification -->
    <div class="settings-section">
        <h2 class="settings-title">
            <i class="fas fa-bell"></i>
            ParamÃ¨tres de notification
        </h2>
        <div class="settings-content">
            <form action="{{ route('settings.notifications.update') }}" method="POST" class="settings-form">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="toggle-label">
                        <input type="checkbox" name="email_notifications" class="toggle-input">
                        <span class="toggle-slider"></span>
                        Notifications par email
                    </label>
                </div>
                <div class="form-group">
                    <label class="toggle-label">
                        <input type="checkbox" name="activity_notifications" class="toggle-input">
                        <span class="toggle-slider"></span>
                        Notifications d'activitÃ©
                    </label>
                </div>
                <div class="form-group">
                    <label class="toggle-label">
                        <input type="checkbox" name="security_notifications" class="toggle-input">
                        <span class="toggle-slider"></span>
                        Alertes de sÃ©curitÃ©
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer les prÃ©fÃ©rences</button>
            </form>
        </div>
    </div>

    <!-- ParamÃ¨tres de sauvegarde -->
    <div class="settings-section">
        <h2 class="settings-title">
            <i class="fas fa-database"></i>
            Sauvegarde et maintenance
        </h2>
        <div class="settings-content">
            <div class="backup-actions">
                <button class="btn btn-secondary" onclick="triggerBackup()">
                    <i class="fas fa-download"></i>
                    CrÃ©er une sauvegarde
                </button>
                <button class="btn btn-secondary" onclick="clearCache()">
                    <i class="fas fa-broom"></i>
                    Nettoyer le cache
                </button>
                <button class="btn btn-danger" onclick="confirmMaintenance()">
                    <i class="fas fa-tools"></i>
                    Mode maintenance
                </button>
            </div>
            <div class="backup-list">
                <h3>Sauvegardes rÃ©centes</h3>
                <table class="backup-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Taille</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Liste des sauvegardes -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>




    <script src="{{ asset('js/settings-content.js') }}"></script>
