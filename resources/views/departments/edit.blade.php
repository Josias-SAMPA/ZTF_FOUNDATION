<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le département - {{ $department->name }}</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}?v={{ filemtime(public_path('css/edit.css')) }}">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">ZTF FOUNDATION</div>
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->matricule ?? ' Admin Grade 1'}}</div>
                    <div class="user-role">
                        @if(Auth::user()->isSuperAdmin())
                            Super Administrateur
                        @elseif(Auth::user()->isAdmin1())
                            Administrateur
                        @elseif(Auth::user()->isAdmin2())
                            Chef de Département
                        @else
                            Utilisateur
                        @endif
                    </div>
                </div>
            </div>
            <nav>
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="{{ route('committee.dashboard') }}" class="nav-link">
                            <i class="fas fa-home"></i>
                            Tableau de bord
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('departments.show', $department->id) }}" class="nav-link">
                            <i class="fas fa-arrow-left"></i>
                            Retour au département
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="nav-link" style="cursor: pointer;">
                            @csrf
                            <i class="fas fa-sign-out-alt"></i>
                            <button type="submit" style="background: none; border: none; color: inherit; padding: 0; cursor: pointer;">
                                Déconnexion
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="page-header">
                <h1 class="page-title">Modifier le département</h1>
                <div class="breadcrumb">Département / Modifier / {{ $department->name }}</div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Informations du département</h2>
                    <p class="text-secondary">Modifiez les informations du département et ses services associés</p>
                </div>

                <form action="{{ route('departments.update', $department) }}" method="POST" class="form-container">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="form-label" for="name">Nom du département</label>
                        <input type="text" id="name" name="name" class="form-input" 
                               value="{{ old('name', $department->name) }}" required>
                        @error('name')
                            <p class="error-message"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="description">Description</label>
                        <textarea id="description" name="description" class="form-input form-textarea" 
                                  required>{{ old('description', $department->description) }}</textarea>
                        @error('description')
                            <p class="error-message"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="head_id">Chef de département</label>
                        <select id="head_id" name="head_id" class="form-input" required>
                            <option value="">Sélectionner un chef de département</option>
                            @foreach($users ?? [] as $user)
                                <option value="{{ $user->id }}" 
                                    {{ old('head_id', $department->head_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name ?? $user->email }}
                                </option>
                            @endforeach
                        </select>
                        @error('head_id')
                            <p class="error-message"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    @if(Auth::user()->isSuperAdmin())
                    <div class="skills-section">
                        <h3>Compétences requises</h3>
                        <div class="skills-list">
                            @foreach($department->skills as $skill)
                                <div class="skill-item">
                                    <span class="skill-name">{{ $skill->name }}</span>
                                    <button type="button" class="remove-skill" 
                                            onclick="removeSkill(this)" data-skill-id="{{ $skill->id }}">&times;</button>
                                </div>
                            @endforeach
                        </div>

                        <div class="add-skill">
                            <h4>Ajouter une compétence</h4>
                            <div class="input-group">
                                <input type="text" class="form-input" id="newSkillName" 
                                       placeholder="Nom de la compétence">
                                <button type="button" class="btn btn-primary" onclick="addSkill()">Ajouter</button>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Enregistrer les modifications
                        </button>
                        <a href="{{ route('departments.show', $department) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                        @if(Auth::user()->isSuperAdmin())
                        <form action="{{ route('departments.destroy', $department) }}" 
                              method="POST" 
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce département ?');"
                              style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Supprimer le département
                            </button>
                        </form>
                        @endif
                    </div>
                </form>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Services associés</h2>
                </div>
                <div class="services-list">
                    @forelse($department->services as $service)
                        <div class="service-item">
                            <div class="service-info">
                                <h4>{{ $service->name }}</h4>
                                <p><i class="fas fa-users"></i> {{ $service->users->count() }} employé(s)</p>
                            </div>
                            <div class="service-actions">
                                <a href="{{ route('services.edit', $service) }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">
                            <i class="fas fa-folder-open"></i> Aucun service associé à ce département
                        </p>
                    @endforelse
                </div>
                <div class="form-actions" style="margin-top: 1rem;">
                    <a href="{{ route('services.create', ['department_id' => $department->id]) }}" 
                       class="btn btn-primary">
                        <i class="fas fa-plus"></i> Ajouter un service
                    </a>
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('js/edit.js') }}"></script>
</body>
</html>

