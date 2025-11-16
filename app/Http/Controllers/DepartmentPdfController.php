<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DepartmentPdfController extends Controller
{
    public function generatePDF(Request $request)
    {
        // Vérifier si l'utilisateur est chef de département
        if (!Auth::user()->isAdmin2()) {
            return back()->with('error', 'Accès non autorisé');
        }

        // Récupérer le département de l'utilisateur connecté
        $department = Department::with([
            'head',
            'services.users' => function($query) {
                $query->select('users.id', 'users.name', 'users.matricule', 'users.phone', 'users.service_id')
                    ->with('roles:id,name')
                    ->orderBy('users.name');
            }
        ])->find(Auth::user()->department_id);

        if (!$department) {
            return back()->with('error', 'Département non trouvé');
        }

        // Configuration de DomPDF
        $config = [
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'isRemoteEnabled' => true,
            'dpi' => 150,
            'fontCache' => storage_path('fonts'),
            'tempDir' => storage_path('app/pdf-temp'),
            'chroot' => public_path(),
        ];

        // Générer le PDF avec options
        $pdf = PDF::loadView('departments.pdfs.department-report', compact('department'))
            ->setOptions($config);
        $pdf->setPaper('A4');
        
        // Nom du fichier
        $date = now();
        $filename = 'Liste_Des_Ouvriers_par_Service_' . 
            $department->code . '_Telecharger_le_' . 
            $date->format('Y m d') . '_A_' . 
            sprintf('%02d:%02d:%02d', $date->hour, $date->minute, $date->second) . '.pdf';
        
        // Générer le contenu du PDF
        $pdfContent = $pdf->output();
        
        // Définir le chemin de stockage
        $path = 'pdfs/departments/' . $department->id . '/' . $filename . $department->name;
        
        // Sauvegarder directement via le système de stockage de Laravel
        Storage::disk('public')->put($path, $pdfContent);
        
        // URL publique du PDF
        $url = Storage::disk('public')->url($path);

        // Enregistrer l'historique du PDF dans la base de données si nécessaire
        // ...

        // Télécharger le PDF
        return $pdf->download($filename);
    }

    public function getPdfHistory()
    {
        if (!Auth::user()->isAdmin2()) {
            return back()->with('error', 'Accès non autorisé');
        }

        // Récupérer le département de l'utilisateur
        $department = Department::find(Auth::user()->department_id);
        if (!$department) {
            return back()->with('error', 'Département non trouvé');
        }

        // Récupérer les PDFs du département spécifique
        $departmentPath = 'pdfs/departments/' . $department->id;
        
        // Vérifier si le dossier existe
        if (!Storage::disk('public')->exists($departmentPath)) {
            $pdfs = [];
        } else {
            $pdfs = collect(Storage::disk('public')->files($departmentPath))
                ->filter(function($file) {
                    return pathinfo($file, PATHINFO_EXTENSION) === 'pdf';
                })
                ->sortByDesc(function($file) {
                    return Storage::disk('public')->lastModified($file);
                })
                ->values()
                ->all();
        }

        return view('departments.pdfs.history', [
            'pdfs' => $pdfs,
            'departmentName' => $department->name
        ]);
    }
}