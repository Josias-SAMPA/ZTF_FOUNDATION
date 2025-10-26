<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choisir votre dÃ©partement - ZTF Foundation</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/choose.css') }}">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Bienvenue, Chef de DÃ©partement</h1>
            <p>Veuillez  saisir le code du dÃ©partement dont vous Ãªtes responsable</p>
        </div>

        @if(session('message'))
            <div class="success">
                {{ session('message') }}
            </div>
        @endif

        <form action="{{ route('departments.saveDepts') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="departement">Code du DÃ©partement</label>
                <input 
                    type="text" 
                    id="departement" 
                    name="departement" 
                    class="form-input @error('departement') border-error @enderror"
                    required 
                    placeholder="Ex: ECSD"
                    value="{{ old('departement') }}"
                >
                @error('departement')
                    <div class="error">{{ $message }}</div>
                @enderror
                <small style="color: #718096; font-size: 0.75rem; margin-top: 0.25rem; display: block;">
                    Le code du dÃ©partement doit Ãªtre en majuscules (sera automatiquement converti)
                </small>
            </div>

            <button type="submit" class="btn">
                Confirmer mon dÃ©partement
            </button>
        </form>
    </div>

    
    <script src="{{ asset('js/choose.js') }}"></script>
</body>
</html>
