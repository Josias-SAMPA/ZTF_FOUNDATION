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
    

    <div id="welcomeMessage" class="welcome-message">
        <i class="fas fa-crown"></i>
        <span>Bienvenue Super Administrateur</span>
    </div>

    

    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">ZTF FOUNDATION</div>
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->name ?? ' Super Admin' }}</div>
                    <div class="user-role">Super Administrateur</div>
                </div>
            </div>
            <nav>
                <ul class="nav-menu">
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
                        <a href="#" class="nav-link" onclick="showSection('departments')">
                           <i class="fas fa-building-columns"></i>

                            DÃ©partements
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="showSection('committee')">
                           <i class="fa fa-people-arrows"></i> 
                            ComitÃ© de Nehemie
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="showSection('services')">
                            <i class="fas fa-sitemap"></i>
                            Services
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="showSection('rolespermission')">
                            <i class="fas fa-user-shield"></i>
                            Roles & Permissions
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
                    <div class="breadcrumb">Tableau de bord / Accueil</div>
                </div>
                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-card-title">Total Utilisateurs</div>
                        <div class="stat-card-value">{{ $totalUsers ?? '0' }}</div>
                        <div class="stat-card-change {{ $userGrowth > 0 ? 'positive' : ($userGrowth < 0 ? 'negative' : '') }}">
                           
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-title">DÃ©partements Actifs</div>
                        <div class="stat-card-value">{{ $totalDepts ?? '0' }}</div>
                        <div class="stat-card-change">
                            @php
                                $activeDepts = $departmentsWithStats->where('status', 'Actif')->count();
                                $deptPercentage = $totalDepts > 0 ? round(($activeDepts / $totalDepts) * 100) : 0;
                            @endphp
                            <i class="fas fa-{{ $deptPercentage == 100 ? 'check' : 'info-circle' }}"></i>
                            {{ $deptPercentage }}% opÃ©rationnels
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-title">ComitÃ©s</div>
                        <div class="stat-card-value">{{ $totalCom ?? '0' }}</div>
                        <div class="stat-card-change">
                            <i class="fas fa-users"></i>
                            {{ $totalCom }} comitÃ©{{ $totalCom > 1 ? 's' : '' }} actif{{ $totalCom > 1 ? 's' : '' }}
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-title">Services Actifs</div>
                        <div class="stat-card-value">{{ $totalServices ?? '0' }}</div>
                        <div class="stat-card-change">
                            <i class="fas fa-cogs"></i>
                            Services en fonction
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-title">RÃ´les</div>
                        <div class="stat-card-value">{{ $nbreRole ?? '0' }}</div>
                        <div class="stat-card-change">
                            <i class="fas fa-user-shield"></i>
                            RÃ´les configurÃ©s
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-title">Permissions</div>
                        <div class="stat-card-value">{{ $nbrePermission ?? '0' }}</div>
                        <div class="stat-card-change">
                            <i class="fas fa-key"></i>
                            Permissions actives
                        </div>
                    </div>
                </div>
                <!-- Quick Actions -->
                <div class="actions-grid">
                    <a href="{{route('staff.create')}}" class="action-card">
                        <i class="fas fa-user-plus action-icon"></i>
                        <h3>Ajouter un utilisateur</h3>
                    </a>
                    <a href="{{route('departments.create')}}" class="action-card">
                        <i class="fas fa-folder-plus action-icon"></i>
                        <h3>Nouveau dÃ©partement</h3>
                    </a>
                    <a href="{{route('departments.assign.head.form')}}" class="action-card">
                        <i class="fas fa-user-tie action-icon"></i>
                        <h3>Assigner un Chef de DÃ©partement</h3>
                    </a>
                    <a href="{{route('departments.statistics')}}" class="action-card">
                        <i class="fas fa-chart-line action-icon"></i>
                        <h3>Statistiques</h3>
                    </a>
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
                            @forelse($recentActivities as $activity)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <span class="status-dot {{ $activity['is_online'] ? 'bg-success' : 'bg-gray' }}"></span>
                                        {{ $activity['user_name'] }}
                                    </div>
                                </td>
                                <td>{{ $activity['registered_date'] }}</td>
                                <td>{{ $activity['last_update'] }}</td>
                                <td>{{ $activity['last_login'] }}</td>
                                <td>{{ $activity['last_seen'] }}</td>
                                <td>
                                    <span class="status-badge status-{{ $activity['status_class'] }}">
                                        {{ $activity['status'] }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    <i class="fas fa-info-circle"></i> Aucun utilisateur trouvÃ©
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    
                </div>
            </section>
            <!-- Users Section -->
            <section id="section-users" style="display:none">
                <div class="page-header">
                    <h1 class="page-title">Gestion des utilisateurs</h1>
                    <div class="breadcrumb">Tableau de bord / Gestion des utilisateurs</div>
                </div>
                <div>
                    @include('staff.quickAction')
                </div>
            </section>
            <!-- Departments Section -->
            <section id="section-departments" style="display:none">
                <div class="page-header">
                    <h1 class="page-title">DÃ©partements</h1>
                    <div class="breadcrumb">Tableau de bord / DÃ©partements</div>
                </div>
                <div>
                    @include('departments.quickAction')
                </div>
            </section>
            <!-- Committee Section -->
            <section id="section-committee">
                <div class="page-header">
                    <h1 class="page-title">ComitÃ© de Nehemie</h1>
                    <div class="breadcrumb">Tableau de bord / ComitÃ© de Nehemie</div>
                </div>
                <div>
                    @include('committee.quickAction')
                </div>
            </section>
            <!-- Services section -->
            <section id="section-services" style="display:none">
                <div class="page-header">
                    <h1 class="page-title">Services</h1>
                    <div class="breadcrumb">Tableau de bord / Services</div>
                </div>
                <div>
                    @include('services.quickAction')
                </div>
            </section>
            <!-- Roles and Permission Section -->
            <section id="section-rolespermission" style="display:none">
                <div class="page-header">
                    <h1 class="page-title">Roles & Permissions</h1>
                    <div class="breadcrumb">Tableau de bord / Roles & Permissions</div>
                </div>
                <div>
                    @include('roles.quickAction')
                    @include('permissions.quickAction')
                </div>
            </section>
            <!-- Settings Section -->
            <section id="section-settings" style="display:none">
                <div class="page-header">
                    <h1 class="page-title">ParamÃ¨tres</h1>
                    <div class="breadcrumb">Tableau de bord / ParamÃ¨tres</div>
                </div>
                <div>
                    @include('superAdmin.partials.settings-content')
                </div>
            </section>
            <!-- Reports Section -->
            <section id="section-reports" style="display:none">
                <div class="page-header">
                    <h1 class="page-title">Rapports</h1>
                    <div class="breadcrumb">Tableau de bord / Rapports</div>
                </div>
                <div>
                    <p>Contenu des rapports ici...</p>
                </div>
            </section>
            <!-- Profile Section -->
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

