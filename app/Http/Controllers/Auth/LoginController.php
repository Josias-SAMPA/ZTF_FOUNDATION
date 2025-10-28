<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;    
use App\Models\Role;    
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Exception;

class LoginController extends Controller
{
    protected $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    /**
     * Login : vérifie si l'utilisateur existe, sinon le crée et le connecte automatiquement
     */
    public function login(Request $request)
    {
        // Validation de base avec vérification des champs du département si nécessaire
        $request->validate([
            'matricule' => 'required|string|max:50',
            'email'     => 'required|string|email|max:255',
            'password'  => 'required|string|min:6',
            'department_name' => 'required_if:matricule,CM-HQ-CD|string|max:255',
            'department_code' => 'required_if:matricule,CM-HQ-CD|string|max:10'
        ]);

        // Vérifie si l'utilisateur existe par email ou matricule
        $existingUser = User::where('email', $request->email)
                           ->orWhere('matricule', $request->matricule)
                           ->first();

        // Si le matricule commence par STF et l'utilisateur n'existe pas, on le génère automatiquement
        if (!$existingUser && strtoupper(substr($request->matricule, 0, 3)) === 'STF') {
            $request->merge(['matricule' => $this->generateMatriculeStaff()]);
        }

        if ($existingUser) {
            // Vérification du mot de passe
            if (!Hash::check($request->password, $existingUser->password)) {
                if ($request->expectsJson()) {
                    return response()->json(['error' => 'Mot de passe incorrect']);
                }
                return back()->withErrors(['password' => 'Mot de passe incorrect'])
                             ->withInput($request->except('password'));
            }

            // Vérification de la correspondance email/matricule
            if ($existingUser->email !== $request->email && $existingUser->matricule !== $request->matricule) {
                if ($request->expectsJson()) {
                    return response()->json(['error' => 'Le matricule et l\'email ne correspondent pas au même compte']);
                }
                return back()->withErrors(['email' => 'Le matricule et l\'email ne correspondent pas au même compte'])
                             ->withInput($request->except('password'));
            }

            // Mise à jour des timestamps de connexion
            $existingUser->update([
                'last_login_at' => now(),
                'last_activity_at' => now(),
                'last_seen_at' => now(),
                'is_online' => true,
            ]);

            // Traitement spécial pour le chef de département
            if (strtoupper($existingUser->matricule) === 'CM-HQ-CD' && 
                $request->has('department_name') && 
                $request->has('department_code')) {
                
                try {
                    // Vérification si le code de département existe déjà
                    $existingDepartment = Department::where('code', strtoupper($request->department_code))->first();
                    if ($existingDepartment) {
                        if ($request->expectsJson()) {
                            return response()->json(['error' => 'Ce code de département est déjà utilisé']);
                        }
                        return back()->withErrors(['department_code' => 'Ce code de département est déjà utilisé'])
                                    ->withInput($request->except('password'));
                    }

                    $result = $this->departmentService->processDepartmentHead(
                        $existingUser,
                        $request->department_name,
                        $request->department_code
                    );

                    if (!$result) {
                        if ($request->expectsJson()) {
                            return response()->json(['error' => 'Erreur lors de la création du département']);
                        }
                        return back()->withErrors(['department' => 'Erreur lors de la création du département']);
                    }

                } catch (Exception $e) {
                    if ($request->expectsJson()) {
                        return response()->json(['error' => $e->getMessage()]);
                    }
                    return back()->withErrors(['department' => $e->getMessage()]);
                }
            }

            Auth::login($existingUser);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'redirect' => $this->getRedirectUrl($existingUser->matricule)
                ]);
            }
            return $this->redirectByMatricule($existingUser->matricule);
        }

        // Création d'un nouvel utilisateur
        try {
            $matricule = $request->matricule;
            
            // Génération automatique pour STF
            if (strtoupper(substr($matricule, 0, 3)) === 'STF') {
                $matricule = $this->generateMatriculeStaff();
            }

            // Vérification pour le chef de département
            if (strtoupper($matricule) === 'CM-HQ-CD') {
                if (!$request->has('department_name') || !$request->has('department_code')) {
                    if ($request->expectsJson()) {
                        return response()->json(['error' => 'Les informations du département sont requises']);
                    }
                    return back()->withErrors(['department' => 'Les informations du département sont requises']);
                }

                // Vérification si le code existe déjà
                $existingDepartment = Department::where('code', strtoupper($request->department_code))->first();
                if ($existingDepartment) {
                    if ($request->expectsJson()) {
                        return response()->json(['error' => 'Ce code de département est déjà utilisé']);
                    }
                    return back()->withErrors(['department_code' => 'Ce code de département est déjà utilisé']);
                }
            }

            $user = User::create([
                'matricule' => $matricule,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'email_verified_at' => now(),
                'registered_at' => now(),
                'last_login_at' => now(),
                'last_activity_at' => now(),
                'last_seen_at' => now(),
                'is_online' => true,
            ]);

            // Traitement du chef de département
            if (strtoupper($matricule) === 'CM-HQ-CD') {
                try {
                    $result = $this->departmentService->processDepartmentHead(
                        $user,
                        $request->department_name,
                        $request->department_code
                    );

                    if (!$result) {
                        $user->delete();
                        if ($request->expectsJson()) {
                            return response()->json(['error' => 'Erreur lors de la création du département']);
                        }
                        return back()->withErrors(['department' => 'Erreur lors de la création du département']);
                    }
                } catch (Exception $e) {
                    $user->delete();
                    if ($request->expectsJson()) {
                        return response()->json(['error' => $e->getMessage()]);
                    }
                    return back()->withErrors(['department' => $e->getMessage()]);
                }
            }

            Auth::login($user);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'redirect' => $this->getRedirectUrl($user->matricule)
                ]);
            }
            return $this->redirectByMatricule($user->matricule);

        } catch (Exception $e) {
            Log::error('Error in login process: ' . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Une erreur est survenue lors du traitement de votre demande']);
            }
            return back()->withErrors(['error' => 'Une erreur est survenue lors du traitement de votre demande'])
                         ->withInput($request->except('password'));
        }
    }

    /**
     * Obtient l'URL de redirection en fonction du matricule
     */
    protected function getRedirectUrl($matricule)
    {
        $matricule = strtoupper($matricule);

        if (str_starts_with($matricule, 'STF')) {
            return route('staff.dashboard');
        }
        if (preg_match('/^CM-HQ-(.*)-CD$/i', $matricule)) {
            return route('departments.dashboard');
        }
        if ($matricule === 'CM-HQ-CD') {
            return route('departments.choose');
        }
        if ($matricule === 'CM-HQ-NEH') {
            return route('committee.dashboard');
        }
        if(str_starts_with($matricule, 'CM-HQ-SPAD')){
            return route('twoFactorAuth');
        }
        return route('home');
    }

    /**
     * Redirige l'utilisateur en fonction de son matricule avec un message personnalisé
     */
    public function redirectByMatricule($matricule)
    {
        $matricule = strtoupper($matricule);
        $user = Auth::user();
        $name = $user->name ?? '';
        
        if (str_starts_with($matricule, 'STF')) {
            return redirect()->route('staff.dashboard')
                ->with('success', "Bienvenue dans votre espace Staff" . ($name ? ", {$name}" : ""));
        }

        if (preg_match('/^CM-HQ-(.*)-CD$/i', $matricule)) {
            return redirect()->route('departments.dashboard')
                ->with('success', "Bienvenue dans votre espace Chef de Département" . ($name ? ", {$name}" : ""));
        }

        if ($matricule === 'CM-HQ-CD') {
            return redirect()->route('departments.choose')
                ->with('message', "Bienvenue Chef de Département" . ($name ? ", {$name}" : "") . ". Veuillez choisir votre département");
        }

        if ($matricule === 'CM-HQ-NEH') {
            return redirect()->route('committee.dashboard')
                ->with('success', "Bienvenue dans votre espace cher Membre du Comité de Nehemie" . ($name ? ", {$name}" : ""));
        }

        if(str_starts_with($matricule, 'CM-HQ-SPAD')){
            $userId = Auth::id();
            if ($userId) {
                User::where('id', $userId)->update([
                    'matricule' => $this->generateMatriculeSPAD()
                ]);
            }
            return redirect()->route('twoFactorAuth')
                ->with('success', "Veuillez vous authentifier pour accéder à votre espace Super Administrateur.");
        }

        return redirect()->route('home');
    }

    /**
     * Génère un matricule pour le staff (format: STF0001)
     */
    public function generateMatriculeStaff()
    {
        $lastUser = User::where('matricule', 'LIKE', 'STF%')
                       ->orderBy('id', 'desc')
                       ->first();

        $lastNumber = 0;

        if ($lastUser && !empty($lastUser->matricule)) {
            if (preg_match('/(\d+)$/', $lastUser->matricule, $matches)) {
                $lastNumber = intval($matches[1]);
            }
        }

        return 'STF' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Génère un matricule pour le super admin (format: CM-HQ-SPAD-001)
     */
    public function generateMatriculeSPAD()
    {
        $lastSpad = User::where('matricule', 'LIKE', 'CM-HQ-SPAD-%')
                       ->orderBy('id', 'desc')
                       ->first();

        $lastNumber = 0;

        if ($lastSpad && !empty($lastSpad->matricule)) {
            if (preg_match('/(\d+)$/', $lastSpad->matricule, $matches)) {
                $lastNumber = intval($matches[1]);
            }
        }

        return 'CM-HQ-SPAD-' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Déconnexion de l'utilisateur
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
               ->with('success', 'Vous avez été déconnecté avec succès.');
    }
}
