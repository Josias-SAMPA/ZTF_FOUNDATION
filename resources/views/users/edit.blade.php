<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>{{ config('app.name') }} - Modifier mon profil</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/staff-dashboard.css?v=' . filemtime(public_path('css/staff-dashboard.css'))) }}">
  <link rel="stylesheet" href="{{ asset('css/users-edit.css?v=' . filemtime(public_path('css/users-edit.css'))) }}">
</head>
<body>
  @include('partials.welcome-message')
  
  <div class="dashboard-wrapper">
    <!-- SIDEBAR -->
    <aside class="sidebar">
      <div class="sidebar-header">
        <div class="logo">
          <i class="fas fa-user-tie"></i>
          <span>STAFF</span>
        </div>
      </div>

      <nav class="sidebar-nav">
        <ul>
          <li>
            <a href="{{ route('staff.dashboard') }}" class="nav-link">
              <i class="fas fa-home"></i>
              <span>Tableau de bord</span>
            </a>
          </li>
          <li>
            <a href="{{ route('profile.edit') }}" class="nav-link active">
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
          <h1>Modifier mon Profil</h1>
          <p class="breadcrumb">
            <a href="{{ route('staff.dashboard') }}">Tableau de bord</a> / Mon Profil
          </p>
        </div>
      </div>

      <!-- CONTAINER -->
      <div class="container">
        @if (session('status') === 'profile-updated')
          <div class="success-message">
            <i class="fas fa-check-circle"></i>
            <span>Votre profil a été mis à jour avec succès !</span>
          </div>
        @endif

        <!-- EDIT FORM CARD -->
        <div class="card">
          <div class="card-header">
            <h3><i class="fas fa-user-edit"></i> Informations Personnelles</h3>
          </div>
          <div class="card-content">
            <form method="POST" action="{{ route('profile.update') }}">
              @csrf

              <div class="form-group">
                <label for="matricule"><i class="fas fa-id-card"></i> Matricule</label>
                <input type="text" id="matricule" name="matricule" value="{{ old('matricule', $user->matricule) }}" readonly />
              </div>

              <div class="form-group">
                <label for="name"><i class="fas fa-user"></i> Nom Complet</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required />
                @error('name')
                  <div class="error-message">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required />
                @error('email')
                  <div class="error-message">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="phone"><i class="fas fa-phone"></i> Téléphone</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone ?? '') }}" />
                @error('phone')
                  <div class="error-message">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-save"></i> Enregistrer les modifications
                </button>
                <a href="{{ route('staff.dashboard') }}" class="btn-back">
                  <i class="fas fa-arrow-left"></i> Retour
                </a>
              </div>
            </form>
          </div>
        </div>

        <!-- USER INFO CARD -->
        <div class="card" style="margin-top: 2rem;">
          <div class="card-header">
            <h3><i class="fas fa-info-circle"></i> Informations du Compte</h3>
          </div>
          <div class="card-content">
            <p><strong>ID :</strong> {{ $user->id }}</p>
            <p><strong>Rôle :</strong> 
              @if($user->roles->isNotEmpty())
                <span class="badge badge-success">{{ $user->roles->first()->display_name }}</span>
              @else
                <span class="text-gray-500">Non assigné</span>
              @endif
            </p>
            <p><strong>Département :</strong> 
              @if($user->department)
                {{ $user->department->name }}
              @else
                <span class="text-gray-500">Non assigné</span>
              @endif
              @if($user->services->isNotEmpty())
                <p><strong>Service :</strong> {{ $user->services->first()->name }}</p>
              @else
                <p><strong>Service :</strong> <span class="text-gray-500">Non assigné</span></p>
              @endif
            </p>
            <p><strong>Créé le :</strong> {{ $user->created_at->format('d/m/Y à H:i') }}</p>
            <p><strong>Dernière connexion :</strong> {{ $user->last_login_at ? $user->last_login_at->format('d/m/Y à H:i') : 'Jamais' }}</p>
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
  </script>
</body>
</html>
