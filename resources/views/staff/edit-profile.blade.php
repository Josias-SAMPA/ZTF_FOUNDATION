<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier mon Profil - ZTF Foundation</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboards.css') }}">
    
    <link rel="stylesheet" href="{{ asset('css/edit-profile.css') }}">
</head>
<body>
    <div class="dashboard-container">
        <main class="main-content" style="margin-left: 0;">
            <div class="page-header">
                <h1 class="page-title">Modifier mon Profil</h1>
                <div class="breadcrumb">
                    <a href="{{ route('dashboard') }}" class="text-blue-600">Accueil</a> / Mon Profil
                </div>
            </div>

            <div class="profile-container">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="form-card">
                        <div class="form-section">
                            <h2 class="section-title">
                                <i class="fas fa-user text-blue-600"></i>
                                Informations Personnelles
                            </h2>
                            
                            <div class="form-group">
                                <label for="matricule" class="form-label">Matricule</label>
                                <input type="text" 
                                       id="matricule" 
                                       class="form-input" 
                                       value="{{ Auth::user()->matricule }}" 
                                       disabled>
                                <div class="current-info">Le matricule ne peut pas Ãªtre modifiÃ©</div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       class="form-input @error('email') border-red-500 @enderror" 
                                       value="{{ old('email', Auth::user()->email) }}">
                                @error('email')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-section">
                            <h2 class="section-title">
                                <i class="fas fa-lock text-yellow-600"></i>
                                SÃ©curitÃ©
                            </h2>

                            <div class="form-group">
                                <label for="current_password" class="form-label">Mot de passe actuel</label>
                                <input type="password" 
                                       id="current_password" 
                                       name="current_password" 
                                       class="form-input @error('current_password') border-red-500 @enderror">
                                @error('current_password')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password" class="form-label">Nouveau mot de passe</label>
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       class="form-input @error('password') border-red-500 @enderror">
                                @error('password')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                                <input type="password" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       class="form-input">
                            </div>
                        </div>

                        <div class="btn-group">
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i>
                                Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Enregistrer les modifications
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    
    <script src="{{ asset('js/edit-profile.js') }}"></script>
</body>
</html>

