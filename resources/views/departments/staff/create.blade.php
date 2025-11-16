<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un employé - {{ auth()->user()->department->name ?? 'Département' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboards.css') }}">
    
    <link rel="stylesheet" href="{{ asset('css/header-styles.css?v=' . filemtime(public_path('css/header-styles.css'))) }}">
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
</head>
<body>
    <div class="dashboard-container">
        <main class="main-content">
            <div class="breadcrumb-container">
                <div class="breadcrumb">
                    <a href="{{ route('departments.dashboard') }}" class="breadcrumb-item">
                        <i class="fas fa-home"></i>
                        <span>Tableau de bord</span>
                    </a>
                    <span class="breadcrumb-separator">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                    <a href="{{ route('departments.staff.index') }}" class="breadcrumb-item">
                        <i class="fas fa-users"></i>
                        <span>Employés</span>
                    </a>
                    <span class="breadcrumb-separator">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                    <span class="breadcrumb-item active">
                        <i class="fas fa-user-plus"></i>
                        <span>Ajouter un employé</span>
                    </span>
                </div>
            </div>

            <div class="page-header-section">
                <div class="header-content">
                    <div class="header-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="header-info">
                        <h1 class="page-title">Ajouter un nouvel employé</h1>
                        <p class="page-subtitle">Créez un compte pour un nouvel employé du département</p>
                    </div>
                </div>
            </div>

                @if(session('error'))
                    <div class="alert alert-danger">
                        <h3 class="alert-title">
                            <i class="fas fa-exclamation-circle"></i>
                            Une erreur est survenue
                        </h3>
                        <p class="alert-message">{{ session('error') }}</p>
                        
                        @if(session('error_details') && app()->environment('local', 'development'))
                            <div class="error-details">
                                <h4>Détails de l'erreur :</h4>
                                <ul class="error-list">
                                    <li><strong>Type :</strong> {{ session('error_details')['type'] ?? 'Inconnu' }}</li>
                                    <li><strong>Fichier :</strong> {{ session('error_details')['file'] ?? 'Inconnu' }}</li>
                                    <li><strong>Ligne :</strong> {{ session('error_details')['line'] ?? 'Inconnue' }}</li>
                                    <li><strong>Message :</strong> {{ session('error_details')['message'] ?? 'Aucun message' }}</li>
                                </ul>
                            </div>
                        @endif
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <h3 class="alert-title">
                            <i class="fas fa-exclamation-triangle"></i>
                            Erreurs de validation
                        </h3>
                        <ul class="error-list">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('departments.staff.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-section">
                        <h2 class="form-section-title">
                            <i class="fas fa-info-circle"></i>
                            Informations de base
                        </h2>
                        <div class="form-grid">
                            <!-- Nom -->
                            <div class="form-group">
                                <label for="name" class="form-label required">Nom complet</label>
                                <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label for="email" class="form-label required">Adresse email</label>
                                <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Matricule -->
                            <div class="form-group">
                                <label for="matricule" class="form-label">Matricule</label>
                                <input type="text" id="matricule" class="form-input" value="STFxxxx" disabled>
                                <div class="form-helper">Le matricule sera généré automatiquement lors de la création (format: STF0001)</div>
                            </div>

                            <!-- Service -->
                            <div class="form-group">
                                <label for="service_id" class="form-label required">Service</label>
                                <select id="service_id" name="service_id" class="form-select" required>
                                    <option value="">Sélectionnez un service</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
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
                                <label for="password" class="form-label required">Mot de passe temporaire</label>
                                <input type="password" id="password" name="password" class="form-input" required>
                                <div class="form-helper">L'employé devra changer son mot de passe à sa première connexion</div>
                                @error('password')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirmation du mot de passe -->
                            <div class="form-group">
                                <label for="password_confirmation" class="form-label required">Confirmez le mot de passe</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
                                @error('password_confirmation')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
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
                                    <input type="radio" name="is_active" value="1" class="radio-input" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                    <i class="fas fa-check-circle text-green-500"></i>
                                    Actif
                                </label>
                                <label class="radio-label">
                                    <input type="radio" name="is_active" value="0" class="radio-input" {{ old('is_active') == '0' ? 'checked' : '' }}>
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
                        <a href="{{ route('departments.staff.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i>
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Ajouter l'employé
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    
    <script src="{{ asset('js/create.js') }}"></script>
</body>
</html>
