<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Services - ZTF Foundation</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>
    <!-- En-tÃªte de la page -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="header-title">ZTF FOUNDATION</h1>
            <p class="header-subtitle"> Liste des Services et du Personnel</p>
            <div class="breadcrumb">
                <a href="{{ route('departments.dashboard') }}">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
                <i class="fas fa-chevron-right"></i>
                <span>Services</span>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center">
                <div class="w-2 h-12 bg-blue-600 rounded-lg mr-4"></div>
                <h1 class="text-2xl font-bold text-gray-800">Liste des Services</h1>
            </div>
            @if(Auth::user()->isAdmin2() || Auth::user()->isSuperAdmin() || Auth::user()->isAdmin1())
                <a href="{{ route('services.create') }}" class="btn-add group">
                    <span class="btn-add-circle">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="btn-add-text">Nouveau Service</span>
                </a>
            @endif
        </div>

        @if(session('success'))
            <div id="success-toast" class="success-toast" role="alert">
                <div class="success-toast-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="success-toast-content">
                    <h4 class="success-toast-title">SuccÃ¨s!</h4>
                    <p class="success-toast-message">{{ session('success') }}</p>
                </div>
                <button class="success-toast-close" onclick="this.parentElement.remove();">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        

        

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Nom du Service
                        </th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Description
                        </th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Manager
                        </th>
                        @if(!Auth::user()->isAdmin2())
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            DÃ©partement
                        </th>
                        @endif
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($services as $service)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $service->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ Str::limit($service->description, 100) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $manager = $service->users()
                                        ->where('matricule', 'LIKE', 'MGR-%')
                                        ->first();
                                @endphp
                                {{ $manager ? $manager->name : 'Non assignÃ©' }}
                            </td>
                            @if(!Auth::user()->isAdmin2())
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $service->department->name ?? 'N/A' }}
                            </td>
                            @endif
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-3">
                                    <!-- Bouton Voir -->
                                    <a href="{{ route('services.show', $service->id) }}" 
                                       class="action-button view-button" 
                                       title="Voir les dÃ©tails">
                                        <i class="fas fa-eye"></i>
                                        <span class="tooltip">Voir</span>
                                    </a>

                                    @if(Auth::user()->isAdmin2() && Auth::user()->department_id === $service->department_id || Auth::user()->isSuperAdmin() || Auth::user()->isAdmin1())
                                        <!-- Bouton Modifier -->
                                        <a href="{{ route('services.edit', $service->id) }}" 
                                           class="action-button edit-button"
                                           title="Modifier le service">
                                            <i class="fas fa-edit"></i>
                                            <span class="tooltip">Modifier</span>
                                        </a>

                                        <!-- Bouton Supprimer -->
                                        <form action="{{ route('services.destroy', $service->id) }}" 
                                              method="POST" 
                                              class="inline-block"
                                              onsubmit="return confirm('ÃŠtes-vous sÃ»r de vouloir supprimer ce service ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="action-button delete-button"
                                                    title="Supprimer le service">
                                                <i class="fas fa-trash-alt"></i>
                                                <span class="tooltip">Supprimer</span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>


                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                Aucun service trouvÃ©
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


    @if(session('error'))
        <div id="error-toast" class="error-toast" role="alert">
            <div class="error-toast-icon">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <span class="error-toast-message">{{ session('error') }}</span>
        </div>
    @endif

    

    
    <script src="{{ asset('js/index.js') }}"></script>
</body>
</html>

