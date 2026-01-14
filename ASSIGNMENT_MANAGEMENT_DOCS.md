# 🎯 Documentation Complète - Gestion des Affectations d'Utilisateurs aux Départements

## 📋 Vue d'ensemble

Cette fonctionnalité permet de gérer l'affectation des utilisateurs (ouvriers) à un ou plusieurs départements via une interface web intuitive et moderne.

---

## 🏗️ Architecture

### 1️⃣ Contrôleur : `ManageUsersController`
**Emplacement** : `app/Http/Controllers/Committee/ManageUsersController.php`

#### Méthodes principales :

##### `indexUnAssigned()` 
- **Description** : Affiche la liste des utilisateurs non affectés à un département
- **Logique** : 
  - Récupère tous les utilisateurs n'ayant aucune relation dans la table pivot `department_user`
  - Tri par nom (ordre alphabétique)
  - Pagination (15 utilisateurs par page)
  - Récupère aussi les stats (total non affectés vs affectés)
- **Vue retournée** : `committee.assignments.index`
- **Variables** : `$users`, `$totalUnassigned`, `$totalAssigned`

##### `assignForm($userId)`
- **Description** : Affiche le formulaire d'affectation pour un utilisateur spécifique
- **Logique** :
  - Vérifie que l'utilisateur existe (404 si absent)
  - Vérifie que l'utilisateur n'est pas déjà affecté (redirection si affecté)
  - Récupère tous les départements disponibles, triés par nom
- **Vue retournée** : `committee.assignments.form`
- **Variables** : `$user`, `$departments`
- **Exceptions** : `ModelNotFoundException` (404)

##### `assignUserToDepartment(Request $request, $userId)`
- **Description** : Valide et enregistre l'affectation d'un utilisateur aux départements
- **Validation** :
  ```php
  'departments' => 'required|array|min:1',
  'departments.*' => 'exists:departments,id'
  ```
- **Logique** :
  - Valide les données entrantes
  - Récupère l'utilisateur (404 si absent)
  - Récupère les noms des départements sélectionnés
  - Enregistre l'affectation via `syncWithoutDetaching()` (ne supprime pas les relations existantes)
  - Crée un message de succès personnalisé (singulier/pluriel)
  - Redirige vers la liste avec message flash
- **Messages** :
  - Singulier : "L'utilisateur {nom} a été affecté avec succès au département {departement}."
  - Pluriel : "L'utilisateur {nom} a été affecté avec succès aux départements : {dept1}, {dept2}, ..."
- **Redirection** : `route('committee.assignments.index')` avec message flash

##### `assignMultiple(Request $request)` ⭐ **OPTIONNEL**
- **Description** : Affecte plusieurs utilisateurs en masse aux mêmes départements
- **Validation** :
  ```php
  'user_ids' => 'required|array|min:1',
  'user_ids.*' => 'exists:users,id',
  'departments' => 'required|array|min:1',
  'departments.*' => 'exists:departments,id'
  ```
- **Cas d'usage** : Sélectionner 5 utilisateurs et les affecter à 2 départements à la fois
- **Notes** : À appeler depuis une vue améliorée avec checkboxes de sélection

---

### 2️⃣ Routes Web
**Emplacement** : `routes/web.php`

```php
Route::prefix('committee')->name('committee.')->middleware(['auth', 'verified'])->group(function () {
    // Routes pour les affectations d'utilisateurs aux départements
    Route::prefix('assignments')->name('assignments.')->group(function() {
        Route::get('/', [ManageUsersController::class, 'indexUnAssigned'])->name('index');
        Route::get('/user/{userId}', [ManageUsersController::class, 'assignForm'])->name('form');
        Route::post('/user/{userId}', [ManageUsersController::class, 'assignUserToDepartment'])->name('store');
    });
});
```

**Routes générées** :
- `GET  /committee/assignments` → `committee.assignments.index` (Liste)
- `GET  /committee/assignments/user/{userId}` → `committee.assignments.form` (Formulaire)
- `POST /committee/assignments/user/{userId}` → `committee.assignments.store` (Traitement)

---

### 3️⃣ Modèles
**Emplacement** : `app/Models/`

