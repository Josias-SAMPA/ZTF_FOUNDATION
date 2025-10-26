<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CrÃ©er un Utilisateur</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
</head>
<body class="bg-gray-100">
    <div class="form-container">
        <div class="form-header">
            <h1>CrÃ©er un Nouvel Utilisateur</h1>
        </div>

        <form action="{{ route('committee.staff.store') }}" method="POST">
            @csrf

            <!-- Informations de base -->
            <div class="form-section">
                <h2>Informations Personnelles</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Nom Complet</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Adresse Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" required>
                        @error('password')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirmer le mot de passe</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
            </div>

            <!-- Affectation -->
            <div class="form-section">
                <h2>Affectation</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="department_id">DÃ©partement</label>
                        <select id="department_id" name="department_id" class="form-select">
                            <option value="">SÃ©lectionner un dÃ©partement</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="service_id">Service</label>
                        <select id="service_id" name="service_id" class="form-select">
                            <option value="">SÃ©lectionner un service</option>
                            <!-- Les services seront chargÃ©s dynamiquement via JavaScript -->
                        </select>
                        @error('service_id')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role">RÃ´le</label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="">SÃ©lectionner un rÃ´le</option>
                            <option value="admin1" {{ old('role') == 'admin1' ? 'selected' : '' }}>Administrateur</option>
                            <option value="admin2" {{ old('role') == 'admin2' ? 'selected' : '' }}>Chef de DÃ©partement</option>
                            <option value="chef_service" {{ old('role') == 'chef_service' ? 'selected' : '' }}>Chef de Service</option>
                            <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                        </select>
                        @error('role')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- ParamÃ¨tres du compte -->
            <div class="form-section">
                <h2>ParamÃ¨tres du Compte</h2>
                <div class="form-group">
                    <label>Statut du compte</label>
                    <div class="switch-container">
                        <label class="switch">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <span class="slider"></span>
                        </label>
                        <span>Compte actif</span>
                    </div>
                    @error('is_active')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="action-buttons">
                <a href="{{ route('committee.staff.index') }}" class="btn btn-cancel">
                    <i class="fas fa-times"></i>
                    Annuler
                </a>
                <button type="submit" class="btn btn-submit">
                    <i class="fas fa-save"></i>
                    CrÃ©er l'utilisateur
                </button>
            </div>
        </form>
    </div>

    
    <script src="{{ asset('js/create.js') }}"></script>
</body>
</html>
