    <link rel="stylesheet" href="{{ asset('css/history.css') }}">
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">
                    <i class="fas fa-history mr-2"></i>
                    Historique des rapports PDF
                </h2>
                <p class="text-gray-600 mt-1">
                    <i class="fas fa-building mr-1"></i>
                    {{ $departmentName }}
                </p>
            </div>
            <a href="{{ route('departments.dashboard') }}" class="btn-save" style="background-color: #64748b; text-decoration: none;">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour au tableau de bord
            </a>
        </div>

        @if(count($pdfs) > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-left">Nom du fichier</th>
                            <th class="px-4 py-2 text-left">Date de gÃ©nÃ©ration</th>
                            <th class="px-4 py-2 text-left">Taille</th>
                            <th class="px-4 py-2 text-left">Actions</th>
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
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                                        <div>
                                            <div class="font-medium">{{ $fileName }}</div>
                                            <div class="text-sm text-gray-500">
                                                PDF Document
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm">
                                        {{ date('d/m/Y H:i', $createDate) }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::createFromTimestamp($createDate)->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    {{ $size }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex space-x-2">
                                        <a href="{{ Storage::disk('public')->url($pdf) }}" 
                                           target="_blank"
                                           class="btn-action btn-view">
                                            <i class="fas fa-eye mr-1"></i>
                                            Voir
                                        </a>
                                        <a href="{{ Storage::disk('public')->url($pdf) }}" 
                                           download
                                           class="btn-action btn-download">
                                            <i class="fas fa-download mr-1"></i>
                                            TÃ©lÃ©charger
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8">
                <div class="bg-gray-50 rounded-lg p-6 max-w-lg mx-auto">
                    <i class="fas fa-folder-open text-gray-400 text-5xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun rapport disponible</h3>
                    <p class="text-gray-500 mb-4">Aucun rapport PDF n'a encore Ã©tÃ© gÃ©nÃ©rÃ© pour ce dÃ©partement.</p>
                    <a href="{{ route('departments.pdf.generate') }}" class="btn-save">
                        <i class="fas fa-plus-circle mr-2"></i>
                        GÃ©nÃ©rer un nouveau rapport
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>


@endsection
