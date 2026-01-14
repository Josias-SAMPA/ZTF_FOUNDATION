<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Service;
use App\Models\Committee;
use App\Models\Department;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComiteController extends Controller
{
    public function dashboard()
    {
        \Log::info('ComiteController@dashboard called');
        \Log::info('User: ' . Auth::user()->matricule);

        // Statistiques globales
        $totalDepts = Department::count();
        $totalUsers = User::where('matricule', 'NOT LIKE', 'SPAD-%')->count();
        $totalServices = Service::count();

        //Nombre de Role et Permission
        $nbreRole = Role::count();
        $nbrePermission = Permission::count();

        // Statistiques des utilisateurs
        $lastWeekUsers = User::where('created_at', '>=', now()->subWeek())->count();
        $previousWeekUsers = User::whereBetween('created_at', [
            now()->subWeeks(2),
            now()->subWeek()
        ])->count();
        
        $userGrowth = $previousWeekUsers > 0 
            ? round((($lastWeekUsers - $previousWeekUsers) / $previousWeekUsers) * 100)
            : 0;
            
        // Activités récentes
        $recentActivities = User::with(['department', 'roles'])
            ->orderBy('last_activity_at', 'desc')
            ->get()
            ->map(function($user) {
                // Vérifier si l'utilisateur est actuellement connecté
                $isOnline = $user->is_online === true;
                
                return [
                    'user_name' => $user->matricule,
                    'created_at' => $user->created_at->format('d/m/Y H:i:s'),
                    'last_update' => $user->info_updated_at ? $user->info_updated_at->format('d/m/Y H:i') : 'Jamais',
                    'last_login' => $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Jamais',
                    'last_seen' => $user->last_activity_at ? $user->last_activity_at->diffForHumans() : 'Jamais',
                    'is_online' => $isOnline,
                    'status' => $isOnline ? 'En ligne' : 'Hors ligne',
                    'status_class' => $isOnline ? 'success' : 'danger',
                ];
            });

        // Récupérer tous les départements avec leurs statistiques
        $departments = Department::with(['head', 'services', 'users'])
            ->withCount(['users', 'services'])
            ->get();
            
        $user = Auth::user();
        
        // Récupérer l'historique des PDFs des départements
        $departmentPdfs = collect(Storage::files('public/pdfs/departments'))
            ->filter(function($file) {
                return pathinfo($file, PATHINFO_EXTENSION) === 'pdf';
            })
            ->sortByDesc(function($file) {
                return Storage::lastModified($file);
            })
            ->values()
            ->all();

        return view('committee.dashboard', compact(
            'totalUsers',
            'totalDepts',
            'totalServices',
            'nbreRole',
            'nbrePermission',
            'userGrowth',
            'recentActivities',
            'departments', // Changed from departmentsWithStats
            'user',
            'departmentPdfs'
        ));
    }

    /**
     * Affiche la page de gestion des départements
     * Récupère les chefs nouvellement enregistrés avec leurs départements et rôles
     * 
     * @return \Illuminate\View\View
     */
    public function manage()
    {
        // Récupérer les chefs nouvellement enregistrés (matricule format CM-HQ-XXX-CD)
        // avec leurs départements, services, utilisateurs et rôles
        $departments = Department::with([
            'head' => function($query) {
                $query->with('roles'); // Charger les rôles du chef
            },
            'services',
            'services.users'
        ])
        ->withCount(['users', 'services'])
        ->get();

        // Récupérer les utilisateurs disponibles pour être chef de département
        // Exclure ceux qui sont déjà chefs d'un département
        $availableUsers = User::whereDoesntHave('head')
                            ->where(function($query) {
                                // Inclure seulement les chefs potentiels (matricule CD ou sans département assigné)
                                $query->whereRaw("matricule LIKE 'CM-HQ-%-CD'")
                                      ->orWhereNull('department_id');
                            })
                            ->orderBy('name')
                            ->get();

        return view('committee.departments.manage', compact('departments', 'availableUsers'));
    }

    public function serviceIndex()
    {
        $user = Auth::user();
        $services = Service::with(['department', 'users']);

        if ($user->isSuperAdmin() || $user->isAdmin1()) {
            $services = $services->get();
        } else {
            // Pour les chefs de département, vérifier le code dans le matricule
            if (preg_match('/^CM-HQ-(.*)-CD$/i', $user->matricule, $matches)) {
                $deptCode = $matches[1];
                $services = $services->whereHas('department', function($query) use ($deptCode) {
                    $query->where('code', $deptCode);
                })->get();
            } else {
                $services = $services->where('department_id', $user->department_id)->get();
            }
        }

        return view('committee.services.index', compact('services'));
    }

    /**
     * Affiche le formulaire de création d'un service
     */
    public function serviceCreate()
    {
        $user = Auth::user();
        $departments = [];

        if ($user->isSuperAdmin() || $user->isAdmin1()) {
            $departments = Department::all();
        } else {
            // Pour les chefs de département
            if (preg_match('/^CM-HQ-(.*)-CD$/i', $user->matricule, $matches)) {
                $deptCode = $matches[1];
                $departments = Department::where('code', $deptCode)->get();
            } elseif ($user->department_id) {
                $departments = Department::where('id', $user->department_id)->get();
            }
        }

        return view('committee.services.create', compact('departments'));
    }

    /**
     * Enregistre un nouveau service
     */
    public function serviceStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'department_id' => 'required|exists:departments,id'
        ]);

        $service = Service::create($validated);

        return redirect()->route('committee.services.index')
            ->with('success', 'Le service a été créé avec succès.');
    }


    public function index()
    {
        $members = User::where('matricule', 'CM-HQ-NEH')
            ->withCount(['roles', 'permissions'])
            ->get();

        $totalMembers = $members->count();
        $activeMembers = $members->filter(function($member) {
            return $member->last_activity_at && 
                   \Carbon\Carbon::parse($member->last_activity_at)->gt(now()->subDays(30));
        })->count();
        $onlineMembers = $members->filter(function($member) {
            return $member->is_online;
        })->count();

        return view('committee.index', compact(
            'members',
            'totalMembers',
            'activeMembers',
            'onlineMembers'
        ));
    }

    /**
     * Affiche le formulaire de création d'un nouveau membre du comité
     */
    public function create()
    {
        // Récupérer les rôles disponibles pour le comité
        $roles = Role::where('grade', 1)->get();

        // Récupérer les départements disponibles
        $departments = Department::all();

        return view('committee.create', compact('roles', 'departments'));
    }

    /**
     * Enregistre un nouveau membre du comité
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'department_id' => 'nullable|exists:departments,id',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id'
        ]);

        // Créer le nouvel utilisateur avec le matricule du comité
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'matricule' => 'CM-HQ-NEH',
            'department_id' => $validated['department_id'],
            'email_verified_at' => now(),
            'registered_at' => now(),
            'last_login_at' => now(),
            'last_activity_at' => now(),
            'last_seen_at' => now(),
            'is_online' => true
        ]);

        // Assigner les rôles sélectionnés
        if (!empty($validated['roles'])) {
            $user->roles()->attach($validated['roles']);
        }

        return redirect()->route('committee.index')
            ->with('success', 'Le nouveau membre du comité a été créé avec succès.');
    }

    /**
     * Affiche les détails d'un membre du comité
     */
    public function show(User $member)
    {
        // Vérifier que l'utilisateur est bien un membre du comité
        if ($member->matricule !== 'CM-HQ-NEH') {
            abort(404);
        }

        // Charger les relations nécessaires
        $member->load(['roles', 'permissions', 'department']);

        // Récupérer l'historique des activités
        $activities = [
            'last_login' => $member->last_login_at ? $member->last_login_at->format('d/m/Y H:i') : 'Jamais',
            'last_seen' => $member->last_activity_at ? $member->last_activity_at->diffForHumans() : 'Jamais',
            'registered_at' => $member->registered_at->format('d/m/Y'),
            'email_verified' => $member->email_verified_at ? 'Oui' : 'Non'
        ];

        return view('committee.show', compact('member', 'activities'));
    }

    /**
     * Affiche le formulaire d'édition d'un membre du comité
     */
    public function edit(User $member)
    {
        // Vérifier que l'utilisateur est bien un membre du comité
        if ($member->matricule !== 'CM-HQ-NEH') {
            abort(404);
        }

        // Récupérer les rôles et départements disponibles
        $roles = Role::where('grade', 1)->get();
        $departments = Department::all();

        // Récupérer les IDs des rôles actuels
        $currentRoles = $member->roles->pluck('id')->toArray();

        return view('committee.edit', compact('member', 'roles', 'departments', 'currentRoles'));
    }

    /**
     * Met à jour les informations d'un membre du comité
     */
    public function update(Request $request, User $member)
    {
        // Vérifier que l'utilisateur est bien un membre du comité
        if ($member->matricule !== 'CM-HQ-NEH') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $member->id,
            'password' => 'nullable|string|min:8|confirmed',
            'department_id' => 'nullable|exists:departments,id',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id'
        ]);

        // Mettre à jour les informations de base
        $member->name = $validated['name'];
        $member->email = $validated['email'];
        $member->department_id = $validated['department_id'];
        
        // Mettre à jour le mot de passe si fourni
        if (!empty($validated['password'])) {
            $member->password = bcrypt($validated['password']);
        }

        $member->save();

        // Mettre à jour les rôles
        $member->roles()->sync($validated['roles']);

        return redirect()->route('committee.show', $member)
            ->with('success', 'Les informations du membre ont été mises à jour avec succès.');
    }

    /**
     * Supprime un membre du comité
     */
    public function destroy(User $member)
    {
        // Vérifier que l'utilisateur est bien un membre du comité
        if ($member->matricule !== 'CM-HQ-NEH') {
            abort(404);
        }

        // Détacher tous les rôles avant la suppression
        $member->roles()->detach();
        
        // Supprimer le membre
        $member->delete();

        return redirect()->route('committee.index')
            ->with('success', 'Le membre du comité a été supprimé avec succès.');
    }

    /**
     * Affiche la liste des services
     */
    public function services()
    {
        // Récupérer tous les services avec leurs départements et utilisateurs
        $services = Service::with(['department', 'users', 'users.roles'])
            ->orderBy('department_id')
            ->orderBy('name')
            ->get()
            ->groupBy('department.name');

        return view('committee.service.services', [
            'services' => $services,
            'totalServices' => Service::count(),
            'totalDepartments' => Department::count(),
            'totalEmployees' => User::count()
        ]);
    }

    /**
     * Récupère la liste des chefs de département avec leurs détails
     * Inclut le chef, son département et ses rôles assignés en base de données
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getHeadsWithDetails()
    {
        $heads = User::whereHas('head')
            ->with([
                'head' => function($query) {
                    $query->select('id', 'name', 'code', 'description', 'head_id');
                },
                'roles' => function($query) {
                    $query->select('roles.id', 'roles.name', 'roles.code', 'roles.display_name', 'roles.grade');
                }
            ])
            ->where(function($query) {
                $query->whereRaw("matricule LIKE 'CM-HQ-%-CD'");
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'matricule' => $user->matricule,
                    'department' => $user->head()->first(),
                    'roles' => $user->roles,
                    'created_at' => $user->created_at,
                    'is_active' => $user->is_active,
                ];
            });

        return $heads;
    }

    /**
     * Génère un PDF avec la liste des départements et leurs chefs
     * Inclut maintenant les rôles assignés aux chefs
     */
    public function generateDepartmentsHeadsPdf()
    {
        $departments = Department::with([
            'head' => function($query) {
                $query->with('roles');
            }
        ])->get();
        
        $pdf = \PDF::loadView('committee.pdfs.departments-heads', compact('departments'));
        
        // Sauvegarder le PDF dans le stockage
        $fileName = 'departments-heads-' . now()->format('Y-m-d') . '.pdf';
        Storage::put('public/pdfs/departments/' . $fileName, $pdf->output());
        
        return $pdf->download($fileName);
    }

    /**
     * Génère un PDF avec la liste des départements, leurs chefs et services
     * Inclut maintenant les rôles assignés aux chefs
     */
    public function generateDepartmentsHeadsServicesPdf()
    {
        $departments = Department::with([
            'head' => function($query) {
                $query->with('roles');
            },
            'services'
        ])->get();
        
        $pdf = \PDF::loadView('committee.pdfs.departments-heads-services', compact('departments'));
        
        // Sauvegarder le PDF dans le stockage
        $fileName = 'departments-heads-services-' . now()->format('Y-m-d') . '.pdf';
        Storage::put('public/pdfs/departments/' . $fileName, $pdf->output());
        
        return $pdf->download($fileName);
    }

    /**
     * Génère un PDF avec la liste complète des employés par département
     */
    public function generateDepartmentsEmployeesPdf()
    {
        $departments = Department::with(['users' => function ($query) {
            $query->orderBy('name');
        }])->get();
        
        $pdf = \PDF::loadView('committee.pdfs.departments-employees', compact('departments'));
        
        // Sauvegarder le PDF dans le stockage
        $fileName = 'departments-employees-' . now()->format('Y-m-d') . '.pdf';
        Storage::put('public/pdfs/departments/' . $fileName, $pdf->output());
        
        return $pdf->download($fileName);
    }
}