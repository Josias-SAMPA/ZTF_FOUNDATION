<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CrÃ©er un Service - ZTF Foundation</title>
    
    <link rel="stylesheet" href="{{ asset('css/create_with_auth.css') }}">
</head>
<body>
    <div class="container">
        @if (!Auth::user()->isAdmin2() && !Auth::user()->isSuperAdmin() && !Auth::user()->isAdmin1() && !(str_starts_with(Auth::user()->matricule, 'CM-HQ-') && str_ends_with(Auth::user()->matricule, '-CD')))
            <div class="alert">
                <strong>AccÃ¨s non autorisÃ©!</strong>
                <span>Seuls les chefs de dÃ©partement peuvent crÃ©er des services.</span>
            </div>
        @else
            <div class="header">
                <h1>CrÃ©er un nouveau service</h1>
                <p>Remplissez les informations ci-dessous pour crÃ©er un service</p>
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

            <form action="{{ route('services.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Nom du service*</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}" 
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
                    >{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="manager_matricule">Matricule du Manager*</label>
                    <input 
                        type="text" 
                        id="manager_matricule" 
                        name="manager_matricule" 
                        value="{{ old('manager_matricule') }}" 
                        required 
                        placeholder="Ex: EMP-001"
                    >
                    <p class="help-text">Le manager sera automatiquement assignÃ© Ã  ce service.</p>
                </div>

                @if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin1())
                    <div class="form-group">
                        <label for="department_id">DÃ©partement*</label>
                        <select name="department_id" id="department_id" required>
                            <option value="">SÃ©lectionnez un dÃ©partement</option>
                            @foreach($departments as $department)
                                <option 
                                    value="{{ $department->id }}" 
                                    {{ old('department_id') == $department->id ? 'selected' : '' }}
                                >
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <div class="form-group">
                        <label>DÃ©partement</label>
                        <div class="department-info">
                            {{ Auth::user()->department->name ?? 'Non assignÃ©' }}
                        </div>
                    </div>
                @endif

                <div class="buttons">
                    <a href="{{ route('services.index') }}" class="btn btn-cancel">
                        Annuler
                    </a>
                    <button type="submit" class="btn btn-submit">
                        CrÃ©er le service
                    </button>
                </div>
            </form>
        @endif
    </div>
</body>
</html>
