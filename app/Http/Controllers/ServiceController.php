<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    
    /**
     * Vérifie si l'utilisateur a accès au service
     */
    private function checkServiceAccess(Service $service)
    {
        $user = Auth::user();
        
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->isAdmin2() && $user->department_id === $service->department_id) {
            return true;
        }

        if ($user->department_id === $service->department_id) {
            return true;
        }

        return false;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isSuperAdmin() ) 
            $services = Service::with(['department', 'users'])->get();
        elseif($user->isAdmin1()){
             $services = Service::with(['department', 'users'])->get();
        
        } else {
            // Pour les chefs de département, vérifier le code dans le matricule
            if (preg_match('/^CM-HQ-(.*)-CD$/i', $user->matricule, $matches)) {
                $deptCode = $matches[1];
                $services = Service::with(['department', 'users'])
                    ->whereHas('department', function($query) use ($deptCode) {
                        $query->where('code', $deptCode);
                    })
                    ->get();
            } else {
                $services = Service::with(['department', 'users'])
                    ->where('department_id', $user->department_id)
                    ->get();
            }

         return view('services.index', compact('services'));
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        
        // Seuls les super admins et les chefs de département peuvent créer des services
        if (!$user->isSuperAdmin() && !$user->isAdmin2() && !$user->isAdmin1()) {
            return redirect()->route('services.index')
                ->with('error', "Vous n'êtes pas autorisé à créer un service.");
        }

        $departments = Department::all();
        return view('services.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Seuls les super admins et les chefs de département peuvent créer des services
        if (!$user->isSuperAdmin() && !$user->isAdmin2()) {
            return redirect()->route('services.index')
                ->with('error', "Vous n'êtes pas autorisé à créer un service.");
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'is_active' => 'boolean'
        ]);

        try {
            if (!$user->isSuperAdmin()) {
                // Pour les chefs de département, extraire le code du matricule
                if (preg_match('/^CM-HQ-(.*)-CD$/i', $user->matricule, $matches)) {
                    $deptCode = $matches[1];
                    // Trouver le département correspondant au code
                    $department = Department::where('code', $deptCode)->first();
                    
                    if (!$department) {
                        return back()->with('error', "Département non trouvé pour le code {$deptCode}");
                    }
                    
                    $departmentId = $department->id;
                } else {
                    return back()->with('error', "Format de matricule invalide");
                }
            } else {
                $departmentId = $request->department_id;
            }

            $service = Service::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'department_id' => $departmentId,
                'department_code' => $deptCode ?? null // Stocker le code du département
            ]);

            return redirect()->route('services.index')
                ->with('success', "Le service '{$service->name}' a été créé avec succès.");
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la création du service : ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service = Service::findOrFail($id);
        
        if (!$this->checkServiceAccess($service)) {
            return redirect()->route('services.index')
                ->with('error', "Vous n'êtes pas autorisé à voir ce service.");
        }

        return view('services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $service = Service::findOrFail($id);
        
        if (!$this->checkServiceAccess($service)) {
            return redirect()->route('services.index')
                ->with('error', "Vous n'êtes pas autorisé à modifier ce service.");
        }

        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $service = Service::findOrFail($id);
        
        if (!$this->checkServiceAccess($service)) {
            return redirect()->route('services.index')
                ->with('error', "Vous n'êtes pas autorisé à modifier ce service.");
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255'
        ]);

        try {
            $service->update([
                'name' => $validated['name'],
                'description' => $validated['description']
            ]);

            return redirect()->route('services.index')
                ->with('success', "Service {$service->name} mis à jour avec succès");
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la mise à jour du service : ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $service = Service::findOrFail($id);
            $user = Auth::user();
            
            // Seuls les super admins et les chefs de département de leur propre département peuvent supprimer des services
            if (!$user->isSuperAdmin() && 
                !($user->isAdmin2() && $user->department_id === $service->department_id)) {
                throw new \Exception("Vous n'êtes pas autorisé à supprimer ce service.");
            }

            $service->delete();

            return redirect()->route('services.index')
                ->with('success', "Le service '{$service->name}' a été supprimé avec succès.");

        } catch (\Exception $e) {
            return redirect()->route('services.index')
                ->with('error', $e->getMessage());
        }
    }
}
