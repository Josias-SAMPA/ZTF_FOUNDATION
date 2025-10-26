    <link rel="stylesheet" href="{{ asset('css/services.css') }}">
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Services de l'Organisation</h1>
        <div class="flex flex-wrap gap-4 mb-6">
            <div class="stats-card bg-blue-500">
                <div class="stats-value">{{ $totalServices }}</div>
                <div class="stats-label">Services</div>
            </div>
            <div class="stats-card bg-green-500">
                <div class="stats-value">{{ $totalDepartments }}</div>
                <div class="stats-label">DÃ©partements</div>
            </div>
            <div class="stats-card bg-purple-500">
                <div class="stats-value">{{ $totalEmployees }}</div>
                <div class="stats-label">EmployÃ©s</div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm">
        @forelse($services as $departmentName => $departmentServices)
            <div class="department-section mb-8">
                <div class="department-header bg-gray-100 px-6 py-4 border-b">
                    <h2 class="text-xl font-semibold text-gray-800">
                        <i class="fas fa-building mr-2"></i>
                        {{ $departmentName }}
                    </h2>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($departmentServices as $service)
                            <div class="service-card">
                                <div class="service-header">
                                    <i class="fas fa-sitemap service-icon"></i>
                                    <h3 class="service-title">{{ $service->name }}</h3>
                                </div>
                                
                                <div class="service-body">
                                    <div class="service-stat">
                                        <span class="stat-label">EmployÃ©s :</span>
                                        <span class="stat-value">{{ $service->users->count() }}</span>
                                    </div>
                                    
                                    @if($service->users->isNotEmpty())
                                        <div class="service-employees">
                                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Liste des employÃ©s :</h4>
                                            <ul class="employee-list">
                                                @foreach($service->users as $employee)
                                                    <li class="employee-item">
                                                        <span class="employee-name">{{ $employee->name }}</span>
                                                        <span class="employee-role">{{ $employee->roles->first()->name ?? 'Non assignÃ©' }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @else
                                        <p class="text-gray-500 text-sm mt-2">Aucun employÃ© dans ce service</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-8">
                <div class="text-gray-400 text-lg">
                    <i class="fas fa-info-circle mr-2"></i>
                    Aucun service n'a Ã©tÃ© trouvÃ©
                </div>
            </div>
        @endforelse
    </div>
</div>


@endsection
