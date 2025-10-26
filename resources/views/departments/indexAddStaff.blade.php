<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Assigner Utilisateurs Ã  un DÃ©partement</title>
    
    <link rel="stylesheet" href="{{ asset('css/indexAddStaff.css') }}">
</head>
<body>
    <div class="container">
        <h1>Assigner des utilisateurs Ã  un dÃ©partement</h1>

        <div class="form-container">
            <form action="{{ route('departments.assignUsers', $department->id) }}" method="POST">

                @csrf
                @method('PUT')

                <!-- SÃ©lection du dÃ©partement -->
                <div class="form-group">
                    <label class="form-label" for="department">DÃ©partement</label>
                    <input type="text" id="department" name="department" class="form-input" value="{{ $department->name }}" disabled>
                </div>

                <!-- Liste des utilisateurs -->
                <div class="form-group">
                    <label class="form-label" for="users">SÃ©lectionner les utilisateurs</label>
                    <select id="users" name="users[]" class="form-select" multiple required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ in_array($user->id, $assignedUsers ?? []) ? 'selected' : '' }}>
                                {{ $user->matricule }} - {{ $user->email }}
                            </option>
                        @endforeach
                    </select>
                    <small style="color:#475569;font-size:0.75rem;">Maintenir CTRL (ou CMD sur Mac) pour sÃ©lectionner plusieurs utilisateurs.</small>
                </div>

                <!-- Boutons -->
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Assigner</button>
                    <a href="{{ route('departments.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

