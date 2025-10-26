<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur - {{ $user->name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
</head>
<body>
    <header class="navbar">
        <a href="/" class="nav-brand">
            <img src="{{ asset('images/CMFI Logo.png') }}" alt="Logo" style="height: 40px;">
            <span>ZTF Foundation</span>
        </a>
        <div class="nav-menu">
            <a href="{{ route('dashboard') }}" class="nav-link">
                <i class="fas fa-chart-line"></i> Tableau de bord
            </a>
            <a href="{{ route('departments.index') }}" class="nav-link">
                <i class="fas fa-sitemap"></i> DÃ©partements
            </a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="nav-link" style="background: none; border: none; cursor: pointer;">
                    <i class="fas fa-sign-out-alt"></i> DÃ©connexion
                </button>
            </form>
        </div>
    </header>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul style="margin: 0; padding-left: 1rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="profile-header">
            <div class="profile-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="profile-info">
                <h1>{{ $user->name ?? 'Non renseigne pour le moment' }}</h1>
                <p><i class="fas fa-envelope"></i> {{ $user->email }}</p>
                <p><i class="fas fa-id-badge"></i> {{ $user->matricule }}</p>
            </div>
        </div>

        <div class="profile-sections">
            <div class="profile-section">
                <h2 class="section-title">Modifier le profil</h2>
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label class="form-label">Nom</label>
                        <input type="text" name="name" class="form-input" value="{{ $user->name }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input" value="{{ $user->email }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Mettre Ã  jour le profil</button>
                </form>
            </div>

            <div class="profile-section">
                <h2 class="section-title">Changer le mot de passe</h2>
                <form action="{{ route('profile.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label class="form-label">Mot de passe actuel</label>
                        <input type="password" name="current_password" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nouveau mot de passe</label>
                        <input type="password" name="password" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Confirmer le nouveau mot de passe</label>
                        <input type="password" name="password_confirmation" class="form-input" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Changer le mot de passe</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

