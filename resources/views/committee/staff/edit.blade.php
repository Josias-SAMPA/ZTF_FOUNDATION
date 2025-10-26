<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'Utilisateur - {{ $user->name }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
</head>
<body class="bg-gray-100">
    <div class="form-container">
        <div class="form-header">
            <h1>Modifier l'Utilisateur - {{ $user->name }}</h1>
        </div>

        <form action="{{ route('committee.staff.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Informations de base -->
            <div class="form-section">
                <h2>Informations Personnelles</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Nom Complet</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Adresse Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    Laissez les champs du mot de passe vides si vous ne souhaitez pas le modifier.
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="password">Nouveau mot de passe</label>
                        <input type="password" id="password" name="password">
                        @error('password')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirmer le nouveau mot de passe</label>
                        <input type="password" id="password_confirmation" name="password_confirmation">
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
                                <option value="{{ $department->id }}" 
                                    {{ old('department_id', $user->department_id) == $department->id ? 'selected' : '' }}>
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
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" 
                                    {{ old('service_id', $user->service_id) == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('service_id')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role">RÃ´le</label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="">SÃ©lectionner un rÃ´le</option>
                            <option value="admin1" {{ $user->isAdmin1() ? 'selected' : '' }}>Administrateur</option>
                            <option value="admin2" {{ $user->isAdmin2() ? 'selected' : '' }}>Chef de DÃ©partement</option>
                            <option value="chef_service" {{ $user->isChefService() ? 'selected' : '' }}>Chef de Service</option>
                            <option value="staff" {{ $user->isStaff() ? 'selected' : '' }}>Staff</option>
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
                            <input type="checkbox" name="is_active" value="1" 
                                {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
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
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>

    
    <script src="{{ asset('js/edit.js') }}"></script>
</body>
</html>
