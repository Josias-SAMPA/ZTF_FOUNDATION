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
            <a href="{{route('departments.staff.index')}}" class="action-card">
                <i class="fas fa-users action-icon"></i>
                <h3>Personnel du département</h3>
                <p class="action-desc">Consultez la liste complète des employés</p>
            </a>
            <a href="{{route('departments.staff.create')}}" class="action-card">
                <i class="fas fa-user-plus action-icon"></i>
                <h3>Intégrer un employé</h3>
                <p class="action-desc">Ajoutez un nouveau membre au département</p>
            </a>
            <a href="{{route('statistique')}}" class="action-card">
                <i class="fas fa-chart-line action-icon"></i>
                <h3>Analyses RH</h3>
                <p class="action-desc">Consultez les indicateurs du personnel</p>
            </a>
        </div>
</body>
</html>