<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des téléchargements PDF</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            padding: 20px;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
            color: white;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header h1 {
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 1.8rem;
        }

        .header p {
            opacity: 0.9;
            margin-top: 5px;
        }

        .btn-back {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .table-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
        }

        th {
            padding: 15px 20px;
            text-align: left;
            font-weight: 600;
            color: #334155;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 15px 20px;
            border-bottom: 1px solid #e2e8f0;
            color: #475569;
        }

        tbody tr {
            transition: background-color 0.3s ease;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        .file-name {
            font-weight: 500;
            color: #1e293b;
            word-break: break-word;
        }

        .file-info {
            font-size: 0.85rem;
            color: #64748b;
            margin-top: 3px;
        }

        .date-time {
            color: #64748b;
            font-size: 0.9rem;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-align: center;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-warning {
            background: #fef3c7;
            color: #b45309;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .counter {
            text-align: center;
            font-weight: 600;
            color: #4f46e5;
            background: #f0f4ff;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .btn-download {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-download:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .btn-download:active {
            transform: translateY(0);
        }

        .empty-state {
            padding: 60px 20px;
            text-align: center;
            color: #64748b;
        }

        .empty-state i {
            font-size: 3rem;
            color: #cbd5e1;
            margin-bottom: 15px;
        }

        .empty-state h3 {
            color: #334155;
            margin-bottom: 10px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 5px;
            padding: 20px;
            border-top: 1px solid #e2e8f0;
        }

        .pagination a,
        .pagination span {
            padding: 8px 12px;
            border-radius: 6px;
            color: #4f46e5;
            text-decoration: none;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .pagination a:hover {
            background: #f0f4ff;
            border-color: #4f46e5;
        }

        .pagination .active {
            background: #4f46e5;
            color: white;
            border-color: #4f46e5;
        }

        .pagination .disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .header h1 {
                justify-content: center;
            }

            table {
                font-size: 0.85rem;
            }

            th,
            td {
                padding: 10px 12px;
            }

            .actions {
                flex-direction: column;
            }

            .btn-download {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>
                    <i class="fas fa-history"></i>
                    Historique des téléchargements
                </h1>
                <p>Consultez et retéléchargez les rapports précédemment générés</p>
            </div>
            <a href="{{ route('BigForm') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                Retour au formulaire
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        @if($pdfHistories->count() > 0)
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-file-pdf"></i> Nom du fichier</th>
                            <th><i class="fas fa-calendar"></i> Date de génération</th>
                            <th><i class="fas fa-database"></i> Taille</th>
                            <th><i class="fas fa-download"></i> Téléchargements</th>
                            <th><i class="fas fa-clock"></i> Dernier téléchargement</th>
                            <th><i class="fas fa-user"></i> Généré par</th>
                            <th><i class="fas fa-actions"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pdfHistories as $pdf)
                            <tr>
                                <td>
                                    <div class="file-name">{{ $pdf->pdf_filename }}</div>
                                    <div class="file-info">ID: {{ $pdf->hq_staff_form_id }}</div>
                                </td>
                                <td class="date-time">
                                    {{ $pdf->generated_at->format('d/m/Y H:i') }}
                                </td>
                                <td>
                                    {{ $pdf->formatted_file_size ?? 'N/A' }}
                                </td>
                                <td>
                                    <div class="counter">
                                        {{ $pdf->download_count }} fois
                                    </div>
                                </td>
                                <td class="date-time">
                                    @if($pdf->last_downloaded_at)
                                        {{ $pdf->last_downloaded_at->diffForHumans() }}
                                    @else
                                        <span style="color: #cbd5e1;">Jamais</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-success">
                                        {{ $pdf->generated_by }}
                                    </span>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('redownload.pdf', $pdf->id) }}" class="btn-download">
                                            <i class="fas fa-download"></i>
                                            Télécharger
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                @if($pdfHistories->hasPages())
                    <div class="pagination">
                        {!! $pdfHistories->render() !!}
                    </div>
                @endif
            </div>
        @else
            <div class="table-container">
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>Aucun historique disponible</h3>
                    <p>Aucun rapport PDF n'a été généré pour le moment.</p>
                </div>
            </div>
        @endif
    </div>
</body>
</html>
