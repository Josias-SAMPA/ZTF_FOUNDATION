<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title> {{config('app.name')}} </title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

  
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
  @include('partials.welcome-message')
  <div class="container">
    <!-- HEADER -->
    <div class="page-header">
      <h1>Mon Espace Personnel</h1>
      <div class="breadcrumb">
        <a href="{{ route('staff.dashboard') }}">Accueil</a> / Espace Personnel
      </div>
    </div>

    <!-- PROFILE -->
    <div class="profile">
      <div class="avatar"><i class="fas fa-user"></i></div>
      <div class="profile-info">
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:.5rem;">
          <h2>{{ Auth::user()->matricule }}</h2>
          <a href="{{ route('profile.edit') }}" class="btn btn-primary"><i class="fas fa-user-edit"></i> Modifier mon profil</a>
        </div>
        <div class="profile-meta">
          <div><i class="fas fa-envelope"></i>{{ Auth::user()->email }}</div>
          <div><i class="fas fa-building"></i>{{ Auth::user()->Departement->name ?? 'Non assignÃ©' }}</div>
          <div><i class="fas fa-user-tie"></i>{{ Auth::user()->roles->isNotEmpty() ? Auth::user()->roles->first()->display_name : 'Non dÃ©fini' }}</div>
        </div>
      </div>
    </div>

    <!-- GRID -->
    <div class="grid">
      <!-- DEPARTEMENT -->
      <div class="card">
        <div class="card-header">
          <h3><i class="fas fa-building"></i> Mon DÃ©partement</h3>
          <span class="badge badge-success">Actif</span>
        </div>
        @if(Auth::user()->Departement)
          <p><strong>Nom :</strong> {{ Auth::user()->Departement->name }}</p>
          <p><strong>Chef :</strong> {{ Auth::user()->Departement->headDepartment->matricule ?? 'Non assignÃ©' }}</p>
          <p><strong>Description :</strong> {{ Str::limit(Auth::user()->Departement->description,150) }}</p>
        @else
          <p class="text-gray-500">Vous n'Ãªtes pas encore assignÃ© Ã  un dÃ©partement.</p>
        @endif
      </div>

      <!-- COMPTE -->
      <div class="card">
        <div class="card-header">
          <h3><i class="fas fa-user-shield"></i> Ã‰tat du Compte</h3>
        </div>
        <p><i class="fas fa-clock"></i> DerniÃ¨re connexion : {{ Auth::user()->last_login_at ? Auth::user()->last_login_at->format('d/m/Y H:i') : 'Jamais' }}</p>
        <p><i class="fas fa-calendar-check"></i> Compte crÃ©Ã© le : {{ Auth::user()->created_at->format('d/m/Y H:i:s') }}</p>
        <p><i class="fas fa-shield-alt"></i> Statut : 
          <span class="badge badge-success">{{Auth::user() ? 'AuthentifiÃ©' : 'Non AuthentifiÃ©'}}</span>
        </p>
      </div>
    </div>

    <!-- ACTIVITÃ‰S -->
    <div class="card" style="max-width:500px;margin:2rem auto;">
      <div class="card-header">
        <h3><i class="fas fa-history"></i> ActivitÃ©s RÃ©centes</h3>
      </div>
      <ul class="activity">
        <li>
          <div class="activity-icon"><i class="fas fa-sign-in-alt"></i></div>
          <div class="activity-content">
            <h4>DerniÃ¨re connexion</h4>
            <p>{{ Auth::user()->last_login_at ? Auth::user()->last_login_at->diffForHumans() : 'Jamais' }}</p>
          </div>
        </li>
        <li>
          <div class="activity-icon"><i class="fas fa-user-edit"></i></div>
          <div class="activity-content">
            <h4>DerniÃ¨re mise Ã  jour du profil</h4>
            <p>{{ Auth::user()->info_updated_at ? Auth::user()->info_updated_at->diffForHumans() : 'Aucune mise Ã  jour' }}</p>
          </div>
        </li>
      </ul>
    </div>

    <!-- ACTIONS -->
    <div class="actions">
      <a href="{{ route('home') }}" class="btn btn-primary"><i class="fas fa-home"></i> Voir le site</a>
      <a href="{{ route('staff.dashboard') }}" class="btn btn-primary"><i class="fas fa-tachometer-alt"></i> Tableau de bord</a>
      <form method="POST" action="{{ route('logout') }}" style="display: inline;">
        @csrf
        <button type="submit" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> DÃ©connexion</button>
      </form>
    </div>
  </div>
</body>
</html>

