<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('dashboards.css')}}">
</head>
<body>
    <div class="actions-grid">
        @if(Auth::user()->isAdmin2() || Auth::user()->isSuperAdmin() || Auth::user()->isAdmin1())
            <a href="{{ route('departments.services.index', ['department' => Auth::user()->department_id]) }}" class="action-card">
                <i class="fas fa-list action-icon"></i>
                <h3>Vue d'ensemble des services</h3>
                <p class="action-desc">Consultez et gérez tous les services du département</p>
            </a>
            <a href="{{ route('departments.services.create', ['department' => Auth::user()->department_id]) }}" class="action-card">
                <i class="fas fa-plus-circle action-icon"></i>
                <h3>Créer un nouveau service</h3>
                <p class="action-desc">Ajoutez un nouveau service au département</p>
            </a>
        @endif
        <a href="#" class="action-card" onclick="showSection('reports')">
            <i class="fas fa-chart-line action-icon"></i>
            <h3>Analyses et rapports</h3>
            <p class="action-desc">Consultez les statistiques et indicateurs de performance</p>
        </a>
    </div>
</body>
</html>