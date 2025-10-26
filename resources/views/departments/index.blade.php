<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des DÃ©partements - ZTF Foundation</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboards.css') }}">
    
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>
    <div class="dashboard-container">
        <main class="main-content" style="margin-left: 0;">
            <div class="page-header">
                <h1 class="page-title">Liste des DÃ©partements</h1>
                <div class="breadcrumb">Tableau de bord / DÃ©partements</div>
            </div>

            <div class="header-actions">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Rechercher un dÃ©partement...">
                </div>
                @if(Auth::user()->isSuperAdmin())
                <a href="{{ route('dashboard') }}" class="btn-primary">
                    <i class="fas fa-plus"></i>
                    Retour au tableau de Bord
                </a>
                @elseif(Auth::user()->isAdmin1())
                <a href="{{ route('committee.dashboard') }}" class="btn-primary">
                    <i class="fas fa-plus"></i>
                    Retour au tableau de Bord
                </a>
                @endif
                <a href="{{ route('departments.create') }}" class="btn-primary">
                    <i class="fas fa-plus"></i>
                    Nouveau DÃ©partement
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success" role="alert" id="successAlert">
                    <div class="flex-1">{{ session('success') }}</div>
                    <button type="button" class="alert-dismiss" onclick="this.parentElement.style.display='none'">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            <div class="table-container">
                <table class="departments-table">
                    <thead>
                        <tr>
                            <th>Nom du DÃ©partement</th>
                            <th>Description</th>
                            <th>Chef de DÃ©partement</th>
                            <th>Nombre d'EmployÃ©s</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($depts as $dept)
                            <tr>
                                <td>{{ $dept->name }}</td>
                                <td>{{ Str::limit($dept->description, 50) }}</td>
                                <td>{{ $dept->headDepartment ? $dept->headDepartment->matricule : 'Non assignÃ©' }}</td>
                                <td>{{ $dept->users->count() }}</td>
                                <td>
                                    <span class="status-badge {{ $dept->users->count() > 0 ? 'status-active' : 'status-inactive' }}">
                                        {{ $dept->users->count() > 0 ? 'Actif' : 'Inactif' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('departments.show', $dept->id) }}" class="btn-action" title="Voir les dÃ©tails">
                                            <i class="fas fa-eye text-primary"></i>
                                        </a>
                                        <a href="{{ route('departments.edit', $dept->id) }}" class="btn-action" title="Modifier">
                                            <i class="fas fa-edit text-warning"></i>
                                        </a>
                                        <form action="{{ route('departments.destroy', $dept->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action" style="color: #dc2626; border: none; background: none; cursor: pointer;" 
                                                    onclick="return confirm('Attention ! Cette action supprimera le dÃ©partement et tous ses employÃ©s associÃ©s. ÃŠtes-vous sÃ»r de vouloir continuer ?')" 
                                                    title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-folder-open text-gray-400 text-3xl mb-3"></i>
                                    <p>Aucun dÃ©partement n'a Ã©tÃ© crÃ©Ã© pour le moment.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    
    <script src="{{ asset('js/index.js') }}"></script>
</body>
</html>

