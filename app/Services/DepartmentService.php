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

            // Créer le rôle "Chef de Département" s'il n'existe pas
            $role = Role::firstOrCreate(
                ['code' => 'CD'],
                [
                    'name' => 'department-head',
                    'display_name' => 'Chef de Département',
                    'description' => 'Responsable de la gestion et de la supervision du département',
                    'guard_name' => 'web',
                    'grade' => 2
                ]
            );

            // Créer le département
            $department = Department::create([
                'name' => $name,
                'code' => strtoupper($code),
                'description' => 'Département ' . $name . ' - ' . strtoupper($code),
                'head_id' => $user->id,
                'head_assigned_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Assigner le rôle "Chef de Département" à l'utilisateur
            if ($role && !$user->roles()->where('code', 'CD')->exists()) {
                $user->roles()->attach($role->id);
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}