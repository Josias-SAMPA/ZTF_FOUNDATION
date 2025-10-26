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
    @if(Auth::user()->isAdmin1())
        @include('partials.welcome-message')
    @endif
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">ZTF FOUNDATION</div>
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->matricule ?? ' Admin Grade 1'}}</div>
                    <div class="user-role">
                        @if(Auth::user()->isSuperAdmin())
                            Super Administrateur
                        @elseif(Auth::user()->isAdmin1())
                            Administrateur
                        @elseif(Auth::user()->isAdmin2())
                            Chef de DÃ©partement
                        @else
                            Utilisateur
                        @endif
                    </div>
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
                            <i class="fas fa-building"></i>
                            DÃ©partements
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="showSection('services')">
                            <i class="fas fa-sitemap"></i>
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
                        <a href="#" class="nav-link" onclick="showSection('profile')">
                            <i class="fas fa-user-circle"></i>
                            Mon Profil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="showSection('pdf-history')">
                            <i class="fas fa-file-pdf"></i>
                            Historique PDF
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('home')}}" class="nav-link">
                            <i class="fas fa-home"></i>
                            Voir le site
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('committee.dashboard')}}" class="nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            Tableau de bord
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
                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-card-title">Total Utilisateurs</div>
                        <div class="stat-card-value">{{ $totalUsers ?? '0' }}</div>
                        <div class="stat-card-change positive">
                            
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-title">DÃ©partements Actifs</div>
                        <div class="stat-card-value">{{ $totalDepts ?? '0' }}</div>
                        <div class="stat-card-change">
                            <i class="fas fa-check"></i> Tous opÃ©rationnels
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-title">Services Actifs</div>
                        <div class="stat-card-value">{{ $totalServices ?? '0' }}</div>
                        <div class="stat-card-change">
                            
                        </div>
                    </div>
                </div>
                <!-- Quick Actions -->
                <div class="actions-grid">
                    <a href="{{route('staff.create')}}" class="action-card">
                        <i class="fas fa-user-plus action-icon"></i>
                        <h3>Ajouter un utilisateur</h3>
                    </a>
                    <a href="{{ route('committee.services.list') }}" class="action-card">
                        <i class="fas fa-folder-plus action-icon"></i>
                        <h3>Liste des Services par Departements</h3>
                    </a>
                    <a href="{{route('services.create')}}" class="action-card">
                        <i class="fas fa-folder-plus action-icon"></i>
                        <h3>Nouveau Service</h3>
                    </a>
                    <a href="#" class="action-card">
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
                                <td>{{ $activity['created_at'] }}</td>
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
                    @include('committee.quickAction')
                </div>
            </section>
            <!-- Departments Section -->
            <section id="section-departments" style="display:none">
                <div class="page-header">
                    <h1 class="page-title">DÃ©partements</h1>
                    <div class="breadcrumb">Tableau de bord / DÃ©partements</div>
                </div>
                <div>
                    @include('committee.departments.manage')
                </div>
            </section>
            <!-- Services section -->
            <section id="section-services" style="display:none">
                <div class="page-header">
                    <h1 class="page-title">Services</h1>
                    <div class="breadcrumb">Tableau de bord / Services</div>
                </div>
                <div>
                    @include('committee.services.quickAction')
                </div>
            </section>
            <!-- Settings Section -->
            <section id="section-settings" style="display:none">
                <div class="page-header">
                    <h1 class="page-title">ParamÃ¨tres</h1>
                    <div class="breadcrumb">Tableau de bord / ParamÃ¨tres</div>
                </div>
                <div>
                    @include('committee.partials.settings-content')
                </div>
            </section>
            <!-- Reports Section -->
            <section id="section-reports" style="display:none">
                <div class="page-header">
                    <h1 class="page-title">Rapports</h1>
                    <div class="breadcrumb">Tableau de bord / Rapports</div>
                </div>
                <div class="reports-container">
                    <h2 class="section-subtitle">Rapports Administratifs</h2>
                    <div class="reports-grid">
                        <div class="report-card">
                            <div class="report-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h3>Liste des DÃ©partements et Chefs</h3>
                            <p>TÃ©lÃ©charger la liste complÃ¨te des dÃ©partements avec leurs chefs respectifs.</p>
                            <a href="{{ route('committee.pdf.departments-heads') }}" class="btn btn-primary" target="_blank">
                                <i class="fas fa-download"></i> TÃ©lÃ©charger
                            </a>
                        </div>

                        <div class="report-card">
                            <div class="report-icon">
                                <i class="fas fa-sitemap"></i>
                            </div>
                            <h3>DÃ©partements, Chefs et Services</h3>
                            <p>TÃ©lÃ©charger la liste des dÃ©partements avec leurs chefs et services associÃ©s.</p>
                            <a href="{{ route('committee.pdf.departments-heads-services') }}" class="btn btn-primary" target="_blank">
                                <i class="fas fa-download"></i> TÃ©lÃ©charger
                            </a>
                        </div>

                        <div class="report-card">
                            <div class="report-icon">
                                <i class="fas fa-user-friends"></i>
                            </div>
                            <h3>Liste ComplÃ¨te des EmployÃ©s</h3>
                            <p>TÃ©lÃ©charger la liste dÃ©taillÃ©e de tous les employÃ©s par dÃ©partement.</p>
                            <a href="{{ route('committee.pdf.departments-employees') }}" class="btn btn-primary" target="_blank">
                                <i class="fas fa-download"></i> TÃ©lÃ©charger
                            </a>
                        </div>
                    </div>

                    <h2 class="section-subtitle">Historique des Rapports DÃ©partementaux</h2>
                    <div class="reports-history">
                        @foreach($departmentPdfs ?? [] as $pdf)
                            <div class="report-history-card">
                                <div class="report-info">
                                    <div class="report-icon">
                                        <i class="fas fa-file-pdf"></i>
                                    </div>
                                    <div class="report-details">
                                        <h4>{{ basename($pdf) }}</h4>
                                        <p>GÃ©nÃ©rÃ© le {{ \Carbon\Carbon::createFromTimestamp(Storage::lastModified('public/' . $pdf))->format('d/m/Y Ã  H:i') }}</p>
                                    </div>
                                </div>
                                <div class="report-actions">
                                    <a href="{{ Storage::url($pdf) }}" class="btn btn-secondary" target="_blank">
                                        <i class="fas fa-download"></i> TÃ©lÃ©charger
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
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

            <!-- PDF History Section -->
            <section id="section-pdf-history" style="display:none">
                <div class="page-header">
                    <h1 class="page-title">
                        <i class="fas fa-file-pdf"></i>
                        Historique des PDFs par dÃ©partement
                    </h1>
                    <div class="breadcrumb">Tableau de bord / Historique PDF</div>
                </div>

                <div class="pdf-history-container">
                    @foreach($departments as $department)
                        <div class="pdf-department-card">
                            <div class="pdf-department-header">
                                <h2>
                                    <i class="fas fa-building"></i>
                                    {{ $department->name }}
                                </h2>
                                <div class="department-info">
                                    <span><i class="fas fa-users"></i> {{ $department->users_count }} utilisateurs</span>
                                    <span><i class="fas fa-sitemap"></i> {{ $department->services_count }} services</span>
                                </div>
                            </div>

                            <div class="pdf-list">
                                @php
                                    $departmentPath = 'pdfs/departments/' . $department->id;
                                    $pdfs = Storage::disk('public')->exists($departmentPath)
                                        ? collect(Storage::disk('public')->files($departmentPath))
                                            ->filter(function($file) {
                                                return pathinfo($file, PATHINFO_EXTENSION) === 'pdf';
                                            })
                                            ->sortByDesc(function($file) {
                                                return Storage::disk('public')->lastModified($file);
                                            })
                                        : collect([]);
                                @endphp

                                @if($pdfs->count() > 0)
                                    <div class="pdf-grid">
                                        @foreach($pdfs as $pdf)
                                            <div class="pdf-item">
                                                <div class="pdf-icon">
                                                    <i class="fas fa-file-pdf"></i>
                                                </div>
                                                <div class="pdf-details">
                                                    <h4>{{ basename($pdf) }}</h4>
                                                    <p>
                                                        <i class="fas fa-calendar"></i>
                                                        {{ \Carbon\Carbon::createFromTimestamp(
                                                            Storage::disk('public')->lastModified($pdf)
                                                        )->format('d/m/Y H:i') }}
                                                    </p>
                                                </div>
                                                <div class="pdf-actions">
                                                    <a href="{{ Storage::disk('public')->url($pdf) }}" 
                                                       target="_blank"
                                                       class="pdf-btn pdf-view">
                                                        <i class="fas fa-eye"></i>
                                                        <span>Voir</span>
                                                    </a>
                                                    <a href="{{ Storage::disk('public')->url($pdf) }}" 
                                                       download
                                                       class="pdf-btn pdf-download">
                                                        <i class="fas fa-download"></i>
                                                        <span>TÃ©lÃ©charger</span>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="no-pdf">
                                        <i class="fas fa-folder-open"></i>
                                        <p>Aucun PDF disponible pour ce dÃ©partement</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                
            </section>
        </main>
        
    </div>
    
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>

