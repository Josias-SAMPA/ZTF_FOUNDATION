<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Liste des Utilisateurs - ZTF Foundation</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/staff-index.css') }}?v={{ filemtime(public_path('css/staff-index.css')) }}">
</head>
<body>
    <div class="dashboard-container">
        <main class="main-content">
            <div class="page-header">
                <h1 class="page-title">Liste des Utilisateurs</h1>
                <div class="breadcrumb">Tableau de bord / Liste des Utilisateurs</div>
            </div>

            <div class="header-actions">
                <div class="action-left">
                    <a href="{{ route('committee.dashboard') }}" class="btn-back">
                        <i class="fas fa-arrow-left"></i>
                        Retour au Dashboard
                    </a>
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Rechercher un utilisateur..." id="searchInput">
                    </div>
                </div>
                <button class="btn-refresh" onclick="refreshTable()">
                    <i class="fas fa-sync-alt"></i>
                    Actualiser
                </button>
            </div>

            <div class="table-container">
                <form method="POST" action="{{ route('users.bulk.update') }}" class="users-form">
                    @csrf
                    <table class="users-table">
                        <thead>
                            <tr>
                                <th class="th-checkbox">
                                    <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)">
                                </th>
                                <th>Matricule</th>
                                <th>Email</th>
                                <th>Département</th>
                                <th>Poste Occupé</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(\App\Models\User::all() as $user)
                                <tr>
                                    <td class="td-checkbox">
                                        <input type="checkbox" name="selected_users[]" value="{{ $user->id }}">
                                    </td>
                                    <td><span class="matricule">{{ $user->matricule }}</span></td>
                                    <td><span class="email">{{ $user->email }}</span></td>
                                    <td>
                                        <span class="department">
                                            {{ $user->department->name ?? 'Non assigné' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="roles-badges">
                                            @foreach($user->roles as $role)
                                                <span class="badge badge-role">{{ $role->display_name }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="td-actions">
                                        <div class="action-buttons">
                                            <a href="#" class="btn-icon btn-view" title="Voir le profil">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn-icon btn-edit" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#" 
                                               onclick="confirmDelete({{ $user->id }}, '{{ $user->matricule }}')" 
                                               class="btn-icon btn-delete" 
                                               title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            <a href="{{ route('user.download.pdf', $user->id) }}" 
                                               class="btn-icon btn-download" 
                                               title="Télécharger le PDF" 
                                               target="_blank">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="tr-empty">
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <i class="fas fa-users"></i>
                                            <p>Aucun utilisateur trouvé</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script src="{{ asset('js/index.js') }}"></script>
</body>
</html>
