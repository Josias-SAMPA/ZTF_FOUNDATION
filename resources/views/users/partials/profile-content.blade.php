    <link rel="stylesheet" href="{{ asset('css/profile-content.css') }}">
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
        <h1>{{ $user->name ?? 'Non renseigné' }}</h1>
        <p><i class="fas fa-envelope"></i> {{ $user->email }}</p>
        <p><i class="fas fa-id-badge"></i> {{ $user->matricule }}</p>
    </div>
</div>

<div class="profile-sections">
    <div class="profile-section">
        <h2 class="section-title">Informations personnelles</h2>
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label class="form-label">Nom complet</label>
                <input type="text" name="name" class="form-input" value="{{ $user->name }}" required placeholder="Votre nom et prénom">
            </div>

            <div class="form-group">
                <label class="form-label">Adresse e-mail</label>
                <input type="email" name="email" class="form-input" value="{{ $user->email }}" required placeholder="votre.email@exemple.com">
            </div>

            <div class="form-group">
                <label class="form-label">Numéro de téléphone</label>
                <input type="text" name="phone" class="form-input" value="{{ $user->phone }}" required placeholder="Ex: +237 6XX XXX XXX">
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour le profil</button>
        </form>
    </div>

    <div class="profile-section">
        <h2 class="section-title">Sécurité du compte</h2>
        <form action="{{ route('profile.password.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label class="form-label">Mot de passe actuel</label>
                <input type="password" name="current_password" class="form-input" required placeholder="Saisissez votre mot de passe actuel">
            </div>

            <div class="form-group">
                <label class="form-label">Nouveau mot de passe</label>
                <input type="password" name="password" class="form-input" required placeholder="8 caractères minimum">
            </div>

            <div class="form-group">
                <label class="form-label">Confirmation du nouveau mot de passe</label>
                <input type="password" name="password_confirmation" class="form-input" required placeholder="Retapez le nouveau mot de passe">
            </div>

            <button type="submit" class="btn btn-primary">Modifier le mot de passe</button>
        </form>
    </div>
</div>


