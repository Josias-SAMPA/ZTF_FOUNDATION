<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CrÃ©er un DÃ©partement - ZTF Foundation</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboards.css') }}">
    
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
</head>
<body>
    <div class="dashboard-container">
        <main class="main-content" style="margin-left: 0;">
            <div class="page-header">
                <h1 class="page-title">CrÃ©er un Nouveau DÃ©partement</h1>
                <div class="breadcrumb">
                    <a href="{{ route('departments.index') }}" class="text-blue-600">DÃ©partements</a> / CrÃ©er
                </div>
            </div>

            <div class="form-container">
                @if(session('success'))
                    <div class="alert alert-success">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <p>{{ session('success') }}</p>
                        </div>
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

                <form action="{{ route('departments.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-label">Nom du DÃ©partement <span class="text-red-500">*</span></label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               class="form-input @error('name') border-red-500 @enderror" 
                               value="{{ old('name') }}" 
                               required 
                               placeholder="Entrez le nom du dÃ©partement">
                        @error('name')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="code" class="form-label">Code du DÃ©partement <span class="text-red-500">*</span></label>
                        <input type="text" 
                               id="code" 
                               name="code" 
                               class="form-input @error('code') border-red-500 @enderror" 
                               value="{{ old('code') }}" 
                               required 
                               placeholder="Ex: IT, MATH, PHY"
                               maxlength="10"
                               pattern="[A-Z]+"
                               title="Le code doit Ãªtre en majuscules"
                               style="text-transform: uppercase;">
                        @error('code')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">Description <span class="text-red-500">*</span></label>
                        <textarea id="description" 
                                  name="description" 
                                  class="form-input form-textarea @error('description') border-red-500 @enderror" 
                                  required 
                                  placeholder="DÃ©crivez les responsabilitÃ©s et le rÃ´le de ce dÃ©partement">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    

                    <div class="btn-group">
                        <a href="{{ route('departments.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Retour
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            CrÃ©er le DÃ©partement
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    
    <script src="{{ asset('js/create.js') }}"></script>
</body>
</html>
