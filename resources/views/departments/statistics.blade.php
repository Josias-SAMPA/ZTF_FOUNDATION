    <link rel="stylesheet" href="{{ asset('css/statistics.css') }}">
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques des DÃ©partements - ZTF Foundation</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">


    <header class="navbar">
        <a href="/" class="nav-brand">
            <img src="{{ asset('images/CMFI Logo.png') }}" alt="CMCI Logo" title="ZTF Foundation">
            <span>ZTF Foundation</span>
        </a>
        <div class="nav-menu">
            <a href="{{ route('dashboard') }}" class="nav-link">
                <i class="fas fa-chart-line"></i>
                Tableau de bord
            </a>
            <a href="{{ route('departments.index') }}" class="nav-link">
                <i class="fas fa-sitemap"></i>
                DÃ©partements
            </a>
            <a href="#" class="nav-link">
                <i class="fas fa-user"></i>
                Mon Profil
            </a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="nav-link" style="background: none; border: none; cursor: pointer;">
                    <i class="fas fa-sign-out-alt"></i>
                    DÃ©connexion
                </button>
            </form>
        </div>
    </header>

    <div class="stats-container">
    <h1 class="page-title">Statistiques des DÃ©partements et leurs Chefs</h1>

    <div class="stats-cards">
        <div class="stat-card blue">
            <div class="stat-title">Total DÃ©partements</div>
            <div class="stat-value">{{ $departments->count() }}</div>
        </div>
        <div class="stat-card green">
            <div class="stat-title">DÃ©partements avec Chef</div>
            <div class="stat-value">{{ $departments->whereNotNull('head_id')->count() }}</div>
        </div>
        <div class="stat-card yellow">
            <div class="stat-title">DÃ©partements sans Chef</div>
            <div class="stat-value">{{ $departments->whereNull('head_id')->count() }}</div>
        </div>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>DÃ©partement</th>
                <th>Chef</th>
                <th>Matricule</th>
                <th>Date d'assignation</th>
                <th>Nombre d'employÃ©s</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($departments as $dept)
                <tr>
                    <td>
                        <div class="dept-name">{{ $dept->name }}</div>
                        <div class="dept-description">{{ Str::limit($dept->description, 50) }}</div>
                    </td>
                    <td>{{ optional($dept->head)->name ?? 'Non assignÃ©' }}</td>
                    <td>{{ optional($dept->head)->matricule ?? '-' }}</td>
                    <td>
                        @if($dept->head_assigned_at)
                            {{ $dept->head_assigned_at->format('d/m/Y') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $dept->users_count ?? 0 }} employÃ©s</td>
                    <td>
                        @if($dept->head_id)
                            <form action="{{ route('departments.remove.head', $dept->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-button btn-remove">
                                    Retirer
                                </button>
                            </form>
                            <a href="#" class="action-button btn-details">DÃ©tails</a>
                        @else
                            <a href="{{ route('departments.assign.head.form') }}" 
                               class="action-button btn-assign">
                                Assigner un chef
                            </a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="empty-message">
                        Aucun dÃ©partement trouvÃ©
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</div>

    
    <script src="{{ asset('js/statistics.js') }}"></script>
</body>
</html>
