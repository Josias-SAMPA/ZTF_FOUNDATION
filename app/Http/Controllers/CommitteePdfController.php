<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommitteePdfController extends Controller
{
    private function getLogoBase64()
    {
        $logoPath = public_path('images/CMFI Logo.png');
        return file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : '';
    }

    private function configurePdf($view, $data)
    {
        // Augmenter le temps d'exécution et la limite de mémoire
        ini_set('max_execution_time', config('pdf.execution_time', 300));
        ini_set('memory_limit', config('pdf.memory_limit', '512M'));

        return PDF::loadView($view, $data)
            ->setOptions([
                'defaultFont' => 'Times-Roman',
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'isRemoteEnabled' => true,
                'dpi' => 150,
                'defaultMediaType' => 'print',
                'fontCache' => storage_path('fonts'),
                'tempDir' => storage_path('app/pdf-temp'),
                'chroot' => public_path(),
                'enable-javascript' => true,
                'javascript-delay' => 1000,
                'no-stop-slow-scripts' => true,
            ]);
    }

    public function generateDepartmentsHeadsList()
    {
        if (!Auth::user()->isAdmin()) {
            return back()->with('error', 'Accès non autorisé');
        }

        $departments = Department::with('head')->orderBy('name')->get();
        $logoBase64 = $this->getLogoBase64();

        $pdf = $this->configurePdf('committee.pdfs.departments-heads', compact('departments', 'logoBase64'));
        
        return $pdf->download('Liste_Departements_et_Chefs_' . now()->format('Y-m-d_His') . '.pdf');
    }

    public function generateDepartmentsHeadsServicesList()
    {
        if (!Auth::user()->isAdmin()) {
            return back()->with('error', 'Accès non autorisé');
        }

        $departments = Department::with(['head', 'services'])
            ->orderBy('name')
            ->get();
        $logoBase64 = $this->getLogoBase64();

        $pdf = $this->configurePdf('committee.pdfs.departments-heads-services', compact('departments', 'logoBase64'));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('Liste_Departements_Chefs_et_Services_' . now()->format('Y-m-d_His') . '.pdf');
    }

    public function generateDepartmentsEmployeesList()
    {
        if (!Auth::user()->isAdmin()) {
            return back()->with('error', 'Accès non autorisé');
        }

        // Optimisation des requêtes avec chunking
        $departments = Department::with([
            'services' => function($query) {
                $query->orderBy('name');
            },
            'services.users' => function($query) {
                $query->orderBy('name')->select([
                    'users.id',
                    'users.name',
                    'users.matricule',
                    'service_user.service_id',
                    'service_user.user_id'

                ]);
            },
            'services.users.roles' => function($query) {
                $query->select(['roles.id as role_id', 'roles.name as role_name']);
            }
        ])
        ->orderBy('name')
        ->get();
        
        $logoBase64 = $this->getLogoBase64();

        $pdf = $this->configurePdf('committee.pdfs.departments-employees', compact('departments', 'logoBase64'));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('Liste_Departements_et_Employes_' . now()->format('Y-m-d_His') . '.pdf');
    }
}
