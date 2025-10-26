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
    


    <script src="{{ asset('js/settings-content.js') }}"></script>
