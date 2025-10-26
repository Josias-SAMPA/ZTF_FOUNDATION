<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigner un Chef de DÃ©partement</title>
    <link href="{{ asset('dashboards.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/assign-head.css') }}">
</head>
<body>
    <div class="assign-head-container">
        <div class="form-header">
            <h2>Assigner un Chef de DÃ©partement</h2>
        </div>

        <div class="department-info">
            <p><strong>DÃ©partement :</strong> {{ $department->name }}</p>
            <p><strong>Code :</strong> {{ $department->code }}</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if($eligibleUsers->isEmpty())
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                Aucun utilisateur Ã©ligible trouvÃ©. Les chefs de dÃ©partement doivent avoir un matricule au format CM-HQ-CODE-CD.
            </div>
        @else
            <form action="{{ route('departments.head.assign', $department->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="user_id">SÃ©lectionner un Chef de DÃ©partement</label>
                    <select name="user_id" id="user_id" class="form-select" required>
                        <option value="">-- Choisir un utilisateur --</option>
                        @foreach($eligibleUsers as $user)
                            <option value="{{ $user->id }}" class="user-option">
                                {{ $user->name }} ({{ $user->matricule }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Assigner
                    </button>
                    <a href="{{ route('committee.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                </div>
            </form>
        @endif
    </div>
</body>
</html>
