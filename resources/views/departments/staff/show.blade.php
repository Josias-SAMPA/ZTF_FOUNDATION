<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DÃ©tails de l'employÃ© - {{ $staff->name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboards.css') }}">
    
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
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
                <span>
                    <i class="fas fa-user"></i>
                    {{ $staff->name }}
                </span>
            </div>

            <div class="employee-details">
                <div class="employee-header">
                    <div class="employee-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="employee-title">
                        <h1>{{ $staff->name }}</h1>
                        <div class="employee-subtitle">{{ $staff->matricule }}</div>
                    </div>
                </div>

                <div class="info-section">
                    <h2 class="info-section-title">
                        <i class="fas fa-info-circle"></i>
                        Informations gÃ©nÃ©rales
                    </h2>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Email</div>
                            <div class="info-value">{{ $staff->email }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Service</div>
                            <div class="info-value">{{ $staff->service->name }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">DÃ©partement</div>
                            <div class="info-value">{{ $staff->department->name }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Statut</div>
                            <div class="info-value">
                                <span class="status-badge {{ $staff->is_active ? 'status-active' : 'status-inactive' }}">
                                    <i class="fas fa-{{ $staff->is_active ? 'check' : 'times' }}-circle"></i>
                                    {{ $staff->is_active ? 'Actif' : 'Inactif' }}
                                </span>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Date d'inscription</div>
                            <div class="info-value">{{ $staff->registered_at ? \Carbon\Carbon::parse($staff->registered_at)->format('d/m/Y H:i') : 'Non dÃ©fini' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">DerniÃ¨re activitÃ©</div>
                            <div class="info-value">
                                {{ $staff->last_activity_at ? \Carbon\Carbon::parse($staff->last_activity_at)->diffForHumans() : 'Jamais' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="action-buttons">
                    <a href="{{ route('departments.staff.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Retour Ã  la liste
                    </a>
                    <a href="{{ route('staff.edit', $staff) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i>
                        Modifier
                    </a>
                    <form action="{{ route('staff.destroy', $staff) }}" method="POST" class="inline" onsubmit="return confirm('ÃŠtes-vous sÃ»r de vouloir supprimer cet employÃ© ? Cette action est irrÃ©versible.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i>
                            Supprimer
                        </button>
                    </form>
                </div>

                
            </div>
        </main>
    </div>
</body>
</html>
