<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Liste des DÃ©partements, Chefs et Services</title>
    
    <link rel="stylesheet" href="{{ asset('css/departments-heads-services.css') }}">
</head>
<body>
    <div class="header">
        @if($logoBase64)
            <img src="data:image/png;base64,{{ $logoBase64 }}" class="logo" alt="CMCI Logo">
        @endif
        <h1>LISTE DES DÃ‰PARTEMENTS, CHEFS ET SERVICES</h1>
        <p>Document gÃ©nÃ©rÃ© le {{ now()->format('d/m/Y Ã  H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">NÂ°</th>
                <th style="width: 25%;">DÃ©partement</th>
                <th style="width: 30%;">Chef de DÃ©partement</th>
                <th style="width: 15%;">Matricule</th>
                <th style="width: 25%;">Services</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departments as $index => $department)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $department->name }}</td>
                    <td>{{ $department->head->name ?? 'Non assignÃ©' }}</td>
                    <td>{{ $department->head->matricule ?? 'N/A' }}</td>
                    <td>
                        <ul class="service-list">
                            @foreach($department->services as $service)
                                <li>{{ $service->name }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Document confidentiel - {{ config('app.name') }}</p>
        <p>Page 1/1</p>
    </div>
</body>
</html>
