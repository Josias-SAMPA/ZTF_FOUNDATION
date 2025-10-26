<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DÃ©tails de l'Utilisateur - {{ $user->name }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
</head>
<body class="bg-gray-100">
    <div class="user-details-container">
        <!-- En-tÃªte avec informations de base -->
        <div class="header">
            <div class="user-profile">
                <div class="profile-image">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="profile-info">
                    <h1>{{ $user->name }}</h1>
                    <p>{{ $user->email }}</p>
                    <span class="status-badge {{ $user->is_active ? 'status-active' : 'status-inactive' }}">
                        {{ $user->is_active ? 'Actif' : 'Inactif' }}
                    </span>
                </div>
            </div>
            <div class="action-buttons">
                <a href="{{ route('committee.staff.index') }}" class="btn btn-back">
                    <i class="fas fa-arrow-left"></i>
                    Retour
                </a>
                <a href="{{ route('committee.staff.edit', $user->id) }}" class="btn btn-edit">
                    <i class="fas fa-edit"></i>
                    Modifier
                </a>
                <form action="{{ route('committee.staff.destroy', $user->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-delete" onclick="return confirm('ÃŠtes-vous sÃ»r de vouloir supprimer cet utilisateur ?')">
                        <i class="fas fa-trash"></i>
                        Supprimer
                    </button>
                </form>
            </div>
        </div>

        <!-- Grille d'informations -->
        <div class="info-grid">
            <div class="info-card">
                <h3>Matricule</h3>
                <p>{{ $user->matricule ?? 'Non assignÃ©' }}</p>
            </div>
            <div class="info-card">
                <h3>RÃ´le</h3>
                <p>
                    @if($user->isAdmin1())
                        Administrateur
                    @elseif($user->isAdmin2())
                        Chef de DÃ©partement
                    @elseif($user->isChefService())
                        Chef de Service
                    @else
                        Staff
                    @endif
                </p>
            </div>
            <div class="info-card">
                <h3>DÃ©partement</h3>
                <p>{{ $user->department->name ?? 'Non assignÃ©' }}</p>
            </div>
            <div class="info-card">
                <h3>Service</h3>
                <p>{{ $user->service->name ?? 'Non assignÃ©' }}</p>
            </div>
            <div class="info-card">
                <h3>Date d'inscription</h3>
                <p>{{ $user->created_at->format('d/m/Y') }}</p>
            </div>
            <div class="info-card">
                <h3>DerniÃ¨re connexion</h3>
                <p>{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Jamais' }}</p>
            </div>
        </div>

        <!-- Section des activitÃ©s rÃ©centes -->
        <div class="activity-section">
            <h2 class="activity-header">ActivitÃ©s rÃ©centes</h2>
            <div class="activity-list">
                @forelse($activities ?? [] as $activity)
                    <div class="activity-item">
                        <span class="activity-info">{{ $activity->description }}</span>
                        <span class="activity-date">{{ $activity->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <div class="activity-item">
                        <span class="activity-info">Aucune activitÃ© rÃ©cente</span>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</body>
</html>
