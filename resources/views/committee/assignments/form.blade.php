@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/assignments.css') }}?v={{ filemtime(public_path('css/assignments.css')) }}">

<div class="container">
    <div class="page-header">
        <a href="{{ route('committee.assignments.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Retour aux affectations
        </a>
        <h1 class="page-title">Affecter un Ouvrier aux Départements</h1>
        <div class="breadcrumb">Affectations / {{ $user->name ?? $user->email }}</div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- User Info Card -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Informations de l'Ouvrier</h2>
        </div>
        <div class="card-body">
            <div class="user-details">
                <div class="detail-row">
                    <span class="label">Nom :</span>
                    <span class="value">{{ $user->name ?? $user->email }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Matricule :</span>
                    <span class="value">{{ $user->matricule }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Email :</span>
                    <span class="value">{{ $user->email }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Assignment Form Card -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Affecter aux Départements</h2>
            <p class="text-secondary">Sélectionnez un ou plusieurs départements</p>
        </div>
        <form method="POST" action="{{ route('committee.assignments.store', $user->id) }}" class="card-body">
            @csrf
            <div class="form-group">
                <label class="form-label">Départements</label>
                <div class="departments-grid">
                    @forelse($departments as $department)
                        <div class="department-checkbox">
                            <input 
                                type="checkbox" 
                                id="dept_{{ $department->id }}" 
                                name="departments[]" 
                                value="{{ $department->id }}"
                                @if(old('departments') && in_array($department->id, old('departments'))) checked @endif
                            >
                            <label for="dept_{{ $department->id }}" class="checkbox-label">
                                <span class="checkbox-box">
                                    <i class="fas fa-check"></i>
                                </span>
                                <span class="checkbox-text">
                                    <span class="dept-name">{{ $department->name }}</span>
                                    <span class="dept-code">{{ $department->code ?? 'N/A' }}</span>
                                </span>
                            </label>
                        </div>
                    @empty
                        <p class="text-muted">Aucun département disponible</p>
                    @endforelse
                </div>
                @error('departments')
                    <span class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Affecter l'Ouvrier
                </button>
                <a href="{{ route('committee.assignments.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
