<!D    <meta charset="utf-8">
    <title>Liste des Ouvriers par Departements</title>
    
    <link rel="stylesheet" href="{{ asset('css/departments-employees.css') }}">
</head>PE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Liste des Ouvriers par Departements</title>  
    <link rel="stylesheet" href="{{asset('css/pdfs.css')}}">
    <link rel="stylesheet" href="{{ asset('css/departments-employees.css') }}">
</head>
<body>
    <div class="header">
        
            <div class="titles">
                <h1>COMMUNAUTE MISSIONNAIRE CHRETIENNE INTERNATIONALE</h1>
                <h1>CHRISTIAN MISSIONARY FELLOWSHIP INTERNATIONAL</h1>
            </div>
        
        <h2>LISTE DES DÃ‰PARTEMENTS ET OUVRIERS</h2>
        <p>Document gÃ©nÃ©rÃ© le {{ now()->format('d/m/Y Ã  H:i:s') }}</p>
    </div>

    @foreach($departments as $department)
        <div class="department-section">
            <div class="department-header">
                DÃ©partement : {{ $department->name }}
            </div>
            <table>
                <thead>
                    <tr>
                                <th width="5%">NÂ°</th>
                        <th width="30%">Nom de l'employÃ©</th>
                        <th width="15%">Matricule</th>
                        <th width="25%">Service</th>
                        <th width="25%">Poste</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($department->services as $service)
                        @foreach($service->users as $index => $employee)
                            <tr>
                                <td style="text-align: center;">{{ $index + 1 }}</td>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->matricule }}</td>
                                <td>{{ $service->name }}</td>
                                <td>{{ $employee->roles->first()->role_name ?? 'Non assignÃ©' }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach

    <div class="footer">
        <p>Document confidentiel - {{ config('app.name') }}</p>
        <p>Page {PAGENO}/{nbpg}</p>
    </div>
</body>
</html>
