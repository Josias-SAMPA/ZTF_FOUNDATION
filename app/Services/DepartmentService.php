<?php

namespace App\Services;

use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;

class DepartmentService
{
    public function validateDepartment(string $name, string $code): array
    {
        $code = strtoupper($code);
        
        // Vérifier si le code de département existe déjà
        $existingDepartment = Department::where('code', $code)->first();
        if ($existingDepartment) {
            return ['error' => 'Ce code de département est déjà utilisé'];
        }

        // Vérifier si un chef existe déjà pour ce département
        $existingHead = User::where('matricule', "CM-HQ-{$code}-CD")->first();
        if ($existingHead) {
            return ['error' => 'Un chef est déjà assigné à ce département'];
        }

        return ['success' => true];
    }

    public function processDepartmentHead(User $user, string $name, string $code): bool
    {
        try {
            DB::beginTransaction();

            // Créer ou récupérer le rôle "Chef de Département"
            $role = Role::firstOrCreate(
                ['name' => 'department-head'],
                [
                    'display_name' => 'Chef de Département',
                    'description' => 'Responsable de la gestion et de la supervision du département',
                    'guard_name' => 'web',
                    'grade' => 2,
                    'Code' => strtoupper($code)
                ]
            );

            // Créer le département
            $department = Department::create([
                'name' => $name,
                'code' => strtoupper($code),
                'description' => 'Département ' . $name . ' - ' . strtoupper($code)
            ]);

            // Mettre à jour l'utilisateur
            $user->update([
                'matricule' => "CM-HQ-{$code}-CD",
                'department_id' => $department->id
            ]);

            // Assigner le rôle
            $user->roles()->syncWithoutDetaching([$role->id]);

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}