#### User Model
```php
// Relation many-to-many
public function departments()
{
    return $this->belongsToMany(Department::class, 'department_user')
                ->withTimestamps();
}
```

#### Department Model
```php
// Relation many-to-many
public function users()
{
    return $this->belongsToMany(User::class, 'department_user')
                ->withTimestamps();
}
```

---

### 4️⃣ Table Pivot
**Table** : `department_user`

**Colonnes** :
```
- id (primary)
- user_id (foreign -> users.id)
- department_id (foreign -> departments.id)
- created_at
- updated_at
```

**Migration** : À exécuter via `php artisan migrate`

---

### 5️⃣ Vues Blade

#### Index View : `resources/views/committee/assignments/index.blade.php`
- **Affiche** :
  - Statistiques : Utilisateurs non affectés / Affectés
  - Messages flash (succès/erreur)
  - Tableau des utilisateurs non affectés
  - Bouton "Affecter" pour chaque utilisateur
  - Pagination (15 par page)
  - Empty state si tous les utilisateurs sont affectés

- **Structure** :
  ```html
  [Page Header]
    - Titre "Gestion des Affectations"
    - Breadcrumb
    
  [Stats Grid]
    - Carte 1 : Nombre d'utilisateurs non affectés
    - Carte 2 : Nombre d'utilisateurs affectés
    
  [Alerts]
    - Messages flash flash (succès/erreur)
    
  [Main Card]
    - Liste des utilisateurs avec avatar, nom, matricule, email, rôle
    - Bouton "Affecter" pour chaque ligne
    - Pagination sous le tableau
    - Empty state si aucun utilisateur non affecté
  ```

#### Form View : `resources/views/committee/assignments/form.blade.php`
- **Affiche** :
  - Bouton "Retour aux affectations"
  - Titre et breadcrumb
  - Messages flash
  - Carte avec infos de l'utilisateur (nom, matricule, email)
  - Formulaire avec checkboxes pour sélectionner les départements
  - Boutons d'action (Affecter / Annuler)

- **Structure** :
  ```html
  [Page Header]
    - Bouton retour
    - Titre "Affecter un Ouvrier aux Départements"
    - Breadcrumb
    
  [Alerts]
    - Messages flash
    - Erreurs de validation
    
  [User Info Card]
    - Nom, Matricule, Email
    
  [Assignment Form Card]
    - Grille de checkboxes (multisélection)
    - Chaque département affichable avec son code
    - Checkboxes stylisés
    - Boutons Affecter / Annuler
  ```

---

### 6️⃣ Feuille de Style
**Emplacement** : `public/css/assignments.css`

**Thème** :
- Gradient bleu : `linear-gradient(135deg, #3b82f6, #2563eb)`
- Couleurs cohérentes avec le dashboard
- Responsive (mobile, tablette, desktop)
- Animations et transitions lisses

**Composants stylisés** :
- Statistiques cards
- User items avec avatar
- Checkboxes custom
- Buttons (primary, secondary, danger)
- Alerts (success, danger)
- Empty state
- Pagination

---

## 🔄 Flux d'utilisation

```
1. Admin accède à /committee/assignments
   ↓
2. Voir la liste des utilisateurs non affectés
   ↓
3. Cliquer sur "Affecter" pour un utilisateur
   ↓
4. Voir le formulaire avec checkboxes des départements
   ↓
5. Sélectionner 1 ou plusieurs départements
   ↓
6. Cliquer sur "Affecter l'Ouvrier"
   ↓
7. Validation serveur (required, array, exists)
   ↓
8. Enregistrement via syncWithoutDetaching()
   ↓
9. Redirection avec message de succès
   ↓
10. L'utilisateur n'apparaît plus dans la liste
```

---

## 🛡️ Validation et Sécurité

### Validation serveur :
```php
'departments' => 'required|array|min:1',
'departments.*' => 'exists:departments,id'
```

- **required** : Au moins un département doit être sélectionné
- **array** : Doit être un tableau
- **min:1** : Au minimum 1 élément
- **exists:departments,id** : Chaque ID doit exister dans la table departments

