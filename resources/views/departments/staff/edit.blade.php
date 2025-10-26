<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'employÃ© - {{ $staff->name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboards.css') }}">
    
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
</head>
<body>
    <div class="dashboard-container">
        <main class="main-content">
            <div class="breadcrumb">
                <a href="{{ route('departments.dashboard') }}">
                    <i class="fas fa-home"></i>
                    Tableau de bord
                </a>
                <span class="breadcrumb-separator">/</span>
                <a href="{{ route('departments.staff.index') }}">
                    <i class="fas fa-users"></i>
                    EmployÃ©s
                </a>
                <span class="breadcrumb-separator">/</span>
                <a href="{{ route('staff.show', $staff) }}">
                    <i class="fas fa-user"></i>
                    {{ $staff->name }}
                </a>
                <span class="breadcrumb-separator">/</span>
                <span>Modifier</span>
            </div>

            <div class="form-container">
                <h1 class="form-title">
                    <i class="fas fa-user-edit"></i>
                    Modifier les informations de {{ $staff->name }}
                </h1>

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('staff.update', $staff) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-section">
                        <h2 class="form-section-title">
                            <i class="fas fa-info-circle"></i>
                            Informations de base
                        </h2>
                        <div class="form-grid">
                            <!-- Nom -->
                            <div class="form-group">
                                <label for="name" class="form-label required">Nom complet</label>
                                <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $staff->name) }}" required>
                                @error('name')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label for="email" class="form-label required">Adresse email</label>
                                <input type="email" id="email" name="email" class="form-input" value="{{ old('email', $staff->email) }}" required>
                                @error('email')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Matricule (en lecture seule) -->
                            <div class="form-group">
                                <label for="matricule" class="form-label">Matricule</label>
                                <input type="text" id="matricule" class="form-input" value="{{ $staff->matricule }}" disabled>
                                <div class="form-helper">Le matricule ne peut pas Ãªtre modifiÃ©</div>
                            </div>

                            <!-- Service -->
                            <div class="form-group">
                                <label for="service_id" class="form-label required">Service</label>
                                <select id="service_id" name="service_id" class="form-select" required>
                                    <option value="">SÃ©lectionnez un service</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" {{ old('service_id', $staff->service_id) == $service->id ? 'selected' : '' }}>
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('service_id')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2 class="form-section-title">
                            <i class="fas fa-lock"></i>
                            Mot de passe
                        </h2>
                        <div class="form-grid">
                            <!-- Mot de passe -->
                            <div class="form-group">
                                <label for="password" class="form-label">Nouveau mot de passe</label>
                                <input type="password" id="password" name="password" class="form-input">
                                <div class="form-helper">Laissez vide pour conserver le mot de passe actuel</div>
                                @error('password')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirmation du mot de passe -->
                            <div class="form-group">
                                <label for="password_confirmation" class="form-label">Confirmez le nouveau mot de passe</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input">
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2 class="form-section-title">
                            <i class="fas fa-toggle-on"></i>
                            Statut du compte
                        </h2>
                        <div class="form-group">
                            <div class="radio-group">
                                <label class="radio-label">
                                    <input type="radio" name="is_active" value="1" class="radio-input" {{ old('is_active', $staff->is_active) ? 'checked' : '' }}>
                                    <i class="fas fa-check-circle text-green-500"></i>
                                    Actif
                                </label>
                                <label class="radio-label">
                                    <input type="radio" name="is_active" value="0" class="radio-input" {{ old('is_active', $staff->is_active) ? '' : 'checked' }}>
                                    <i class="fas fa-times-circle text-red-500"></i>
                                    Inactif
                                </label>
                            </div>
                            @error('is_active')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('staff.show', $staff) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i>
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    
    <script src="{{ asset('js/edit.js') }}"></script>
</body>
</html>
