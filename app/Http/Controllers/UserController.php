<?php

namespace App\Http\Controllers;


use App\Models\Role;
use App\Models\User;
use App\Models\Service;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="ZTF Foundation API Documentation",
 *     description="API Documentation for ZTF Foundation User Management",
 *     @OA\Contact(
 *         email="admin@ztffoundation.com",
 *         name="ZTF Foundation Team"
 *     )
 * )
 * 
 * @OA\Server(
 *     description="ZTF Foundation API Server",
 *     url=L5_SWAGGER_CONST_HOST
 * )
 */
class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/register",
     *     tags={"Authentication"},
     *     summary="Affiche le formulaire d'inscription final",
     *     description="Retourne la vue du formulaire d'inscription",
     *     @OA\Response(
     *         response=200,
     *         description="Vue du formulaire d'inscription"
     *     )
     * )
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Traite le formulaire d'inscription final
     */


    /**
     * @OA\Get(
     *     path="/users",
     *     tags={"Users"},
     *     summary="Liste tous les utilisateurs",
     *     description="Retourne la liste de tous les utilisateurs avec leurs services et départements",
     *     @OA\Response(
     *         response=200,
     *         description="Liste des utilisateurs récupérée avec succès",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="email", type="string"),
     *                 @OA\Property(property="matricule", type="string"),
     *                 @OA\Property(property="services", type="array", @OA\Items(type="object")),
     *                 @OA\Property(property="departments", type="array", @OA\Items(type="object"))
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isSuperAdmin() || $user->isAdmin1()) {
            $users = User::with('services', 'departments')->get();
        } else {
            // Pour les chefs de département, vérifier le code dans le matricule
            if (preg_match('/^CM-HQ-(.*)-CD$/i', $user->matricule, $matches)) {
                $deptCode = $matches[1];
                $users = User::with('services', 'departments')
                    ->whereHas('departments', function($query) use ($deptCode) {
                        $query->where('code', $deptCode);
                    })
                    ->get();
            } else {
                $users = User::with('services', 'departments')
                    ->where('department_id', $user->department_id)
                    ->get();
            }
        }
        
        return view('staff.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles=Role::all();
        $permissions=Permission::all();
        return view('staff.create',compact('roles','permissions'));
    }

    public function edit(){
        $user = Auth::user();
        return view('profile.edit', compact('user'));
   }

    /**
     * @OA\Put(
     *     path="/users/{user}",
     *     tags={"Users"},
     *     summary="Met à jour les informations d'un utilisateur",
     *     description="Met à jour le matricule, l'email et le mot de passe d'un utilisateur",
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         description="ID de l'utilisateur",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"matricule","email","password"},
     *             @OA\Property(property="matricule", type="string", example="CM-HQ-IT-001"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur mis à jour avec succès"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function update(Request $request , User $user){
        $data=$request->validate([
             
            'matricule' => [
                'required',
                'string',
                'max:255',
                'regex:/^CM-HQ-[a-zA-Z]+-\d{3}$/'
            ],
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'matricule.regex' => "Le matricule doit être au format : CM-HQ-nomdepartement-numerosequentiel (ex: CM-HQ-IT-001)"
        ]);

        // Utilisez l'instance de User passée en paramètre au lieu de créer une nouvelle
        $user->update($data);
        return redirect(route('users.update'));
    }
    /**
     * @OA\Delete(
     *     path="/users/{user}",
     *     tags={"Users"},
     *     summary="Supprime un utilisateur",
     *     description="Supprime définitivement un utilisateur de la base de données",
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         description="ID de l'utilisateur à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur supprimé avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Utilisateur non trouvé"
     *     )
     * )
     */
    public function destroy(User $user)
    {
        $sexe = $user->sexe == 'M' ? 'Mr' : 'Mme';
        $user->delete();
        return redirect()->route('staff.index')->with('success', "$sexe {$user->name} {$user->surname} supprimé avec succès");
    }

    /**
     * Supprime un utilisateur spécifique (pour le committee)
     */
    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Supprimer le formulaire HQ associé s'il existe
            if ($user->hqStaffForm) {
                $user->hqStaffForm->delete();
            }
            
            // Supprimer les fichiers associés
            if ($user->hqStaffForm) {
                $files = [
                    $user->hqStaffForm->bulletin3_path,
                    $user->hqStaffForm->medical_certificate_path,
                    $user->hqStaffForm->diplomas_path,
                    $user->hqStaffForm->birth_marriage_certificates_path,
                    $user->hqStaffForm->cni_path,
                    $user->hqStaffForm->family_commitment_path,
                    $user->hqStaffForm->family_burial_agreement_path
                ];

                foreach ($files as $file) {
                    if ($file) {
                        Storage::delete($file);
                    }
                }
            }

            // Supprimer l'utilisateur
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'Utilisateur supprimé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression de l\'utilisateur: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/getAllUsers",
     *     tags={"Users"},
     *     summary="Récupère tous les utilisateurs",
     *     description="Retourne la liste de tous les utilisateurs",
     *     @OA\Response(
     *         response=200,
     *         description="Liste des utilisateurs récupérée avec succès"
     *     )
     * )
     */
    public function getAllUsers() {
        try {
            $users = User::all();
            return response()->json([
                'status' => 'success',
                'data' => $users
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Affiche le tableau de bord du staff avec toutes les informations pertinentes
     * 
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Charger les relations nécessaires
        $user->load(['roles', 'Departement', 'service']);

        // Récupérer les statistiques de l'utilisateur
        $stats = [
            'last_login' => $user->last_login_at,
            'created_at' => $user->created_at,
            'info_updated_at' => $user->info_updated_at,
            'last_activity_at' => $user->last_activity_at,
            'is_online' => $user->last_activity_at && $user->last_activity_at->gt(now()->subMinutes(15))
        ];

        // Récupérer le rôle actif
        $activeRole = $user->roles->first();

        return view('staff.dashboard', [
            'user' => $user,
            'stats' => $stats,
            'activeRole' => $activeRole,
            'departement' => $user->Departement,
            'service' => $user->service
        ]);
    }

    public function assignRoleFromMatricule(User $user){
        $this->syncRoleFromMatricule($user);
        return back()->with('success',"Role a ete assigne automatiquement a  {$user->name} avec succes");
    }

    /**
     * Synchronise le rôle de l'utilisateur en fonction de son matricule
     */
    private function syncRoleFromMatricule(User $user)
    {
        // Pour les chefs de département (CD)
        if (preg_match('/^CM-HQ-(.*)-CD$/i', $user->matricule)) {
            $role = Role::where('name', 'Chef de Département')->first();
            if (!$role) {
                $role = Role::create([
                    'name'=>'department-head',
                    'display_name'=>'Chef de Département',
                    'description'=>'Role pour les chefs de département',
                    'guard_name'=>'web',
                    'grade'=>2
                ]);
            }
            $user->roles()->sync([$role->id]);
        }
        // Pour les employés normaux
        elseif (preg_match('/^CM-HQ-[A-Za-z]+-\d{3}$/i', $user->matricule)) {
            $role = Role::where('name', 'Employé')->first();
            if (!$role) {
                $role = Role::create([
                    'name'=>'Employe',
                    'display_name'=>'Ouvrier',
                    'description'=>'Role par defaut pour les employes',
                    'guard_name'=>'web',
                ]);
            }
            $user->roles()->sync([$role->id]);
        }
    }
}
