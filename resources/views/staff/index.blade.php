<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Liste des Utilisateurs - ZTF Foundation</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboards.css') }}">
    
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>
    <div class="dashboard-container">
        <main class="main-content" style="margin-left: 0;">
            <div class="page-header">
                <h1 class="page-title">Liste des Utilisateurs</h1>
                <div class="breadcrumb">Tableau de bord / Liste des Utilisateurs</div>
            </div>

            <div class="header-actions">
                <div style="display: flex; gap: 1rem;">
                    
                    <a href="{{ route('committee.dashboard') }}" class="refresh-button">
                        <i class="fas fa-arrow-left"></i>
                        Retour au Dashboard
                    </a>
                    <div class="search-box">
                        <i class="fas fa-search" style="color: #64748b;"></i>
                        <input type="text" placeholder="Rechercher un utilisateur..." id="searchInput">
                    </div>
                </div>
                <button class="refresh-button" onclick="refreshTable()">
                    <i class="fas fa-sync-alt"></i>
                    Actualiser
                </button>
            </div>

            <div class="table-container">
                <form method="POST" action="{{ route('users.update') }}">
                    @csrf
                    <table class="users-table">
                        <thead>
                            <tr>
                                <th>SÃ©lectionner</th>
                                <th>Matricule</th>
                                <th>Email</th>
                                <th>DÃ©partement</th>
                                <th>RÃ´le</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(\App\Models\User::all() as $user)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="selected_users[]" value="{{ $user->id }}">
                                    </td>
                                    <td>{{ $user->matricule }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->Departement->name ?? 'Non assignÃ©' }}</td>
                                    <td>
                                        @foreach($user->roles as $role)
                                            <span class="status-badge status-success">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="#" title="Voir le profil" style="color: var(--primary-color); margin-right: 1rem;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" title="Modifier" style="color: var(--warning-color); margin-right: 1rem;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" 
                                           onclick="confirmDelete({{ $user->id }}, '{{ $user->matricule }}')" 
                                           title="Supprimer" 
                                           style="color: var(--danger-color); margin-right: 1rem;">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <a href="{{ route('user.download.pdf', $user->id) }}" 
                                           title="TÃ©lÃ©charger le PDF" 
                                           style="color: var(--success-color);" 
                                           target="_blank">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 2rem;">
                                        <i class="fas fa-users" style="font-size: 2rem; color: #64748b; margin-bottom: 1rem;"></i>
                                        <p>Aucun utilisateur trouvÃ©</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div style="margin-top: 1rem; text-align: right;">
                        <button type="submit" class="refresh-button">
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
