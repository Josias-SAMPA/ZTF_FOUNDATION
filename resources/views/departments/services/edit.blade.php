    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@extends('layouts.app')

@section('content')
<div class="edit-service-container">
    <div class="page-header">
        <div class="header-content">
            <h1>Modification du service</h1>
            <nav class="breadcrumb">
                <a href="{{ route('departments.dashboard') }}">Tableau de bord</a> /
                <a href="{{ route('departments.services.index', ['department' => $department->id]) }}">Services</a> /
                <span>Modification de « {{ $service->name }} »</span>
            </nav>
        </div>
    </div>

    <div class="form-card">
        <form action="{{ route('departments.services.update', $service->id) }}" method="POST" class="service-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nom du service <span class="required">*</span></label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $service->name) }}" 
                       required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description détaillée du service</label>
                <textarea id="description" 
                          name="description" 
                          class="form-control @error('description') is-invalid @enderror"
                          rows="4"
                          placeholder="Décrivez les fonctions et responsabilités du service">{{ old('description', $service->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="location">Localisation du service</label>
                <input type="text" 
                       id="location" 
                       name="location" 
                       class="form-control @error('location') is-invalid @enderror"
                       value="{{ old('location', $service->location) }}"
                       placeholder="Bureau, étage, bâtiment...">
                @error('location')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone">Téléphone</label>
                <input type="tel" 
                       id="phone" 
                       name="phone" 
                       class="form-control @error('phone') is-invalid @enderror"
                       value="{{ old('phone', $service->phone) }}">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email du service</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $service->email) }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-check">
                <input type="checkbox" 
                       id="is_active" 
                       name="is_active" 
                       class="form-check-input"
                       value="1" 
                       {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Activer le service</label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Sauvegarder les modifications
                </button>
                <a href="{{ route('departments.services.show', $service->id) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour sans modification
                </a>
            </div>
        </form>
    </div>
</div>

@push('styles')

@endpush
@endsection
