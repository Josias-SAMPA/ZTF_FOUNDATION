<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approbations en attente - PDFs Staff</title>
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
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
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

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        .card-header {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-header h3 {
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-body {
            padding: 20px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #475569;
        }

        .info-value {
            color: #64748b;
            word-break: break-word;
        }

        .card-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
        }

        .btn {
            flex: 1;
            padding: 10px 15px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            text-decoration: none;
        }

        .btn-approve {
            background: #10b981;
            color: white;
        }

        .btn-approve:hover {
            background: #059669;
        }

        .btn-reject {
            background: #ef4444;
            color: white;
        }

        .btn-reject:hover {
            background: #dc2626;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 12px;
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

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-pending {
            background: #fef3c7;
            color: #b45309;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            border-radius: 12px;
            max-width: 400px;
        }

        .modal-header {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #1e293b;
        }

        .modal-body {
            margin-bottom: 20px;
        }

        .modal-body textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-family: 'Inter', sans-serif;
        }

        .modal-actions {
            display: flex;
            gap: 10px;
        }

        .modal-actions button {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
        }

        .modal-cancel {
            background: #e2e8f0;
            color: #334155;
        }

        .modal-confirm {
            background: #ef4444;
            color: white;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
            }

            .card-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>
                    <i class="fas fa-hourglass-half"></i>
                    Approbations en attente
                </h1>
                <p>Approuvez ou rejetez les demandes d'accès aux PDFs</p>
            </div>
            <a href="{{ route('BigForm') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                Retour
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-info">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($pendingLinks->count() > 0)
            <div class="card-container">
                @foreach($pendingLinks as $link)
                    <div class="card">
                        <div class="card-header">
                            <h3>
                                <i class="fas fa-user"></i>
                                {{ $link->user->first_name ?? 'Utilisateur' }}
                            </h3>
                            <span class="badge badge-pending">En attente</span>
                        </div>

                        <div class="card-body">
                            <div class="info-row">
                                <span class="info-label">Email:</span>
                                <span class="info-value">{{ $link->user->first_email ?? 'N/A' }}</span>
                            </div>

                            <div class="info-row">
                                <span class="info-label">PDF:</span>
                                <span class="info-value">{{ $link->staff->name ?? 'N/A' }}</span>
                            </div>

                            <div class="info-row">
                                <span class="info-label">Demandé le:</span>
                                <span class="info-value">{{ $link->created_at->format('d/m/Y H:i') }}</span>
                            </div>

                            @if($link->notes)
                                <div class="info-row">
                                    <span class="info-label">Notes:</span>
                                    <span class="info-value">{{ $link->notes }}</span>
                                </div>
                            @endif

                            <div class="card-actions">
                                <form method="POST" action="{{ route('pdf.link.approve', $link->id) }}" style="flex: 1;">
                                    @csrf
                                    <button type="submit" class="btn btn-approve" style="width: 100%;">
                                        <i class="fas fa-check"></i>
                                        Approuver
                                    </button>
                                </form>

                                <button type="button" class="btn btn-reject" onclick="openRejectModal({{ $link->id }})">
                                    <i class="fas fa-times"></i>
                                    Rejeter
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($pendingLinks->hasPages())
                <div style="text-align: center; margin-top: 30px;">
                    {!! $pendingLinks->render() !!}
                </div>
            @endif
        @else
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h3>Aucune approbation en attente</h3>
                <p>Tous les PDFs ont été approuvés ou rejetés.</p>
            </div>
        @endif
    </div>

    <!-- Modal de rejet -->
    <div id="rejectModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">Rejeter l'accès</div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <label style="display: block; margin-bottom: 10px; color: #475569; font-weight: 500;">Raison du rejet:</label>
                    <textarea name="reason" placeholder="Expliquez pourquoi vous rejetez cette demande..." style="min-height: 100px;"></textarea>
                </div>
                <div class="modal-actions">
                    <button type="button" class="modal-cancel" onclick="closeRejectModal()">Annuler</button>
                    <button type="submit" class="modal-confirm">Confirmer le rejet</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRejectModal(linkId) {
            const modal = document.getElementById('rejectModal');
            const form = document.getElementById('rejectForm');
            form.action = `{{ url('/pdf-link') }}/${linkId}/reject`;
            modal.style.display = 'block';
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('rejectModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
