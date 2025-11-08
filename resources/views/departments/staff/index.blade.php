<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ouvriers du département - {{ auth()->user()->department->name ?? 'Département' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
     
    <link rel="stylesheet" href="{{ asset('dashboards.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard-responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/staff/index.css') }}">
</head>
<body>
    <div class="dashboard-container">
        <main class="main-content" style="margin-left: 0;">
            <div class="page-header">
                <h1 class="page-title">Ouvriers de {{ auth()->user()->department->name ?? 'département' }}</h1>
                <div class="breadcrumb">
                    <a href="{{ route('departments.dashboard') }}" class="text-blue-600">Tableau de bord</a> / Personnel
                </div>
            </div>

            <div class="header-actions">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Rechercher un membre du personnel...">
                </div>
                <a href="{{ route('departments.staff.create') }}" class="btn-primary">
                    <i class="fas fa-user-plus"></i>
                    Ajouter un employé
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-container">
                <table class="staff-table">
                    <thead>
                        <tr>
                            <th>Matricule</th>
                            <th>Nom et prénom</th>
                            <th>Adresse e-mail</th>
                            <th>Service</th>
                            <th>Statut</th>
                            <th>Dernière activité</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employee)
                            <tr>
                                <td>{{ $employee->matricule }}</td>
                                <td>{{ $employee->name ?? 'Non renseigné' }}</td>
                                <td>{{ $employee->email }}</td>
                                <td>
                                    @if($employee->services->isNotEmpty())
                                        <span class="service-tag">
                                            <i class="fas fa-sitemap"></i>
                                            {{ $employee->services->first()->name }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">Non affecté</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="online-status">
                                        <span class="status-dot {{ $employee->is_online ? 'dot-online' : 'dot-offline' }}"></span>
                                        {{ $employee->is_online ? 'En ligne' : 'Hors ligne' }}
                                    </div>
                                </td>
                                <td>{{ $employee->last_activity_at ? $employee->last_activity_at->diffForHumans() : 'Jamais' }}</td>
                                <td>
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('staff.show', $employee->id) }}" class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('staff.edit', $employee->id) }}" class="text-yellow-600 hover:text-yellow-800">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('staff.destroy', $employee->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" 
                                                    onclick="return confirm('Êtes-vous sûr de vouloir retirer cet employé du département ?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="flex flex-col items-center justify-center space-y-2">
                                        <i class="fas fa-users text-gray-400 text-4xl"></i>
                                        <p class="text-gray-500">Aucun membre du personnel n'est affecté à ce département</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    
    <script src="{{ asset('js/staff/index.js') }}"></script>
</body>
</html>
