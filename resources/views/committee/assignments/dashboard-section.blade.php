{{-- Section Affectations pour le Dashboard --}}
@php
    use App\Models\User;
@endphp

<!-- STATISTIQUES -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-user-times"></i>
        </div>
        <div class="stat-content">
            <div class="stat-label">Utilisateurs Non Affectés</div>
            <div class="stat-value">{{ $unassignedCount ?? User::whereDoesntHave('departments')->count() }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-user-check"></i>
        </div>
        <div class="stat-content">
            <div class="stat-label">Utilisateurs Affectés</div>
            <div class="stat-value">{{ $assignedCount ?? User::has('departments')->count() }}</div>
        </div>
    </div>
</div>

<!-- MESSAGES FLASH -->
@if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> 
        <div>
            <strong>Succès !</strong>
            <p>{{ session('success') }}</p>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i> 
        <div>
            <strong>Erreur !</strong>
            <p>{{ session('error') }}</p>
        </div>
    </div>
@endif

<!-- SECTION PRINCIPALE -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Utilisateurs Non Assignés</h2>
        <p class="text-secondary">
            @php $unassigned = User::whereDoesntHave('departments')->count(); @endphp
            {{ $unassigned }} utilisateur(s) en attente d'affectation
        </p>
    </div>

    @php $unassignedUsers = User::whereDoesntHave('departments')->orderBy('name')->limit(10)->get(); @endphp

    @if($unassignedUsers->count() > 0)
        <div class="card-body">
            <!-- TABLEAU DES UTILISATEURS -->
            <div class="users-list">
                @foreach($unassignedUsers as $user)
                    <div class="user-item">
                        <div class="user-avatar">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div class="user-info">
                            <h4>{{ $user->name ?? $user->email }}</h4>
                            <div class="user-meta">
                                <span class="meta-item">
                                    <i class="fas fa-id-card"></i> {{ $user->matricule }}
                                </span>
                                <span class="meta-item">
                                    <i class="fas fa-envelope"></i> {{ $user->email }}
                                </span>
                            </div>
                        </div>
                        <div class="user-actions">
                            <a href="{{ route('committee.assignments.form', $user->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-link"></i> Affecter
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- LIEN VERS LA PAGE COMPLÈTE -->
            @if($unassigned > 10)
                <div class="view-all-link" style="text-align: center; margin-top: 24px; padding-top: 24px; border-top: 1px solid #e5e7eb;">
                    <a href="{{ route('committee.assignments.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-right"></i> Voir tous les utilisateurs ({{ $unassigned }})
                    </a>
                </div>
            @endif
        </div>
    @else
        <!-- EMPTY STATE -->
        <div class="card-body">
            <div class="empty-state">
                <i class="fas fa-check-circle"></i>
                <h3>Tous les utilisateurs sont affectés !</h3>
                <p>Aucun utilisateur n'est en attente d'affectation à un département.</p>
            </div>
        </div>
    @endif
</div>

<style>
    /* Réutiliser les styles du fichier assignments.css */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 24px;
        display: flex;
        align-items: center;
        gap: 20px;
        transition: all 0.3s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .stat-card:hover {
        background: linear-gradient(135deg, #f1f5f9, #e0e7ff);
        border-color: #3b82f6;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
        transform: translateY(-2px);
    }

    .stat-icon {
        font-size: 2.5rem;
        color: #3b82f6;
        min-width: 60px;
        text-align: center;
    }

    .stat-content {
        flex: 1;
    }

    .stat-label {
        font-size: 0.9rem;
        color: #6b7280;
        font-weight: 500;
        margin-bottom: 8px;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
    }

    .alert {
        padding: 16px 20px;
        border-radius: 10px;
        margin-bottom: 24px;
        display: flex;
        align-items: flex-start;
        gap: 16px;
        font-weight: 500;
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert i {
        font-size: 1.25rem;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .alert strong {
        display: block;
        margin-bottom: 4px;
    }

    .alert p {
        margin: 0;
        font-weight: 500;
    }

    .alert-success {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(20, 184, 166, 0.1));
        border: 1px solid rgba(34, 197, 94, 0.3);
        color: #166534;
    }

    .alert-success i {
        color: #22c55e;
    }

    .alert-danger {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(244, 114, 97, 0.1));
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #7f1d1d;
    }

    .alert-danger i {
        color: #ef4444;
    }

    .card {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        margin-bottom: 24px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border-color: #d1d5db;
    }

    .card-header {
        padding: 24px;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid #e5e7eb;
        position: relative;
    }

    .card-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #3b82f6, #2563eb);
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
    }

    .text-secondary {
        color: #6b7280;
        font-size: 0.9rem;
        margin: 8px 0 0 0;
    }

    .card-body {
        padding: 24px;
    }

    .users-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .user-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px 20px;
        background: linear-gradient(135deg, #f9fafb, #f3f4f6);
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .user-item:hover {
        background: linear-gradient(135deg, #f3f4f6, #eff2f5);
        border-color: #3b82f6;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
        transform: translateY(-2px);
    }

    .user-avatar {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .user-info {
        flex: 1;
        min-width: 0;
    }

    .user-info h4 {
        font-size: 1rem;
        font-weight: 600;
        color: #1f2937;
        margin: 0 0 8px 0;
    }

    .user-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .meta-item {
        font-size: 0.85rem;
        color: #6b7280;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .meta-item i {
        color: #9ca3af;
    }

    .user-actions {
        display: flex;
        gap: 8px;
        flex-shrink: 0;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        border: none;
        font-family: 'Inter', sans-serif;
        font-size: 0.95rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }

    .btn-sm {
        padding: 8px 12px;
        font-size: 0.85rem;
    }

    .btn-secondary {
        background-color: #e5e7eb;
        color: #1f2937;
    }

    .btn-secondary:hover {
        background-color: #d1d5db;
        transform: translateY(-1px);
    }

    .empty-state {
        text-align: center;
        padding: 60px 40px;
        color: #6b7280;
    }

    .empty-state i {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 20px;
        display: block;
    }

    .empty-state h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin: 0 0 12px 0;
    }

    .empty-state p {
        font-size: 1rem;
        margin: 0;
    }

    .view-all-link {
        display: flex;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .user-item {
            flex-direction: column;
            gap: 12px;
            align-items: flex-start;
        }

        .user-actions {
            width: 100%;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .user-meta {
            flex-direction: column;
            gap: 8px;
        }
    }
</style>
