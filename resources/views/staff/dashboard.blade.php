<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>{{ config('app.name') }} - Tableau de bord Ouvriers</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/staff-dashboard.css?v=' . filemtime(public_path('css/staff-dashboard.css'))) }}">
</head>
<body>
  @include('partials.welcome-message')
  
  <!-- Mobile Overlay -->
  <div class="sidebar-overlay" onclick="toggleMobileSidebar()"></div>
  
  <div class="dashboard-wrapper">
    <!-- SIDEBAR -->
    <aside class="sidebar">
      <div class="sidebar-header">
        <div class="logo">
          <i class="fas fa-user-tie"></i>
          <span>STAFF</span>
        </div>
        <button class="sidebar-toggle" onclick="toggleSidebar()">
          <i class="fas fa-bars"></i>
        </button>
      </div>

      <nav class="sidebar-nav">
        <ul>
          <li>
            <a href="{{ route('staff.dashboard') }}" class="nav-link active">
              <i class="fas fa-home"></i>
              <span>Tableau de bord</span>
            </a>
          </li>
          <li>
            <a href="{{ route('profile.edit') }}" class="nav-link">
              <i class="fas fa-user"></i>
              <span>Mon Profil</span>
            </a>
          </li>
          <li>
            <a href="{{ route('home') }}" class="nav-link">
              <i class="fas fa-globe"></i>
              <span>Site Web</span>
            </a>
          </li>
          <li class="divider"></li>
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="nav-link logout">
                <i class="fas fa-sign-out-alt"></i>
                <span>Déconnexion</span>
              </button>
            </form>
          </li>
        </ul>
      </nav>

      <div class="sidebar-footer">
        <div class="user-card">
          <div class="user-avatar">
            <i class="fas fa-user"></i>
          </div>
          <div class="user-info">
            <p class="user-name">{{ $user->name ?? $user->email }}</p>
            <p class="user-role">Staff</p>
          </div>
        </div>
      </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">
      <!-- HEADER -->
      <div class="page-header">
        <div class="header-left">
          <button class="mobile-menu-toggle" onclick="toggleMobileSidebar()">
            <i class="fas fa-bars"></i>
          </button>
          <h1>Tableau de Bord</h1>
          <p class="breadcrumb">
            <a href="{{ route('staff.dashboard') }}">Accueil</a> / Espace Personnel
          </p>
        </div>
        <div class="header-right">
          <span class="status-badge">
            <span class="status-dot"></span>
            En ligne
          </span>
        </div>
      </div>

      <!-- CONTAINER -->
      <div class="container">
        <!-- PROFILE CARD -->
        <div class="profile-section">
          <div class="profile-card">
            <div class="avatar"><i class="fas fa-user"></i></div>
            <div class="profile-info">
              <h2>{{ $user->matricule }}</h2>
              <div class="profile-meta">
                <div><i class="fas fa-envelope"></i>{{ $user->email }}</div>
                <div><i class="fas fa-building"> </i>Departement : {{ $user->department->name ?? 'Non assigné' }}</div>
                <div><i class="fas fa-briefcase">  </i>Service : 
                  @if($user->services->isNotEmpty())
                    {{ $user->services->first()->name }}
                  @else
                    Non assigné
                  @endif
                </div>
                <div><i class="fas fa-user-tie"></i>Rôle : {{ $user->roles->isNotEmpty() ? $user->roles->first()->display_name : 'Non défini' }}</div>
              </div>
            </div>
            <a href="{{ route('profile.edit') }}" class="btn btn-primary">
              <i class="fas fa-user-edit"></i> Modifier mon profil
            </a>
          </div>
        </div>

        <!-- GRID -->
        <div class="grid">
          <!-- DEPARTEMENT -->
          <div class="card">
            <div class="card-header">
              <h3><i class="fas fa-building"></i> Mon Département</h3>
              @if($user->department)
                <span class="badge badge-success">Actif</span>
              @else
                <span class="badge badge-danger">Inactif</span>
              @endif
            </div>
            @if($user->department)
              <div class="card-content">
                <p><strong>Nom :</strong> {{ $user->department->name }}</p>
                <p><strong>Chef de Departement :</strong> {{ $user->department->head->name ?? 'Non renseigné' }}</p>
                <p><strong>Description :</strong> {{ Str::limit($user->department->description,150) }}</p>
              </div>
            @else
              <p class="text-gray-500" style="padding: 1.5rem;">Vous n'êtes pas encore assigné à un département.</p>
            @endif
          </div>



          <!-- SERVICES -->
          <div class="card">
            <div class="card-header">
              <h3><i class="fas fa-briefcase"></i> Mes Services</h3>
              @if($user->services->isNotEmpty())
                <span class="badge badge-success">{{ $user->services->count() }}</span>
              @endif
            </div>
            @if($user->services->isNotEmpty())
              <div class="card-content">
                @foreach($user->services as $service)
                  <p>
                    <i class="fas fa-check-circle" style="color: var(--success-color);"></i>
                    <strong>{{ $service->name }}</strong>
                  </p>
                @endforeach
              </div>
            @else
              <p class="text-gray-500" style="padding: 1.5rem;">Vous n'êtes pas encore assigné à un service.</p>
            @endif
          </div>
        </div>
        
        <!-- COMPTE -->
          <div class="card">
            <div class="card-header">
              <h3><i class="fas fa-user-shield"></i> État du Compte</h3>
            </div>
            <div class="card-content">
              <p><i class="fas fa-clock"></i> Dernière connexion : {{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Jamais' }}</p>
              <p><i class="fas fa-calendar-check"></i> Compte créé le : {{ $user->created_at->format('d/m/Y H:i:s') }}</p>
              <p><i class="fas fa-shield-alt"></i> Statut : 
                <span class="badge badge-success">{{$user ? 'Authentifié' : 'Non Authentifié'}}</span>
              </p>
            </div>
          </div>

          

        <!-- ACTIVITÉS -->
        <div class="card" style="margin-top: 30px;">
          <div class="card-header">
            <h3><i class="fas fa-history"></i> Activités Récentes</h3>
          </div>
          <div class="card-content">
            <ul class="activity">
              <li>
                <div class="activity-icon"><i class="fas fa-sign-in-alt"></i></div>
                <div class="activity-content">
                  <h4>Dernière connexion</h4>
                  <p>{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Jamais' }}</p>
                </div>
              </li>
              <li>
                <div class="activity-icon"><i class="fas fa-user-edit"></i></div>
                <div class="activity-content">
                  <h4>Dernière mise à jour du profil</h4>
                  <p>{{ $user->info_updated_at ? $user->info_updated_at->diffForHumans() : 'Aucune mise à jour' }}</p>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script>
    function toggleSidebar() {
      const sidebar = document.querySelector('.sidebar');
      sidebar.classList.toggle('collapsed');
    }

    function toggleMobileSidebar() {
      const sidebar = document.querySelector('.sidebar');
      const overlay = document.querySelector('.sidebar-overlay');
      
      sidebar.classList.toggle('active');
      if (overlay) {
        overlay.classList.toggle('active');
      }
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
      const sidebar = document.querySelector('.sidebar');
      const toggle = document.querySelector('.mobile-menu-toggle');
      
      if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
        if (window.innerWidth <= 768) {
          sidebar.classList.remove('active');
          const overlay = document.querySelector('.sidebar-overlay');
          if (overlay) {
            overlay.classList.remove('active');
          }
        }
      }
    });

    // Handle window resize
    window.addEventListener('resize', function() {
      const sidebar = document.querySelector('.sidebar');
      if (window.innerWidth > 768) {
        sidebar.classList.remove('active');
        const overlay = document.querySelector('.sidebar-overlay');
        if (overlay) {
          overlay.classList.remove('active');
        }
      }
    });
  </script>
</body>
</html>

