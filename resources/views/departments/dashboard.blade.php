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
                            <b>Super Administrateur</b>
                        @elseif(Auth::user()->isAdmin1())
                            <b>Administrateur</b>
                        @elseif(Auth::user()->isAdmin2())
                            <b>Chef de DÃ©partement</b>
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
                                ParamÃ¨tres
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
                                <i class="fas fa-chart-bar"></i>
                                Historique des<br>telechargements
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
                                DÃ©connexion
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
                    <div class="breadcrumb">Tableau de bord/Accueil</div>
                </div>
                @if( Auth::user()->department && (Auth::user()->isAdmin2() && Auth::user()->department->head_id === Auth::user()->id))
                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-card-title">EmployÃ©s du DÃ©partement</div>
                        <div class="stat-card-value">{{ $departmentUsers ?? '0' }}</div>
                        <div class="stat-card-info">
                            Dans votre dÃ©partement
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
                                {{ $activeServicesCount }} actifs
                            </span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-title">DÃ©partement</div>
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
                    <h2 style="color: #2d3748; margin-bottom: 0.5rem;">AccÃ¨s Restreint</h2>
                    <p style="color: #718096;">Vous n'Ãªtes pas actuellement chef de ce dÃ©partement. Seul votre profil est accessible.</p>
                </div>
                @endif
                <!-- Quick Actions -->
                <div class="actions-grid">
                    @if(Auth::user()->department && (Auth::user()->isAdmin2() || Auth::user()->isSuperAdmin() || Auth::user()->isAdmin1()))
                        <a href="{{route('departments.staff.create')}}" class="action-card">
                            <i class="fas fa-user-plus action-icon"></i>
                            <h3>Ajouter un employÃ©</h3>
                            <p class="action-desc">Ajouter un nouvel employÃ© au dÃ©partement</p>
                        </a>
                    
                        @if(Auth::user()->department)
                            <a href="{{route('departments.services.create', ['department' => Auth::user()->department->id])}}" class="action-card">
                                <i class="fas fa-folder-plus action-icon"></i>
                                <h3>Nouveau Service</h3>
                                <p class="action-desc">CrÃ©er un nouveau service dans le dÃ©partement</p>
                            </a>
                        @endif
                    @endif
                    
                    @if(Auth::user()->department)
                        <a href="{{ route('departments.services.index', ['department' => Auth::user()->department->id]) }}" class="action-card">
                            <i class="fas fa-sitemap action-icon"></i>
                            <h3>GÃ©rer les Services</h3>
                            <p class="action-desc">Voir et gÃ©rer tous les services du dÃ©partement</p>
                        </a>
                    @endif

                    <a href="#" class="action-card" onclick="showSection('reports')">
                        <i class="fas fa-chart-line action-icon"></i>
                        <h3>Rapports des Services</h3>
                        <p class="action-desc">Statistiques et rapports dÃ©taillÃ©s</p>
                    </a>
                </div>
                
                <!-- Services Overview -->
                <div class="services-overview">
                    <div class="section-header">
                        <h2 class="section-title">AperÃ§u des Services</h2>
                        @if(Auth::user()->department)
                            <a href="{{ route('departments.services.index', ['department' => Auth::user()->department->id]) }}" class="btn btn-primary">
                                <i class="fas fa-external-link-alt"></i> Voir tous les services
                            </a>
                        @endif
                    </div>
                    
                    <div class="services-grid">
                        @if(Auth::user()->department)
                            @forelse(Auth::user()->department->services()->latest()->take(4)->get() as $service)
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
                                        <span><i class="fas fa-users"></i> {{ $service->users_count ?? 0 }} employÃ©s</span>
                                        @if(Auth::user()->department)
                                            <a href="{{ route('departments.services.show', ['department' => Auth::user()->department->id, 'service' => $service->id]) }}" 
                                               class="btn btn-sm btn-outline">
                                                DÃ©tails
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="no-services">
                                    <i class="fas fa-info-circle"></i>
                                    <p>Aucun service n'a encore Ã©tÃ© crÃ©Ã© dans ce dÃ©partement.</p>
                                    @if(Auth::user()->isAdmin2())
                                        <a href="{{ route('departments.services.create', ['department' => Auth::user()->department->id]) }}" 
                                           class="btn btn-primary">
                                            <i class="fas fa-plus"></i> CrÃ©er un service
                                        </a>
                                    @endif
                                </div>
                            @endforelse
                        @else
                            <div class="no-services">
                                <i class="fas fa-exclamation-triangle"></i>
                                <p>Vous n'Ãªtes pas encore assignÃ© Ã  un dÃ©partement.</p>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- Recent Activity -->
                <div class="activity-section">
                    <div class="section-header">
                        <h2 class="section-title">ActivitÃ©s rÃ©centes</h2>
                        <a href="#" class="btn">Voir tout</a>
                    </div>
                    <table class="activity-table">
                        <thead>
                            <tr>
                                <th>Utilisateur</th>
                                <th>Inscription</th>
                                <th>DerniÃ¨re MAJ</th>
                                <th>DerniÃ¨re Connexion</th>
                                <th>DerniÃ¨re ActivitÃ©</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentActivities ?? [] as $activity)
                                <tr>
                                    <td>{{ $activity->user->name ?? 'Non Renseigne'}}</td>
                                    <td>{{ $activity->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $activity->info_updated_at ? $activity->info_updated_at->format('d/m/Y') : 'N/A' }}</td>
                                    <td>{{ $activity->last_login_at ? $activity->last_login_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                    <td>{{ $activity->last_activity_at ? $activity->last_activity_at->diffForHumans() : 'N/A' }}</td>
                                    <td>
                                        <div class="status-dot {{ $activity->last_activity_at && $activity->last_activity_at->gt(now()->subMinutes(5)) ? 'bg-success' : 'bg-gray' }}"></div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Aucune activitÃ© rÃ©cente</td>
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
                        <h1 class="page-title">ParamÃ¨tres</h1>
                        <div class="breadcrumb">Tableau de bord / ParamÃ¨tres</div>
                    </div>
                    @include('departments.partials.settings')
                </section>

                <!-- Reports Section -->
                <section id="section-reports" style="display:none">
                    <div class="page-header">
                        <h1 class="page-title">Rapports</h1>
                        <div class="breadcrumb">Tableau de bord / Rapports</div>
                    </div>
                    <div>
                        @include('departments.partials.pdf-download')
                    </div>
                </section>

                <!-- Downloads Section -->
                <section id="section-historydownloads" style="display:none">
                    <div class="page-header">
                        <h1 class="page-title">Historiques des telechargements</h1>
                        <div class="breadcrumb">Tableau de bord / Historique des telechargements</div>
                    </div>
                    <div>
                        <p>Contenu de l'historique ici</p>
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

