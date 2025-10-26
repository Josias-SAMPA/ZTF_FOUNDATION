<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $service->name }} - DÃ©tails du Service</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/services/show.css') }}">
</head>
<body>
<div class="service-details-container">
    <div class="page-header">
        <div class="header-content">
            <h1>{{ $service->name }}</h1>
            <nav class="breadcrumb">
                <a href="{{ route('departments.dashboard') }}">Tableau de bord</a> /
                <a href="{{ route('departments.services.index', ['department' => $department->id]) }}">Services</a> /
                <span>{{ $service->name }}</span>
            </nav>
        </div>
        <div class="header-actions">
            <a href="{{ route('departments.services.edit', ['department' => $department->id, 'service' => $service->id]) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <button class="btn btn-danger" onclick="confirmDeleteService()">
                <i class="fas fa-trash"></i> Supprimer
            </button>
        </div>
    </div>

    <div class="service-content">
        <div class="service-info-card">
            <div class="card-header">
                <h2>Informations gÃ©nÃ©rales</h2>
                <span class="service-status {{ $service->is_active ? 'active' : 'inactive' }}">
                    {{ $service->is_active ? 'Actif' : 'Inactif' }}
                </span>
            </div>
            
            <div class="info-grid">
                <div class="info-item">
                    <label>Description</label>
                    <p>{{ $service->description ?? 'Aucune description disponible' }}</p>
                </div>

                <div class="info-item">
                    <label>Localisation</label>
                    <p>{{ $service->location ?? 'Non spÃ©cifiÃ©e' }}</p>
                </div>

                <div class="info-item">
                    <label>Contact</label>
                    <p>
                        @if($service->phone || $service->email)
                            {{ $service->phone }}<br>
                            {{ $service->email }}
                        @else
                            Aucune information de contact
                        @endif
                    </p>
                </div>

                <div class="info-item">
                    <label>Date de crÃ©ation</label>
                    <p>{{ $service->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>

        <div class="service-stats-card">
            <h2>Statistiques</h2>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <span class="stat-value">{{ $service->users_count ?? 0 }}</span>
                        <span class="stat-label">EmployÃ©s</span>
                    </div>
                </div>

                <!-- Add more statistics as needed -->
            </div>
        </div>

        @if($service->users && $service->users->count() > 0)
        <div class="employees-card">
            <h2>Liste des employÃ©s</h2>
            <div class="table-responsive">
                <table class="employees-table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Poste</th>
                            <th>Date d'ajout</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($service->users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->position ?? 'Non spÃ©cifiÃ©' }}</td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>

    
    <script src="{{ asset('js/show.js') }}"></script>
</body>
</html>
