<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Historique des Rapports PDF - {{ $departmentName }}</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/pdf-history.css') }}">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <div class="header-content">
                <div class="header-title">
                    <h1>
                        <i class="fas fa-history"></i>
                        Historique des Rapports PDF
                    </h1>
                    <div class="department-info">
                        <i class="fas fa-building"></i>
                        <span>{{ $departmentName }}</span>
                    </div>
                </div>
                <a href="{{ route('departments.dashboard') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i>
                    Retour au Tableau de Bord
                </a>
            </div>
        </header>

        <!-- Main Content -->
        <main class="main-content">
            @if(count($pdfs) > 0)
                <!-- Table Container -->
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>
                                    <i class="fas fa-file"></i> Nom du Fichier
                                </th>
                                <th>
                                    <i class="fas fa-calendar"></i> Date de Génération
                                </th>
                                <th>
                                    <i class="fas fa-database"></i> Taille
                                </th>
                                <th>
                                    <i class="fas fa-cogs"></i> Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pdfs as $pdf)
                                @php
                                    $fileName = basename($pdf);
                                    $createDate = Storage::disk('public')->lastModified($pdf);
                                    $fileSize = Storage::disk('public')->size($pdf);
                                    
                                    // Convertir la taille en format lisible
                                    if ($fileSize < 1024) {
                                        $size = $fileSize . ' o';
                                    } elseif ($fileSize < 1024 * 1024) {
                                        $size = round($fileSize / 1024, 2) . ' Ko';
                                    } else {
                                        $size = round($fileSize / (1024 * 1024), 2) . ' Mo';
                                    }
                                @endphp
                                <tr>
                                    <td>
                                        <div class="file-info">
                                            <div class="file-icon">
                                                <i class="fas fa-file-pdf"></i>
                                            </div>
                                            <div class="file-details">
                                                <h4>{{ $fileName }}</h4>
                                                <span class="file-type">Document PDF</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="date-info">
                                            {{ date('d/m/Y H:i', $createDate) }}
                                        </div>
                                        <div class="date-relative">
                                            {{ \Carbon\Carbon::createFromTimestamp($createDate)->diffForHumans() }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="file-size">{{ $size }}</span>
                                    </td>
                                    <td>
                                        <div class="actions">
                                            <a href="{{ Storage::disk('public')->url($pdf) }}" 
                                               target="_blank" 
                                               rel="noopener noreferrer"
                                               title="Ouvrir le fichier"
                                               class="btn btn-view">
                                                <i class="fas fa-eye"></i>
                                                Voir
                                            </a>
                                            <a href="{{ Storage::disk('public')->url($pdf) }}" 
                                               download 
                                               title="Télécharger le fichier"
                                               class="btn btn-download">
                                                <i class="fas fa-download"></i>
                                                Télécharger
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-state-box">
                        <div class="empty-state-icon">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <h3>Aucun Rapport Disponible</h3>
                        <p>Aucun rapport PDF n'a encore été généré pour ce département.</p>
                        <a href="{{ route('departments.pdf.generate') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i>
                            Générer un Nouveau Rapport
                        </a>
                    </div>
                </div>
            @endif
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>
