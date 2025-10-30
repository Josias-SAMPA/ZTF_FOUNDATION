<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création d'un nouveau service - {{ config('app.name') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
    <style>
        .back-button {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <a href="{{ route('departments.dashboard') }}" class="btn btn-secondary back-button">
        <i class="fas fa-arrow-left"></i>
        Retour au tableau de bord
    </a>

    <h1>Création d'un nouveau service</h1>
    
    <div class="form-container">
        <form action="{{ route('departments.services.store', ['department' => $department->id]) }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label" for="name">
                    Nom du service <span class="required">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       class="form-input @error('name') error @enderror" 
                       value="{{ old('name') }}" 
                       required>
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="description">
                    Description détaillée du service
                </label>
                <textarea id="description" 
                          name="description" 
                          class="form-input form-textarea @error('description') error @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="location">
                    Localisation (facultatif)
                </label>
                <input type="text" 
                       id="location" 
                       name="location" 
                       class="form-input @error('location') error @enderror" 
                       value="{{ old('location') }}">
                @error('location')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="phone">
                    Téléphone (facultatif)
                </label>
                <input type="tel" 
                       id="phone" 
                       name="phone" 
                       class="form-input @error('phone') error @enderror" 
                       value="{{ old('phone') }}">
                @error('phone')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="checkbox-list">
                <div class="checkbox-item">
                    <input type="checkbox" 
                           id="is_active" 
                           name="is_active" 
                           value="1" 
                           {{ old('is_active') ? 'checked' : '' }}>
                    <label for="is_active">Activer le service</label>
                </div>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Enregistrer le service
                </button>
                <a href="{{ route('departments.services.index', ['department' => $department->id]) }}" 
                   class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Annuler la création
                </a>
            </div>
        </form>
    <!-- Notification de succès -->
    @if(session('success'))
    <div class="notification success">
        {{ session('success') }}
    </div>
    @endif
</div>

    <!-- Scripts -->
    <script src="{{ asset('js/create.js') }}"></script>
</body>
</html>
