<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>CrÃ©er une permission</title>
  
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
</head>
<body>
  <div class="container">
    <h1>CrÃ©er une nouvelle permission</h1>

    <div class="form-container">
      <form action="{{ route('permissions.store') }}" method="POST">
        @csrf

        <!-- Nom -->
        <div class="form-group">
          <label class="form-label" for="name">Nom (identifiant technique)</label>
          <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required>
          @error('name')
            <p class="error-message">{{ $message }}</p>
          @enderror
        </div>

        <!-- Nom d'affichage -->
        <div class="form-group">
          <label class="form-label" for="display_name">Nom d'affichage</label>
          <input type="text" id="display_name" name="display_name" class="form-input" value="{{ old('display_name') }}" required>
          @error('display_name')
            <p class="error-message">{{ $message }}</p>
          @enderror
        </div>

        <!-- Description -->
        <div class="form-group">
          <label class="form-label" for="description">Description</label>
          <textarea id="description" name="description" class="form-input form-textarea" required>{{ old('description') }}</textarea>
          @error('description')
            <p class="error-message">{{ $message }}</p>
          @enderror
        </div>

        <!-- Associer Ã  des rÃ´les -->
        <div class="form-group">
          <label class="form-label">Associer Ã  des rÃ´les</label>
          <div class="checkbox-list">
            @foreach($roles as $role)
              <label class="checkbox-item">
                <input type="checkbox" name="roles[]" value="{{ $role->id }}">
                {{ $role->display_name ?? $role->nom }}
              </label>
            @endforeach
          </div>
        </div>

        <!-- Boutons -->
        <div class="btn-group">
          <button type="submit" class="btn btn-primary">CrÃ©er</button>
          <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>

