<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services du département - {{ $department->name }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="department-id" content="{{ $department->id }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/services/index.css') }}">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="{{ route('departments.dashboard') }}" style="color: var(--primary-color); text-decoration: none; font-weight: 500;">
                <i class="fas fa-arrow-left"></i> Retour au tableau de bord
            </a>
        </div>
    </nav>

    <div class="container">
        <div class="services-container">
            <div class="page-header">
                <div class="header-content">
                    <h1>Services du département</h1>
                    <nav class="breadcrumb">
                        <a href="{{ route('departments.dashboard') }}">Tableau de bord</a> /
                        <span>Services</span>
                    </nav>
                </div>
                <div class="header-actions">
                    <a href="{{ route('departments.services.create', ['department' => $department->id]) }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Ajouter un service
                    </a>
                </div>
            </div>

            <div class="services-grid">
                @forelse($services as $service)
                    <div class="service-card">
                        <div class="service-header">
                            <h2>{{ $service->name }}</h2>
                            <span class="service-status {{ $service->is_active ? 'active' : 'inactive' }}">
                                {{ $service->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </div>
                        
                        <div class="service-body">
                            <p class="service-description">
                                {{ $service->description ?? 'Aucune description disponible' }}
                            </p>
                            
                            <div class="service-stats">
                                <div class="stat">
                                    <i class="fas fa-users"></i>
                                    <span>{{ $service->users_count ?? 0 }} employés</span>
                                    <button class="btn btn-add-user" onclick="openUsersModal({{ $service->id }})" title="Ajouter des employés">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                </div>
                                <div class="stat">
                                    <i class="fas fa-calendar"></i>
                                    <span>Créé le {{ $service->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="service-actions">
                            <a href="{{ route('departments.services.show', ['department' => $department->id, 'service' => $service->id]) }}" class="btn btn-info">
                                <i class="fas fa-eye"></i> Voir les détails
                            </a>
                            <a href="{{ route('departments.services.edit', ['department' => $department->id, 'service' => $service->id]) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <button class="btn btn-danger" onclick="confirmDeleteService({{ $department->id }}, {{ $service->id }})">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="no-services">
                        <i class="fas fa-folder-open"></i>
                        <h2>Aucun service trouvé</h2>
                        <p>Votre département n'a pas encore de services. Commencez par en créer un !</p>
                        <a href="{{ route('departments.services.create', ['department' => $department->id]) }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Créer un service
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Modal pour l'ajout d'employés -->
    <div id="addUsersModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Ajouter des employés au service</h2>
                <button class="close-modal" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="search-container">
                    <input type="text" id="userSearchInput" placeholder="Rechercher un employé..." onkeyup="filterUsers()">
                </div>
                <form id="assignUsersForm" method="POST">
                    @csrf
                    <div class="users-list">
                        <!-- La liste des utilisateurs sera chargée ici dynamiquement -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="closeModal()">Annuler</button>
                        <button type="submit" class="btn btn-primary">Affecter les employés</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="{{ asset('js/services/index.js') }}"></script>
</body>
</html>
