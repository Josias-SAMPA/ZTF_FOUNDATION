<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Rapport du DÃ©partement</title>
    
    <link rel="stylesheet" href="{{ asset('css/department-report.css') }}">
</head>
<body>
    <!-- HEADER -->
    <div class="header">
        <div style="text-align: center; margin-bottom: 20px;">
            <div style="font-size: 24px; font-weight: bold; color: #003366;">CMCI</div>
            <div style="font-size: 16px; color: #666;">Communaute Missionnaire ChrÃ©tien International</div>
        </div>
        <h1>RAPPORT DU DÃ‰PARTEMENT</h1>
        <p>TÃ©lÃ©chargÃ© le {{ now()->format('d/m/Y Ã  H:i') }}</p>
    </div>

    <!-- INFORMATIONS DU DÃ‰PARTEMENT -->
    <div class="department-info">
        <h3>Nom du DÃ©partement : {{ $department->name }}</h3>
        <h3>Chef de dÃ©partement : {{$department->head->name}}</h3>
        <h3>Contact du Chef de Departement : {{ $department->head->phone ?? 'Non renseignÃ©' }}</h3>
    </div>

    <!-- SECTION OUVRIERS -->
    <h2 class="section-title">Ouvriers par Service</h2>
    <table>
        <thead>
            <tr>
                <th style="width: 20%;">Service</th>
                <th style="width: 25%;">Nom et PrÃ©nom</th>
                <th style="width: 20%;">Poste</th>
                <th style="width: 15%;">Matricule</th>
                <th style="width: 20%;">TÃ©lÃ©phone</th>
            </tr>
        </thead>
        <tbody>
            @php $currentService = ''; @endphp
            @foreach($department->services->sortBy('name') as $service)
                @forelse($service->users->sortBy('name') as $user)
                    <tr>
                        @if($currentService !== $service->name)
                            <td rowspan="{{ $service->users->count() }}" style="text-align:center; font-weight:bold;">
                                {{ $service->name }}
                            </td>
                            @php $currentService = $service->name; @endphp
                        @endif
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->roles->first()->name ?? 'Non assignÃ©' }}</td>
                        <td>{{ $user->matricule }}</td>
                        <td>{{ $user->phone ?? 'Non renseignÃ©' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td>{{ $service->name }}</td>
                        <td colspan="4" class="empty-message">Aucun personnel affectÃ© Ã  ce service</td>
                    </tr>
                @endforelse
            @endforeach
        </tbody>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        <p>Document confidentiel - {{ config('app.name') }}</p>
        <p>Page 1/1</p>
    </div>
</body>
</html>

