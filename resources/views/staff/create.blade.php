<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>CrÃ©er un utilisateur</title>
  
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
</head>
<body>
  <div class="container">
    <h1>CrÃ©er un nouvel utilisateur</h1>

    <div class="form-container">
      <form action="{{ route('staff.store') }}" method="POST">
        @csrf

        <!-- Matricule -->
        <div class="form-group">
          <label class="form-label" for="matricule">Matricule</label>
          <input type="text" id="matricule" name="matricule" class="form-input" value="{{ old('matricule') }}" required>
          @error('matricule')
            <p class="error-message">{{ $message }}</p>
          @enderror
        </div>

        <!-- Email -->
        <div class="form-group">
          <label class="form-label" for="email">Email</label>
          <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" required>
          @error('email')
            <p class="error-message">{{ $message }}</p>
          @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
          <label class="form-label" for="password">Mot de passe</label>
          <input type="password" id="password" name="password" class="form-input" required>
          @error('password')
            <p class="error-message">{{ $message }}</p>
          @enderror
        </div>

        <!-- RÃ´les -->
        <div class="form-group">
          <label class="form-label">Attribuer un ou plusieurs rÃ´les</label>
          <div class="checkbox-list">
            @foreach($roles as $role)
              <label class="checkbox-item">
                <input type="checkbox" name="roles[]" value="{{ $role->id }}">
                {{ $role->display_name ?? $role->nom }}
              </label>
            @endforeach
          </div>
        </div>

        <!-- Permissions -->
        <div class="form-group">
          <label class="form-label">Attribuer un ou plusieurs permissions</label>
          <div class="checkbox-list">
            @foreach($permissions as $permission)
              <label class="checkbox-item">
                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}">
                {{ $permission->name }}
              </label>
            @endforeach
          </div>
        </div>

        <!-- Boutons -->
        <div class="btn-group">
          <button type="submit" class="btn btn-primary">CrÃ©er</button>
          <a href="{{ route('dashboard') }}" class="btn btn-secondary">Annuler</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>

