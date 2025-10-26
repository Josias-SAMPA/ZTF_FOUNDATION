    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CrÃ©ation d'un ComitÃ© | ZTF Foundation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    

    @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <div class="committee-card">
            <div class="committee-header">
                <h1 class="committee-title">
                    <i class="fas fa-users-gear"></i>
                    CrÃ©er un Nouveau ComitÃ©
                </h1>
                <p class="committee-subtitle">Remplissez le formulaire ci-dessous pour crÃ©er un nouveau comitÃ©</p>
            </div>

            <form action="{{ route('committee.store') }}" method="POST" class="committee-form">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="name">
                        <i class="fas fa-signature"></i>
                        Nom du ComitÃ©*
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           class="form-input" 
                           value="{{ old('name') }}" 
                           required 
                           placeholder="Entrez le nom du comitÃ©"
                           maxlength="255">
                    <small class="form-help">Le nom doit Ãªtre unique et descriptif</small>
                    @error('name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">
                        <i class="fas fa-align-left"></i>
                        Description du ComitÃ©*
                    </label>
                    <textarea id="description" 
                              name="description" 
                              class="form-input form-textarea" 
                              required 
                              rows="4" 
                              placeholder="DÃ©crivez le rÃ´le et les responsabilitÃ©s de ce comitÃ©">{{ old('description') }}</textarea>
                    <small class="form-help">Donnez une description dÃ©taillÃ©e du comitÃ© et de ses objectifs</small>
                    @error('description')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="button-group">
                    <a href="{{ route('committee.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">CrÃ©er le membre</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

