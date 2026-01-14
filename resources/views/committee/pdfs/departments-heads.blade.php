<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Liste des DÃ©partements et Chefs</title>
    
    <link rel="stylesheet" href="{{ asset('css/departments-heads.css') }}">
</head>
<body>
    <div class="header">
        @if($logoBase64)
            <img src="data:image/png;base64,{{ $logoBase64 }}" class="logo" alt="CMCI Logo">
        @endif
        <h1>LISTE DES DÃ‰PARTEMENTS ET CHEFS</h1>
        <p>Document gÃ©nÃ©rÃ© le {{ now()->format('d/m/Y Ã  H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 10%;">NÂ°</th>
                <th style="width: 40%;">DÃ©partement</th>
                <th style="width: 50%;">Nom du Chef de Departement</th>
                <th style="width: 40%;">Matricule du Chef de Departement</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departments as $index => $department)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $department->name }}</td>
                    <td>{{ $department->head->name ?? 'Non renseigné' }}</td>
                    <td>{{ $department->head->matricule ?? 'Non renseigné' }}</td>
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
