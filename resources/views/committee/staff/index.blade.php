<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs - ComitÃ©</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body class="bg-gray-100">
    <div class="user-list-container">
        <!-- En-tÃªte -->
        <div class="header-actions">
            <h1 class="text-2xl font-bold text-gray-800">Gestion des Utilisateurs</h1>
            <a href="{{ route('committee.staff.create') }}" class="btn-add">
                <i class="fas fa-plus"></i>
                Ajouter un utilisateur
            </a>
        </div>

        <!-- Section des filtres -->
        <div class="filters-section">
            <div class="search-box">
                <input type="text" 
                       placeholder="Rechercher un utilisateur..." 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="filter-box">
                <select class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Tous les statuts</option>
                    <option value="active">Actif</option>
                    <option value="inactive">Inactif</option>
                </select>
            </div>
            <div class="filter-box">
                <select class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Tous les rÃ´les</option>
                    <option value="admin">Administrateur</option>
                    <option value="staff">Staff</option>
                    <option value="chef_service">Chef de Service</option>
                </select>
            </div>
        </div>

        <!-- Tableau des utilisateurs -->
        <table class="user-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>RÃ´le</th>
                    <th>Statut</th>
                    <th>DerniÃ¨re Connexion</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->isAdmin1())
                                Administrateur
                            @elseif($user->isAdmin2())
                                Chef de DÃ©partement
                            @elseif($user->isChefService())
                                Chef de Service
                            @else
                                Staff
                            @endif
                        </td>
                        <td>
                            <span class="status-badge {{ $user->is_active ? 'status-active' : 'status-inactive' }}">
                                {{ $user->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td>{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Jamais' }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('committee.staff.show', $user->id) }}" class="btn btn-view">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('committee.staff.edit', $user->id) }}" class="btn btn-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('committee.staff.destroy', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete" onclick="return confirm('ÃŠtes-vous sÃ»r de vouloir supprimer cet utilisateur ?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            Aucun utilisateur trouvÃ©
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="pagination">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</body>
</html>
