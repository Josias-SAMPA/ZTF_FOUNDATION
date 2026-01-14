<?php

namespace App\Http\Controllers\Committee;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;

/**
 * ManageUsersController
 * 
 * Gère l'affectation des utilisateurs aux départements
 * - Récupération des utilisateurs non affectés
 * - Formulaire d'affectation
 * - Validation et enregistrement des affectations
 */
class ManageUsersController extends Controller
{
    /**
     * Affiche la liste des utilisateurs non assignés à un département
     * 
     * Récupère tous les utilisateurs n'ayant aucune relation dans la table pivot department_user
     * Triés par nom et paginés
     *
     * @return \Illuminate\View\View
     */
    public function indexUnAssigned()
    {
        // Récupérer les utilisateurs sans département, triés par nom, avec pagination
        $users = User::whereDoesntHave('departments')
            ->orderBy('name', 'asc')
            ->paginate(15);

        // Récupérer aussi le nombre total d'utilisateurs non affectés
        $totalUnassigned = User::whereDoesntHave('departments')->count();
        $totalAssigned = User::has('departments')->count();

        return view('committee.assignments.index', compact('users', 'totalUnassigned', 'totalAssigned'));
    }

    /**
     * Affiche le formulaire d'affectation pour un utilisateur spécifique
     * 
     * Récupère l'utilisateur et la liste complète des départements
     * Affiche les informations de l'utilisateur et les checkboxes des départements
     *
     * @param int $userId L'ID de l'utilisateur
     * @return \Illuminate\View\View
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function assignForm($userId)
    {
        // Récupérer l'utilisateur, sinon lever une exception 404
        $user = User::findOrFail($userId);

        // Vérifier que l'utilisateur n'est pas déjà affecté
        if ($user->departments()->exists()) {
            return redirect()
                ->route('committee.assignments.index')
                ->with('error', "L'utilisateur {$user->name} est déjà affecté à un département.");
        }

        // Récupérer tous les départements, triés par nom
        $departments = Department::orderBy('name', 'asc')->get();

        return view('committee.assignments.form', compact('user', 'departments'));
    }

    /**
     * Affecte un utilisateur à un ou plusieurs départements
     * 
     * Valide la requête, enregistre l'affectation via syncWithoutDetaching()
     * et redirige avec un message de succès
     *
     * @param \Illuminate\Http\Request $request
     * @param int $userId L'ID de l'utilisateur
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assignUserToDepartment(Request $request, $userId)
    {
        // Valider les données de la requête
        $validated = $request->validate([
            'departments' => 'required|array|min:1',
            'departments.*' => 'exists:departments,id'
        ], [
            'departments.required' => 'Vous devez sélectionner au moins un département.',
            'departments.array' => 'Les départements doivent être fournis sous forme de tableau.',
            'departments.min' => 'Vous devez sélectionner au moins un département.',
            'departments.*.exists' => 'Un ou plusieurs départements sélectionnés n\'existent pas.'
        ]);

        // Récupérer l'utilisateur, sinon lever une exception 404
        $user = User::findOrFail($userId);

        // Récupérer les noms des départements sélectionnés
        $departments = Department::whereIn('id', $validated['departments'])
            ->orderBy('name', 'asc')
            ->get();

        $departmentNames = $departments->pluck('name')->implode(', ');

        // Enregistrer l'affectation via syncWithoutDetaching (ne supprime pas les relations existantes)
        $user->departments()->syncWithoutDetaching($validated['departments']);

        // Préparer le message de succès
        $message = $departments->count() === 1 
            ? "L'utilisateur {$user->name} a été affecté avec succès au département {$departmentNames}."
            : "L'utilisateur {$user->name} a été affecté avec succès aux départements : {$departmentNames}.";

        // Rediriger vers la liste avec un message de succès
        return redirect()
            ->route('committee.assignments.index')
            ->with('success', $message);
    }

    /**
     * Optionnel : Sélectionner plusieurs utilisateurs et les affecter en masse
     * 
     * Cette méthode permet une affectation en masse via des checkboxes
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assignMultiple(Request $request)
    {
        // Valider les données
        $validated = $request->validate([
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id',
            'departments' => 'required|array|min:1',
            'departments.*' => 'exists:departments,id'
        ], [
            'user_ids.required' => 'Vous devez sélectionner au moins un utilisateur.',
            'user_ids.min' => 'Vous devez sélectionner au moins un utilisateur.',
            'departments.required' => 'Vous devez sélectionner au moins un département.',
            'departments.min' => 'Vous devez sélectionner au moins un département.'
        ]);

        // Récupérer les utilisateurs
        $users = User::whereIn('id', $validated['user_ids'])->get();

        // Affecter tous les utilisateurs aux départements sélectionnés
        foreach ($users as $user) {
            $user->departments()->syncWithoutDetaching($validated['departments']);
        }

        // Récupérer les noms des départements
        $departmentNames = Department::whereIn('id', $validated['departments'])
            ->pluck('name')
            ->implode(', ');

        $message = count($validated['user_ids']) === 1
            ? "1 utilisateur a été affecté avec succès aux départements : {$departmentNames}."
            : count($validated['user_ids']) . " utilisateurs ont été affectés avec succès aux départements : {$departmentNames}.";

        return redirect()
            ->route('committee.assignments.index')
            ->with('success', $message);
    }
}
