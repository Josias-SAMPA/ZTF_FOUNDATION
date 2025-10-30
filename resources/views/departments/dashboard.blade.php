<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> {{config('app.name')}} </title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboards.css') }}">
    
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/services-overview.css') }}">
</head>
<body>
    @if(Auth::user()->isAdmin2())
        @include('partials.welcome-message')
    @endif
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">ZTF FOUNDATION</div>
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-role">
                        @if(Auth::user()->isSuperAdmin())
                            <b>Super-administrateur</b>
                        @elseif(Auth::user()->isAdmin1())
                            <b>Administrateur</b>
                        @elseif(Auth::user()->isAdmin2())
                            <b>Chef de département</b>
                        @else
                            <b>Utilisateur</b>
                        @endif
                    </div>
                    <div class="user-matricule">{{ Auth::user()->matricule }}</div>
                </div>
            </div>
            <nav>
                <ul class="nav-menu">
                    @if(Auth::user()->department && (Auth::user()->isAdmin2() || Auth::user()->department->head_id === Auth::user()->id))
                        <li class="nav-item">
                            <a href="#" class="nav-link" onclick="showSection('dashboard')">
                                <i class="fas fa-home"></i>
                                Tableau de bord
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" onclick="showSection('users')">
                                <i class="fas fa-users"></i>
                                Gestion des utilisateurs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" onclick="showSection('services')">
                                <i class="fas fa-building"></i>
                                Services
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" onclick="showSection('settings')">
                                <i class="fas fa-cog"></i>
                                Paramètres
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" onclick="showSection('reports')">
                                <i class="fas fa-chart-bar"></i>
                                Rapports
                            </a>
                        </li>

                         <li class="nav-item">
                            <a href="#" class="nav-link" onclick="showSection('historydownloads')">
                                <i class="fas fa-history"></i>
                                Historique des<br>téléchargements
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="showSection('profile')">
                            <i class="fas fa-user-circle"></i>
                            Mon Profil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('home')}}" class="nav-link">
                            <i class="fas fa-home"></i>
                            Voir le site
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="nav-link" style="cursor: pointer;">
                            @csrf
                            <i class="fas fa-sign-out-alt"></i>
                            <button type="submit" style="background: none; border: none; color: inherit; padding: 0; cursor: pointer;">
                                Déconnexion
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>
        <!-- Main Content -->
        <main class="main-content">
            <!-- Dashboard Section -->
            <section id="section-dashboard">
                <div class="page-header">
                    <h1 class="page-title">Tableau de bord</h1>
                    <div class="breadcrumb">Tableau de bord / Accueil</div>
                </div>
                @if( Auth::user()->department && (Auth::user()->isAdmin2() && Auth::user()->department->head_id === Auth::user()->id))
                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-card-title">Effectif du département</div>
                        <div class="stat-card-value">{{ $departmentUsers ?? '0' }}</div>
                        <div class="stat-card-info">
                            Employés actifs
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-title">Services</div>
                        <div class="stat-card-value">
                            @php
                                $servicesCount = 0;
                                $activeServicesCount = 0;
                                if (Auth::user()->department) {
                                    $servicesCount = Auth::user()->department->services()->count();
                                    $activeServicesCount = Auth::user()->department->services()->where('is_active', true)->count();
                                }
                            @endphp
                            {{ $servicesCount }}
                        </div>
                        <div class="stat-card-info">
                            <span class="active-services">
                                {{ $activeServicesCount }} en activité
                            </span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-title">Département</div>
                        <div class="stat-card-value">
                            {{ Auth::user()->department ? Auth::user()->department->name : 'N/A' }}
                        </div>
                        <div class="stat-card-info">
                            Code: {{ Auth::user()->department ? Auth::user()->department->code : 'N/A' }}
                        </div>
                    </div>
                </div>
                @else
                <div class="no-access-message" style="text-align: center; padding: 2rem; background: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <i class="fas fa-lock" style="font-size: 3rem; color: #718096; margin-bottom: 1rem;"></i>
                    <h2 style="color: #2d3748; margin-bottom: 0.5rem;">Accès restreint</h2>
                    <p style="color: #718096;">Vous n'êtes pas actuellement chef de ce département. Seul votre profil est accessible.</p>
                </div>
                @endif
                <!-- Quick Actions -->
                <div class="actions-grid">
                    @if(Auth::user()->department && (Auth::user()->isAdmin2() || Auth::user()->isSuperAdmin() || Auth::user()->isAdmin1()) && Auth::user()->department->head_id === Auth::user()->id)
                        <a href="{{route('departments.staff.create')}}" class="action-card">
                            <i class="fas fa-user-plus action-icon"></i>
                            <h3>Ajouter un employé</h3>
                            <p class="action-desc">Intégrer un nouvel employé au département</p>
                        </a>
                    
                        @if(Auth::user()->department)
                            <a href="{{route('departments.services.create', ['department' => Auth::user()->department->id])}}" class="action-card">
                                <i class="fas fa-folder-plus action-icon"></i>
                                <h3>Nouveau service</h3>
                                <p class="action-desc">Créer un nouveau service dans le département</p>
                            </a>
                        @endif
                    @endif
                    
                    @if(Auth::user()->department)
                        <a href="{{ route('departments.services.index', ['department' => Auth::user()->department->id]) }}" class="action-card">
                            <i class="fas fa-sitemap action-icon"></i>
                            <h3>Gérer les services</h3>
                            <p class="action-desc">Administrer les services du département</p>
                        </a>
                    @endif

                    <a href="#" class="action-card" onclick="showSection('reports')">
                        <i class="fas fa-chart-line action-icon"></i>
                        <h3>Rapports d'activité</h3>
                        <p class="action-desc">Statistiques et analyses détaillées</p>
                    </a>
                </div>
                
                <!-- Services Overview -->
                <div class="services-overview">
                    <div class="section-header">
                        <h2 class="section-title">Aperçu des Services</h2>
                        @if(Auth::user()->department)
                            <a href="{{ route('departments.services.index', ['department' => Auth::user()->department->id]) }}" class="btn btn-primary">
                                <i class="fas fa-external-link-alt"></i> Voir tous les services
                            </a>
                        @endif
                    </div>
                    
                    <div class="services-grid">
                        @if(Auth::user()->department)
                            @forelse(Auth::user()->department->services()->withCount('users')->latest()->take(4)->get() as $service)
                                <div class="service-card">
                                    <div class="service-header">
                                        <h3>{{ $service->name }}</h3>
                                        <span class="service-status {{ $service->is_active ? 'active' : 'inactive' }}">
                                            {{ $service->is_active ? 'Actif' : 'Inactif' }}
                                        </span>
                                    </div>
                                    <p class="service-description">
                                        {{ Str::limit($service->description, 100) ?? 'Aucune description' }}
                                    </p>
                                    <div class="service-stats">
                                        <span><i class="fas fa-users"></i> {{ $service->users_count }} ouvriers</span>
                                        @if(Auth::user()->department)
                                            <a href="{{ route('departments.services.show', ['department' => Auth::user()->department->id, 'service' => $service->id]) }}" 
                                               class="btn btn-sm btn-outline">
                                                Détails
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="no-services">
                                    <i class="fas fa-info-circle"></i>
                                    <p>Aucun service n'a encore été créé dans ce département.</p>
                                    @if(Auth::user()->isAdmin2())
                                        <a href="{{ route('departments.services.create', ['department' => Auth::user()->department->id]) }}" 
                                           class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Créer un service
                                        </a>
                                    @endif
                                </div>
                            @endforelse
                        @else
                            <div class="no-services">
                                <i class="fas fa-exclamation-triangle"></i>
                                <p>Vous n'êtes pas encore assigné à un département.</p>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- Recent Activity -->
                <div class="activity-section">
                    <div class="section-header">
                        <h2 class="section-title">Activités récentes</h2>
                        <a href="#" class="btn">Voir tout l'historique</a>
                    </div>
                    <table class="activity-table">
                        <thead>
                            <tr>
                                <th>Utilisateur</th>
                                <th>Inscription</th>
                                <th>Dernière mise à jour</th>
                                <th>Dernière connexion</th>
                                <th>Dernière activité</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentActivities ?? [] as $activity)
                                <tr>
                                    <td>{{ $activity->name ?? $activity->matricule }}</td>
                                    <td>{{ $activity->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $activity->info_updated_at ? $activity->info_updated_at->format('d/m/Y') : 'N/A' }}</td>
                                    <td>{{ $activity->last_login_at ? $activity->last_login_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                    <td>{{ $activity->last_activity_at ? $activity->last_activity_at->diffForHumans() : 'N/A' }}</td>
                                    <td>
                                        <div class="status-indicator">
                                            <div class="status-dot {{ $activity->is_online ? 'bg-success' : 'bg-gray' }}"></div>
                                            <span class="status-text">
                                                {{ $activity->is_online ? 'En ligne' : 'Hors ligne' }}
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Aucune activité récente</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    
                </div>
            </section>
            @if(Auth::user()->department && (Auth::user()->isAdmin2() || Auth::user()->department->head_id === Auth::user()->id))
                <!-- Users Section -->
                <section id="section-users" style="display:none">
                    <div class="page-header">
                        <h1 class="page-title">Gestion des utilisateurs</h1>
                        <div class="breadcrumb">Tableau de bord / Gestion des utilisateurs</div>
                    </div>
                    <div>
                        @include('departments.staff.quickAction')
                    </div>
                </section>

                <!-- Services section -->
                <section id="section-services" style="display:none">
                    <div class="page-header">
                        <h1 class="page-title">Services</h1>
                        <div class="breadcrumb">Tableau de bord / Services</div>
                    </div>
                    <div>
                        @include('departments.services.quickAction')
                    </div>
                </section>

                <!-- Settings Section -->
                <section id="section-settings" style="display:none">
                    <div class="page-header">
                        <h1 class="page-title">Paramètres</h1>
                        <div class="breadcrumb">Tableau de bord / Paramètres</div>
                    </div>
                    @include('departments.partials.settings')
                </section>

                <!-- Reports Section -->
                <section id="section-reports" style="display:none">
                    <div class="page-header">
                        <h1 class="page-title">Rapports d'activité</h1>
                        <div class="breadcrumb">Tableau de bord / Rapports</div>
                    </div>
                    <div>
                        @include('departments.partials.pdf-download')
                    </div>
                </section>

                <!-- Downloads Section -->
                <section id="section-historydownloads" style="display:none">
                    <div class="page-header">
                        <h1 class="page-title">Historique des téléchargements</h1>
                        <div class="breadcrumb">Tableau de bord / Historique des téléchargements</div>
                    </div>
                    <div>
                        <p>Historique des documents téléchargés</p>
                    </div>
                </section>
            @endif

            <!-- Profile Section - Always visible -->
            <section id="section-profile" style="display:none">
                <div class="page-header">
                    <h1 class="page-title">Mon Profil</h1>
                    <div class="breadcrumb">Tableau de bord / Mon Profil</div>
                </div>
                <div>
                    @include('users.partials.profile-content')
                </div>
            </section>
        </main>
        
    </div>
    
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>

