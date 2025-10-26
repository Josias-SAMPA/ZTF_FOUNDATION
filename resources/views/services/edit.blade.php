<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Service - ZTF Foundation</title>
    
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
</head>
<body>
    <div class="container">
        @if (!Auth::user()->isAdmin2() && !Auth::user()->isSuperAdmin() && !Auth::user()->isAdmin1() && !(str_starts_with(Auth::user()->matricule, 'CM-HQ-') && str_ends_with(Auth::user()->matricule, '-CD')))
            <div class="alert">
                <strong>AccÃ¨s non autorisÃ©!</strong>
                <span>Seuls les chefs de dÃ©partement peuvent modifier des services.</span>
            </div>
        @else
            <div class="header">
                <h1>Modifier le service</h1>
                <p>Modifiez les informations ci-dessous pour mettre Ã  jour le service</p>
            </div>

            @if ($errors->any())
                <div class="error-list">
                    <strong>Erreurs!</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('services.update', $service->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Nom du service*</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $service->name) }}" 
                        required 
                        placeholder="Entrez le nom du service"
                    >
                </div>

                <div class="form-group">
                    <label for="description">Description*</label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="4" 
                        required 
                        placeholder="DÃ©crivez le rÃ´le et les responsabilitÃ©s du service"
                    >{{ old('description', $service->description) }}</textarea>
                </div>

                <div class="buttons">
                    <a href="{{ route('services.index') }}" class="btn btn-cancel">
                        Annuler
                    </a>
                    <button type="submit" class="btn btn-submit">
                        Mettre Ã  jour le service
                    </button>
                </div>
            </form>
        @endif
    </div>
</body>
</html>
