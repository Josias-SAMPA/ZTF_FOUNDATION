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

            <div class="form-group">
                <label class="form-label">Contact</label>
                <input type="text" name="phone" class="form-input" value="{{ $user->phone }}" required>
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


