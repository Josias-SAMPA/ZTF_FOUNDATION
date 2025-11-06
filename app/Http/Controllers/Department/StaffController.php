<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    // ... autres méthodes ...

    public function assignToService(Request $request, User $user)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id'
        ]);

        DB::transaction(function () use ($user, $request) {
            // Détacher l'utilisateur de son service actuel s'il en a un
            $user->services()->detach();
            
            // Attacher l'utilisateur au nouveau service
            $user->services()->attach($request->service_id);

            // Mettre à jour le cache du compteur si nécessaire
            $service = Service::find($request->service_id);
            $service->touch(); // Force la mise à jour du timestamp
        });

        return redirect()->back()->with('success', 'Employé affecté au service avec succès');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'service_id' => 'required|exists:services,id',
            // ... autres validations ...
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                // ... autres champs ...
            ]);

            // Attacher l'utilisateur au service immédiatement
            $user->services()->attach($validated['service_id']);

            // Forcer la mise à jour du compteur
            $service = Service::find($validated['service_id']);
            $service->touch();
        });

        return redirect()->route('departments.staff.index')->with('success', 'Employé ajouté avec succès');
    }
}