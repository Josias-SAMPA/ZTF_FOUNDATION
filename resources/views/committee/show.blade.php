<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DÃ©tails du membre du comitÃ©</title>
    
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
</head>
<body>
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h1 class="card-title">{{ $member->name }}</h1>
                <div class="btn-group">
                    <a href="{{ route('committee.edit', $member) }}" class="btn btn-primary">
                        Modifier
                    </a>
                    <form action="{{ route('committee.destroy', $member) }}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" 
                                onclick="return confirm('ÃŠtes-vous sÃ»r de vouloir supprimer ce membre ?')">
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>

            <div class="info-grid">
                <div class="info-section">
                    <h2 class="info-title">Informations personnelles</h2>
                    <ul class="info-list">
                        <li class="info-item">
                            <span class="info-label">Matricule</span>
                            <span class="info-value">{{ $member->matricule }}</span>
                        </li>
                        <li class="info-item">
                            <span class="info-label">Email</span>
                            <span class="info-value">{{ $member->email }}</span>
                        </li>
                        <li class="info-item">
                            <span class="info-label">DÃ©partement</span>
                            <span class="info-value">
                                {{ $member->department ? $member->department->name : 'Non assignÃ©' }}
                            </span>
                        </li>
                    </ul>
                </div>

                <div class="info-section">
                    <h2 class="info-title">RÃ´les et Permissions</h2>
                    <div class="info-list">
                        <div class="info-item">
                            <span class="info-label">RÃ´les</span>
                            <div class="badge-group">
                                @foreach($member->roles as $role)
                                    <span class="badge badge-success">{{ $role->display_name }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Permissions</span>
                            <div class="badge-group">
                                @foreach($member->permissions as $permission)
                                    <span class="badge badge-warning">{{ $permission->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-section">
                    <h2 class="info-title">ActivitÃ©</h2>
                    <ul class="info-list">
                        @foreach($activities as $key => $value)
                            <li class="info-item">
                                <span class="info-label">{{ ucfirst(str_replace('_', ' ', $key)) }}</span>
                                <span class="info-value">{{ $value }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="btn-group">
            <a href="{{ route('committee.index') }}" class="btn btn-primary">
                Retour Ã  la liste
            </a>
        </div>
    </div>
</body>
</html>

