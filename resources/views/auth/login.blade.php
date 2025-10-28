<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Login</title>
    <link rel="stylesheet" href="{{asset('login.css')}}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1>ZTF Foundation Login</h1>
            <p>Connectez-vous Ã  votre compte</p>

            @if(session('success'))
                <div class="alert alert-success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px;">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                    <span>{{session('success')}}</span>
                </div>
            @endif

            @if ($errors->any())
                <div style="color: red; margin-bottom: 1rem;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf

                <label for="matricule">Matricule</label>
                <input id="matricule" type="text" name="matricule" value="{{ old('matricule') }}" placeholder="CM-HQ-IT-001" required autofocus>

                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>

                <label for="password">Mot de passe</label>
                <input id="password" type="password" name="password" required>

                <button type="submit" class="login-btn">Se connecter</button>
            </form>

            <div class="back-home">
                <a href="{{ route('home') }}" class="home-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Retour Ã  l'accueil
                </a>
            </div>
        </div>
    </div>

    <!-- Modal pour le département -->
    <div class="modal fade" id="departmentModal" tabindex="-1" aria-labelledby="departmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="departmentModalLabel">Configuration du département</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="modalErrors" class="alert alert-danger" style="display: none;"></div>
                    <form id="departmentForm" class="department-form">
                        <div class="mb-3">
                            <label for="department_name" class="form-label">Nom du département</label>
                            <input type="text" class="form-control" id="department_name" name="department_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="department_code" class="form-label">Code du département</label>
                            <input type="text" class="form-control" id="department_code" name="department_code" required>
                            <small class="text-muted">Ex: FIN, IT, RH, etc.</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" id="saveDepartment">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('js/department-modal.js')}}"></script>
</body>
</html>
