@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/assignments.css') }}?v={{ filemtime(public_path('css/assignments.css')) }}">

<div class="container">
    <!-- PAGE HEADER -->
    <div class="page-header">
        <h1 class="page-title">Gestion des Affectations</h1>
        <div class="breadcrumb">Tableau de bord / Gestion des Affectations</div>
    </div>

    <!-- STATISTIQUES -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-user-times"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Utilisateurs Non Affectés</div>
                <div class="stat-value">{{ $totalUnassigned }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Utilisateurs Affectés</div>
                <div class="stat-value">{{ $totalAssigned }}</div>
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
            <p class="text-secondary">{{ $totalUnassigned }} utilisateur(s) en attente d'affectation</p>
        </div>

        @if($users->count() > 0)
            <div class="card-body">
                <!-- TABLEAU DES UTILISATEURS -->
                <div class="users-list">
                    @foreach($users as $user)
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
                                    @if($user->roles->count() > 0)
                                        <span class="meta-item">
                                            <i class="fas fa-shield-alt"></i> 
                                            {{ $user->roles->pluck('display_name')->implode(', ') }}
                                        </span>
                                    @endif
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

                <!-- PAGINATION -->
                @if($users->hasPages())
                    <div class="pagination-container">
                        {{ $users->render() }}
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
</div>
@endsection
