<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;

class ServiceUserController extends Controller
{
    /**
     * Get all unassigned users for a service
     */
    public function getUnassignedUsers(Department $department, Service $service)
    {
        try {
            // Vérifier que le service appartient bien au département
            if ($service->department_id !== $department->id) {
                \Log::error('Tentative d\'accès à un service qui n\'appartient pas au département', [
                    'department_id' => $department->id,
                    'service_id' => $service->id
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Le service n\'appartient pas à ce département'
                ], 403);
            }

            // Récupérer les utilisateurs du département qui ne sont pas affectés à ce service
            $unassignedUsers = User::whereHas('department', function($query) use ($department) {
                $query->where('id', $department->id);
            })->whereDoesntHave('services', function($query) use ($service) {
                $query->where('services.id', $service->id);
            })->get(['id', 'name', 'email', 'matricule']);

            \Log::info('Récupération des utilisateurs non affectés réussie', [
                'department_id' => $department->id,
                'service_id' => $service->id,
                'count' => $unassignedUsers->count()
            ]);

            return response()->json([
                'success' => true,
                'users' => $unassignedUsers
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la récupération des utilisateurs non affectés', [
                'department_id' => $department->id,
                'service_id' => $service->id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la récupération des utilisateurs'
            ], 500);
        }
    }

    /**
     * Assign users to a service
     */
    public function assignUsers(Request $request, Department $department, Service $service)
    {
        $request->validate([
            'users' => 'required|array',
            'users.*' => 'exists:users,id'
        ]);

        try {
            // Créer un tableau avec les timestamps pour chaque utilisateur
            $usersWithTimestamps = [];
            foreach ($request->users as $userId) {
                $usersWithTimestamps[$userId] = [
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            // Attacher les utilisateurs avec les timestamps
            $service->users()->attach($usersWithTimestamps);

            // Rafraîchir les compteurs du service
            $service->refresh();

            return response()->json([
                'success' => true,
                'message' => 'Employés affectés avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'affectation des employés'
            ], 500);
        }
    }
}