### Messages d'erreur personnalisés :
- "Vous devez sélectionner au moins un département."
- "Les départements doivent être fournis sous forme de tableau."
- "Un ou plusieurs départements sélectionnés n'existent pas."

---

## 📊 Relation Many-to-Many

### Table Pivot : `department_user`
```
┌─────────────────────────────────────┐
│        department_user              │
├─────────────────────────────────────┤
│ id (PK)          │ BIGINT UNSIGNED  │
│ user_id (FK)     │ BIGINT UNSIGNED  │
│ department_id(FK)│ BIGINT UNSIGNED  │
│ created_at       │ TIMESTAMP        │
│ updated_at       │ TIMESTAMP        │
└─────────────────────────────────────┘
```

### Méthode de synchronisation :
```php
$user->departments()->syncWithoutDetaching($departmentIds);
```
- Ne supprime pas les relations existantes
- Ajoute les nouvelles
- Idempotent (appel multiple = même résultat)

---

## 🚀 Cas d'usage et exemples

### Cas 1 : Affecter un utilisateur à un département
```php
$user = User::find(1);
$user->departments()->syncWithoutDetaching([2]); // Affecte à dept ID 2
```

### Cas 2 : Affecter à plusieurs départements
```php
$user->departments()->syncWithoutDetaching([2, 3, 5]); // Affecte à 3 depts
```

### Cas 3 : Récupérer les départements d'un utilisateur
```php
$departments = $user->departments()->get();
foreach ($departments as $dept) {
    echo $dept->name; // Accès aux données du département
}
```

### Cas 4 : Vérifier si un utilisateur est non affecté
```php
$unassigned = User::whereDoesntHave('departments')->get();
```

---

## 📝 Conventions de code

- ✅ Noms en français (cohérent avec l'app)
- ✅ Commentaires détaillés dans le contrôleur
- ✅ Variables explicites (`$departmentNames`, `$totalUnassigned`)
- ✅ Messages personnalisés (singulier/pluriel)
- ✅ Validation complète côté serveur
- ✅ Redirections appropriées après traitement
- ✅ Séparation claire contrôleur / vue
- ✅ CSS modulaire et réutilisable

---

## 🔗 URLs de test

- Liste : `http://localhost/committee/assignments`
- Formulaire : `http://localhost/committee/assignments/user/1`
- Post : `POST http://localhost/committee/assignments/user/1`

---

## ✅ Checklist d'implémentation

- [x] Contrôleur `ManageUsersController` avec 4 méthodes
- [x] Routes web bien nommées
- [x] Modèles avec relations many-to-many
- [x] Vues Blade (index + form)
- [x] CSS complet et responsive
- [x] Validation complète
- [x] Messages personnalisés
- [x] Pagination
- [x] Statistiques affichées
- [x] Empty state
- [x] Cohérence design avec le dashboard

---

## 🎨 Design & UX

**Palettes de couleurs** :
- Primaire : Bleu (#3b82f6)
- Secondaire : Gris (#e5e7eb)
- Succès : Vert (#22c55e)
- Danger : Rouge (#ef4444)

**Responsive** :
- Desktop (>1024px) : Disposition optimale
- Tablette (768px - 1024px) : Adaptation moyenne
- Mobile (<768px) : Stack vertical, full-width buttons

---

## 🐛 Dépannage

### Problème : La liste affiche les utilisateurs affectés aussi
**Solution** : Assurez-vous que `indexUnAssigned()` utilise `whereDoesntHave('departments')`

### Problème : La validation échoue
**Solution** : Vérifier que les IDs de département existent en base via `php artisan tinker`

### Problème : L'affectation duplique des lignes
**Solution** : Utiliser `syncWithoutDetaching()` au lieu de `attach()` pour éviter les doublons

---

## 📚 Documentation Laravel

- Relations : https://laravel.com/docs/eloquent-relationships#many-to-many
- Validation : https://laravel.com/docs/validation
- Pagination : https://laravel.com/docs/pagination
- Blade : https://laravel.com/docs/blade

---

**Créé le** : 2025-11-27  
**Version** : 1.0  
**Laravel** : 12.x  
**PHP** : 8.2+
