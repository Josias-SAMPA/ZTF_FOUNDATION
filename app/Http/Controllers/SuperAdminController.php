<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Service;
use App\Models\Committee;
use App\Models\Department;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    /**
     * Affiche les statistiques des départements et leurs chefs
     */
    public function departmentStatistics()
    {
        $departments = Department::with(['head' => function($query) {
            $query->select('id', 'name', 'matricule');
        }])
        ->withCount('users')
        ->get();

        return view('departments.statistics', compact('departments'));
    }
    /**
     * Affiche le formulaire d'assignation de chef de département
     */
    public function showAssignHead()
    {
        $departments = Department::with('head')->get();
        $users = User::all();
        
        return view('departments.assign-head', compact('departments', 'users'));
    }

    /**
     * Assigne un chef à un département
     */
    public function assignHead(Request $request)
    {
        
            $request->validate([
                'department_id' => 'required|exists:departments,id',
                'head_id' => 'required|exists:users,id'
            ]);

            \Log::info('Début de l\'assignation du chef de département', [
                'department_id' => $request->department_id,
                'head_id' => $request->head_id
            ]);

            $department = Department::findOrFail($request->department_id);
            $user = User::findOrFail($request->head_id);

            \Log::info('Informations récupérées', [
                'department' => $department->toArray(),
                'user' => $user->toArray()
            ]);

        // Vérifier si l'utilisateur est déjà chef d'un autre département
        $existingHeadDepartment = Department::where('head_id', $user->id)
            ->where('id', '!=', $department->id)
            ->first();

        if ($existingHeadDepartment) {
            return redirect()->back()
                ->with('error', "Cet utilisateur est déjà chef du département '{$existingHeadDepartment->name}'")
                ->withInput();
        }

        \DB::beginTransaction();
        try {
            // Si il y a un ancien chef, nettoyer ses rôles
            if ($department->head_id && $department->head_id !== $user->id) {
                $oldHead = User::find($department->head_id);
                if ($oldHead) {
                    $oldHead->department_id = null;
                    $oldHead->save();
                }
            }

            // Mise à jour du département
            $department->update([
                'head_id' => $user->id,
                'head_assigned_at' => now()
            ]);

            // Mettre à jour le department_id de l'utilisateur
            $user->department_id = $department->id;
            $user->save();

            // Assigner le rôle de chef de département
            $headRole = Role::firstOrCreate(
                ['name' => 'department_head'],
                [
                    'name' => 'department_head',
                    'display_name' => 'Chef de Département',
                    'description' => 'Rôle pour les chefs de département',
                    'guard_name' => 'web',
                    'grade' => 2 // Niveau hiérarchique pour les chefs de département
                ]
            );
            $user->roles()->syncWithoutDetaching([$headRole->id]);

            \DB::commit();
            \Log::info('Assignation réussie', [
                'department' => $department->name,
                'user_matricule' => $user->matricule
            ]);
            return redirect()->back()->with('success', "'{$user->matricule}' a été assigné comme chef du département '{$department->name}'");

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Erreur lors de l\'assignation du chef de département', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'department_id' => $request->department_id,
                'head_id' => $request->head_id
            ]);
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de l\'assignation: ' . $e->getMessage())
                ->withInput();
        }
    }


    /**
     * Retire le chef d'un département
     */
    public function removeHead(Department $department)
    {
        try {
            $oldHead = User::find($department->head_id);
            if ($oldHead) {
                $headRole = Role::where('name', 'department_head')->first();
                if ($headRole) {
                    $oldHead->roles()->detach($headRole->id);
                }
            }

            $department->update([
                'head_id' => null,
                'head_assigned_at' => null
            ]);

            return redirect()->back()->with('success', 'Chef de département retiré avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors du retrait du chef');
        }
    }
    /**
     * Affiche le tableau de bord du super administrateur
     */
    public function dashboard()
    {
        // Statistiques générales
        $totalUsers = User::count();
        $totalDepts = Department::count();
        $totalCom = Committee::count();
        $totalServices = Service::count();
        $listRole = User::with('roles')->get();
        
        
        // Statistiques des rôles et permissions
        $nbreRole = Role::count();
        $nbrePermission = Permission::count();
        
        // Calcul des tendances
        $lastWeekUsers = User::where('created_at', '>=', now()->subWeek())->count();
        $previousWeekUsers = User::whereBetween('created_at', [
            now()->subWeeks(2),
            now()->subWeek()
        ])->count();
        
        $userGrowth = $previousWeekUsers > 0 
            ? round((($lastWeekUsers - $previousWeekUsers) / $previousWeekUsers) * 100)
            : 0;
            
        // Activités récentes
        $recentActivities = User::with(['Departement', 'roles'])
            ->orderBy('last_activity_at', 'desc')
            ->take(10)
            ->get()
            ->map(function($user) {
                $isOnline = $user->last_activity_at ? \Carbon\Carbon::parse($user->last_activity_at)->gt(now()->subMinutes(15)) : false;
                
                return [
                    'user_name' => $user->matricule,
                    'registered_date' => $user->created_at->format('d/m/Y H:i'),
                    'last_update' => $user->info_updated_at ? $user->info_updated_at->format('d/m/Y H:i') : 'Jamais',
                    'last_login' => $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Jamais',
                    'last_seen' => $user->last_activity_at ? $user->last_activity_at->diffForHumans() : 'Jamais',
                    'is_online' => $isOnline,
                    'status' => $isOnline ? 'En ligne' : 'Hors ligne',
                    'status_class' => $isOnline ? 'success' : 'warning'
                ];
            });

        // Statistiques des départements avec leurs chefs
        $departmentsWithStats = Department::with(['head' => function($query) {
            $query->select('id', 'name', 'matricule');
        }])
        ->withCount('users')
        ->get();
        $user = Auth::user();
        
        
        return view('superAdmin.dashboard', compact(
            'totalUsers',
            'totalDepts',
            'totalCom',
            'totalServices',
            'nbreRole',
            'nbrePermission',
            'userGrowth',
            'recentActivities',
            'departmentsWithStats',
            'user'
        ));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {       
            $departments = Department::with('Department_Skills')->get();
            $StaffCounts=[];
            foreach($departments as $department){
                $StaffCounts[$department->id]=User::where('role','users')->where('department_id',$department->id)->count();
            }
            return view('departments.index', [
            'departments' => $departments,
            'Staff_Count' => $StaffCounts,
            'committee' => User::where('role', 'comite')->first(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'required|string|max:5250',
            'head_id'=>'required|string',
        ]);

    Department::create($data);
    return redirect()->route('admin.departments.index')->with('success', 'Département créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    $department = Department::with('Department_Skills')->findOrFail($id);
    return view('departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    $dept_skills = Department::findOrFail($id);
    return view('departments.edit', compact('dept_skills'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'required|string|max:5250',
            'head_id'=>'required|string',
        ]);
        
    $department = Department::findOrFail($id);
    $department->update($data);
    return redirect()->route('admin.departments.index')->with('success', 'Département mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    $department = Department::findOrFail($id);

    $personnelCount=User::where('department_id',$department->id)->where('role','users')->count();
    User::where('department_id',$department->id)->where('role','users')->delete();
    $DepartmentName=$department->name;
    $department->delete();
    return redirect()->route('admin.departments.index')->with('success', "Département {$DepartmentName} avec  supprimé avec succès");
    }

    /**
     * Display a listing of committees
     */
    

    public function listAllUser(){
        $users=User::with('departments','committee')->get();
        return view('superAdmin.listAllUser',compact('users'));
    }

    public function assignUsers(Request $request, Department $department) {
    $validated = $request->validate([
        'users' => 'required|array',
        'users.*' => 'exists:users,id',
    ]);

    $department->users()->sync($validated['users']); // relation many-to-many
    return redirect()->route('departments.index')->with('success', 'Utilisateurs assignés avec succès !');
}

public function assign(Department $department) {
    $users = User::all(); 
    $assignedUsers = $department->users->pluck('id')->toArray();
    return view('departments.indexAddStaff', compact('department', 'users', 'assignedUsers'));
}

public function indexAddStaff(){
    $departments=Department::all();
    return view('departments.quickAction',compact('departments'));
}

}
