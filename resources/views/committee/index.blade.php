<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Membres du ComitÃ©</title>
    
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="header-title"> ComitÃ©  de Nehemie</h1>
            <p class="header-subtitle">Liste des Comite cree</p>
        </div>

        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-value">{{ $totalMembers ?? 0 }}</div>
                <div class="stat-label">Membres au total</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $activeMembers ?? 0 }}</div>
                <div class="stat-label">Membres actifs</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $onlineMembers ?? 0 }}</div>
                <div class="stat-label">Membres en ligne</div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Liste des membres</h2>
            </div>

            <div class="search-box">
                <input type="text" class="search-input" placeholder="Rechercher un membre..." id="searchInput" onkeyup="searchTable()">
            </div>

            <div class="table-container">
                <table id="membersTable">
                    <thead>
                        <tr>
                            <th>Membre</th>
                            <th>Email</th>
                            <th>DerniÃ¨re connexion</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members ?? [] as $member)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <div class="avatar">
                                            {{ strtoupper(substr($member->name ?? $member->email, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div style="font-weight: 500;">{{ $member->name ?? 'N/A' }}</div>
                                            <div style="font-size: 0.875rem; color: var(--secondary-color);">
                                                {{ $member->matricule }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $member->email }}</td>
                                <td>
                                    {{ $member->last_login_at ? \Carbon\Carbon::parse($member->last_login_at)->diffForHumans() : 'Jamais' }}
                                </td>
                                <td>
                                    @if($member->is_online)
                                        <span class="badge badge-online">En ligne</span>
                                    @else
                                        <span class="badge badge-offline">Hors ligne</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('users.show', $member->id) }}" class="btn btn-secondary">
                                            Voir dÃ©tails
                                        </a>
                                        @if(auth()->user()->can('edit_users'))
                                            <a href="{{ route('users.edit', $member->id) }}" class="btn btn-primary">
                                                Modifier
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        Aucun membre du comitÃ© trouvÃ©
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    <script src="{{ asset('js/index.js') }}"></script>
</body>
</html>

