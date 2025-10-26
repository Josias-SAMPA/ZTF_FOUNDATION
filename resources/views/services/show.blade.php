<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DÃ©tails du Service - ZTF Foundation</title>
    
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $service->name }}</h1>
        </div>

        <div class="info-section">
            <div class="info-group">
                <div class="info-label">Description</div>
                <div class="info-value">{{ $service->description }}</div>
            </div>

            <div class="info-group">
                <div class="info-label">CrÃ©Ã© le</div>
                <div class="info-value">{{ $service->created_at->format('d/m/Y Ã  H:i') }}</div>
            </div>

            <div class="info-group">
                <div class="info-label">DerniÃ¨re modification</div>
                <div class="info-value">{{ $service->updated_at->format('d/m/Y Ã  H:i') }}</div>
            </div>
        </div>

        <div class="info-section">
            <div class="info-group">
                <div class="info-label">Membres du service</div>
                <div class="info-value">
                    @if($service->users->count() > 0)
                        <ul style="list-style-type: none; padding: 0;">
                            @foreach($service->users as $user)
                                <li style="margin-bottom: 0.5rem; padding: 0.5rem; background-color: #fff; border-radius: 0.25rem;">
                                    {{ $user->matricule }} - {{ $user->name }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>Aucun membre assignÃ© Ã  ce service.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="buttons">
            <a href="{{ route('services.index') }}" class="btn btn-back">
                Retour Ã  la liste
            </a>
            @if(Auth::user()->isAdmin2() || Auth::user()->isSuperAdmin() || Auth::user()->isAdmin1() || (str_starts_with(Auth::user()->matricule, 'CM-HQ-') && str_ends_with(Auth::user()->matricule, '-CD')))
                <a href="{{ route('services.edit', $service->id) }}" class="btn btn-edit">
                    Modifier le service
                </a>
            @endif
        </div>
    </div>
</body>
</html>

