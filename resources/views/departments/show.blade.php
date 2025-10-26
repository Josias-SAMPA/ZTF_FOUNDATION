<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $department->name }} - DÃ©tails du dÃ©partement</title>
    
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
</head>
<body>
    <div class="container">
        <div class="department-header">
            <h1 class="department-title">{{ $department->name }}</h1>
            <div class="department-info">
                <p>{{ $department->description }}</p>
            </div>

            <div class="department-stats">
                <div class="stat-card">
                    <div class="stat-number">{{ $department->services->count() }}</div>
                    <div class="stat-label">Services</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $department->users->count() }}</div>
                    <div class="stat-label">EmployÃ©s</div>
                </div>
                @if($department->skills->count() > 0)
                <div class="stat-card">
                    <div class="stat-number">{{ $department->skills->count() }}</div>
                    <div class="stat-label">CompÃ©tences requises</div>
                </div>
                @endif
            </div>

            <div class="actions">
                <a href="{{ route('departments.edit', $department) }}" class="btn btn-primary">Modifier le dÃ©partement</a>
                <a href="{{ route('departments.index') }}" class="btn btn-secondary">Retour Ã  la liste</a>
            </div>
        </div>

        <div class="services-section">
            <h2>Services du dÃ©partement</h2>
            @foreach($department->services as $service)
                <div class="service-card">
                    <div class="service-header">
                        <span class="service-name">{{ $service->name }}</span>
                        <span class="service-stats">
                            {{ $service->users->count() }} employÃ©(s)
                        </span>
                    </div>
                    <div class="employees-list">
                        @if($service->users->count() > 0)
                            @foreach($service->users as $employee)
                                <div class="employee-item">
                                    <div class="employee-info">
                                        <div class="employee-avatar">
                                            {{ strtoupper(substr($employee->name ?? $employee->email, 0, 2)) }}
                                        </div>
                                        <div class="employee-details">
                                            <h4>{{ $employee->name ?? 'N/A' }}</h4>
                                            <p>{{ $employee->email }}</p>
                                        </div>
                                    </div>
                                    <div class="employee-status">
                                        @if($employee->is_online)
                                            <span class="badge badge-online">En ligne</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="no-employees">
                                Aucun employÃ© dans ce service
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

            @if($department->services->count() === 0)
                <div class="no-employees">
                    Aucun service dans ce dÃ©partement
                </div>
            @endif
        </div>
    </div>
</body>
</html>

