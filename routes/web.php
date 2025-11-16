<?php
use App\Http\Kernel;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Committee\ServiceListController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentHeadController;
use App\Http\Middleware\CheckPermission;
use App\Http\Controllers\TwoFAController;
use App\Http\Controllers\ComiteController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\HqStaffFormController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\CommitteePdfController;
use App\Http\Controllers\DepartmentPdfController;
use App\Http\Controllers\RoleAssignmentController;
use App\Http\Controllers\FirstRegistrationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Middleware\CheckDepartmentAccess;


// Route pour afficher le formulaire de connexion
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Route pour traiter la soumission du formulaire
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

// Route pour valider le département
Route::post('/department/validate', [LoginController::class, 'validateDepartment'])->name('department.validate');

Route::middleware('auth')->group(function() {
    Route::get('/departments/dashboard', function() {
        return view('departments.dashboard');
    })->name('headDept.dashboard');

    Route::get('/staff/dashboard', [StaffDashboardController::class, 'index'])->name('staff.dashboard');

    Route::get('/committee/dashboard', [ComiteController::class, 'dashboard'])->name('committee.dashboard');
});


Route::post('update',[UserController::class,'update'])->name('users.update');
Route::post('destroy',[UserController::class,'destroy'])->middleware('auth')->name('staff.index');


Route::get('/staff/index',function(){
    return view('/staff/index');
})->middleware('auth')->name('staff.index');

Route::get('/staff/statistique',function(){
    return view('/staff/statistique');
})->middleware('auth')->name('statistique');

// Route publique pour la vue des départements
//Route::get('/departments', [DepartmentController::class, 'depts'])->name('departments');


Route::middleware('auth')->group(function () {
    // Routes pour les statistiques des départements
    Route::get('/departments/statistics', [SuperAdminController::class, 'departmentStatistics'])
        ->name('departments.statistics');

    // Routes pour la gestion des chefs de département
    Route::group(['prefix' => 'departments/{department}'], function () {
        Route::get('/assign-head', [DepartmentHeadController::class, 'showAssignForm'])->name('departments.head.assign.form');
        Route::post('/assign-head', [DepartmentHeadController::class, 'assign'])->name('departments.head.assign');
        Route::delete('/remove-head', [DepartmentHeadController::class, 'remove'])->name('departments.head.remove');
    });

    Route::post('/roles/store',[RoleController::class,'store'])->name('roles.store');
    Route::resource('roles', RoleController::class)->names([
        'index' => 'roles.index',
        'create' => 'roles.create',
        'show' => 'roles.show',
        'edit' => 'roles.edit',
        'update' => 'roles.update',
        'destroy' => 'roles.destroy',
    ]);

    Route::post('permissions/store',[PermissionController::class,'store'])->name('permissions.store');
    Route::resource('permissions', PermissionController::class)->names([
        'index' => 'permissions.index',
        'create' => 'permissions.create',
        'store' => 'permissions.store',
        'show' => 'permissions.show',
        'edit' => 'permissions.edit',
        'update' => 'permissions.update',
        'destroy' => 'permissions.destroy',
    ]);

    // Routes spécifiques des départements (doivent être avant la resource)
    Route::get('/departments/choose', function(){
        return view('departments.choose');
    })->name('departments.choose');
    
    Route::get('/departments/indexDepts',[DepartmentController::class,'indexDepts'])->name('indexDepts');
    Route::get('/departments/dashboard',[DepartmentController::class,'dashboard'])->name('departments.dashboard');
    Route::get('/departments/staff', [DepartmentController::class, 'staffIndex'])->name('departments.staff.index');
    Route::get('/departments/staff/create', [DepartmentController::class, 'staffCreate'])->name('departments.staff.create');
    Route::post('/departments/staff', [DepartmentController::class, 'staffStore'])->name('departments.staff.store');
    Route::get('/departments/staff/{staff}', [DepartmentController::class, 'staffShow'])->name('staff.show');
    Route::get('/departments/staff/{staff}/edit', [DepartmentController::class, 'staffEdit'])->name('staff.edit');
    Route::put('/departments/staff/{staff}', [DepartmentController::class, 'staffUpdate'])->name('staff.update');
    Route::delete('/departments/staff/{staff}', [DepartmentController::class, 'staffDestroy'])->name('staff.destroy');

    // Routes pour les paramètres du département
    Route::prefix('departments/settings')->name('departments.update.')->group(function () {
        Route::post('/general', [DepartmentController::class, 'updateSettings'])->name('settings');
        Route::post('/notifications', [DepartmentController::class, 'updateNotifications'])->name('notifications');
        Route::post('/security', [DepartmentController::class, 'updateSecurity'])->name('security');
        Route::post('/appearance', [DepartmentController::class, 'updateAppearance'])->name('appearance');
    });

    // Routes pour les PDF des départements
    Route::prefix('departments')->name('departments.pdf.')->group(function () {
        Route::get('/pdf/generate', [DepartmentPdfController::class, 'generatePDF'])->name('generate');
        Route::get('/pdf/history', [DepartmentPdfController::class, 'getPdfHistory'])->name('history');
    });

    // Routes pour la gestion des services du département
    Route::prefix('departments/{department}/services')->name('departments.services.')->group(function () {
        Route::get('/', [App\Http\Controllers\Department\ServiceController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Department\ServiceController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Department\ServiceController::class, 'store'])->name('store');
        Route::get('/{service}', [App\Http\Controllers\Department\ServiceController::class, 'show'])->name('show');
        Route::get('/{service}/edit', [App\Http\Controllers\Department\ServiceController::class, 'edit'])->name('edit');
        Route::put('/{service}', [App\Http\Controllers\Department\ServiceController::class, 'update'])->name('update');
        Route::delete('/{service}', [App\Http\Controllers\Department\ServiceController::class, 'destroy'])->name('destroy');
        
        // Routes pour la gestion des utilisateurs des services
        Route::get('/{service}/unassigned-users', [App\Http\Controllers\Department\ServiceUserController::class, 'getUnassignedUsers'])
            ->name('unassigned-users');
        Route::post('/{service}/assign-users', [App\Http\Controllers\Department\ServiceUserController::class, 'assignUsers'])
            ->name('assign-users');
    });

    // Resource routes pour les départements
    Route::resource('departments', DepartmentController::class)->names([
        'index' => 'departments.index',
        'create' => 'departments.create',
        'store' => 'departments.store',
        'show' => 'departments.show',
        'edit' => 'departments.edit',
        'update' => 'departments.update',
        'destroy' => 'departments.destroy',
    ]); // Exclure la route show pour éviter les conflits

    // Routes pour le comité
    Route::prefix('committee')->name('committee.')->group(function () {
        // Routes des PDFs
        Route::get('/pdf/departments-heads', [CommitteePdfController::class, 'generateDepartmentsHeadsList'])
            ->name('pdf.departments-heads');
        Route::get('/pdf/departments-heads-services', [CommitteePdfController::class, 'generateDepartmentsHeadsServicesList'])
            ->name('pdf.departments-heads-services');
        Route::get('/pdf/departments-employees', [CommitteePdfController::class, 'generateDepartmentsEmployeesList'])
            ->name('pdf.departments-employees');

        // Routes pour les services
        Route::prefix('services')->name('services.')->group(function() {
            Route::get('/', [ComiteController::class, 'serviceIndex'])->name('index');
            Route::get('/create', [ComiteController::class, 'serviceCreate'])->name('create');
            Route::post('/store', [ComiteController::class, 'serviceStore'])->name('store');
        });

        // Route pour la liste des services par département
        Route::get('/services-by-department', [ServiceListController::class, 'index'])
            ->name('services.list');

        // Route pour la liste des services
        Route::get('/services', [ServiceListController::class, 'index'])
            ->name('services.index');
Route::get('/committee/departments/manage', [ComiteController::class, 'manage'])
    ->name('committee.departments.manage');
        // Routes principales du comité
        Route::resource('/', ComiteController::class)->names([
            'index' => 'index',
            'create' => 'create',
            'store' => 'store',
            'show' => 'show',
            'edit' => 'edit',
            'update' => 'update',
            'destroy' => 'destroy',
            'serviceIndex'=> 'services.index'
            
        ]);

        Route::get('/committee/services/create',function () {
            return view('committee.services.create');
        })->name('committee.services.create');


    });
    Route::post('/auth/login',[LoginController::class,'login'])->name('staff.store');
    Route::post('departments/Save-Depts',[LoginController::class,'saveDepts'])->name('departments.saveDepts');
    // Toutes les routes de service avec les middlewares d'authentification et de contrôle d'accès par département
    Route::middleware(['auth', \App\Http\Middleware\CheckDepartmentAccess::class])->group(function () {
        Route::resource('services', ServiceController::class)->names([
            'index' => 'services.index',
            'create' => 'services.create',
            'store' => 'services.store',
            'show' => 'services.show',
            'edit' => 'services.edit',
            'update' => 'services.update',
            'destroy' => 'services.destroy',
        ]);
        
        // Routes du staff avec contrôle d'accès par département
        Route::prefix('staff')->name('staff.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{user}', [UserController::class, 'show'])->name('show');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        });
    });
    Route::get('/superAdmin/dashboard',[SuperAdminController::class,'dashboard'])->name('dashboard');

    // Routes pour les paramètres (Settings)
    Route::middleware(['auth', \App\Http\Middleware\CheckSuperAdmin::class])->group(function () {
        // Paramètres du site
        Route::put('/settings/site', [SettingsController::class, 'updateSiteSettings'])
            ->name('settings.site.update');
        
        // Paramètres de sécurité
        Route::put('/settings/security', [SettingsController::class, 'updateSecuritySettings'])
            ->name('settings.security.update');
        
        // Paramètres de notification
        Route::put('/settings/notifications', [SettingsController::class, 'updateNotificationSettings'])
            ->name('settings.notifications.update');
        
        // Actions de maintenance
        Route::post('/settings/backup', [SettingsController::class, 'createBackup'])
            ->name('settings.backup.create');
        Route::post('/settings/cache/clear', [SettingsController::class, 'clearCache'])
            ->name('settings.cache.clear');
        Route::post('/settings/maintenance', [SettingsController::class, 'toggleMaintenance'])
            ->name('settings.maintenance.toggle');
    });
    
    Route::get('/auth/2fa',function(){
        return view('auth.2fa');
        })->name('twoFactorAuth');
    Route::post('auth/2fa-send',[TwoFAController::class,'sendCode'])->name('sendCode');
    Route::post('/ath/2fa-verify',[TwoFAController::class,'verifyCode'])->name('verifyCode');

});

Route::get('/staff/create',[UserController::class,'create'])->name('staff.create');

// Afficher le formulaire pour un département
Route::get('/departments/{department}/assign', [SuperAdminController::class, 'assign'])
    ->middleware('auth')
    ->name('departments.assign');

// Soumettre le formulaire pour assigner les utilisateurs
Route::put('/departments/{department}/assign-users', [SuperAdminController::class, 'assignUsers'])
    ->middleware('auth')
    ->name('departments.assignUsers');





Route::get('/staff/statistiques', [App\Http\Controllers\StatistiqueController::class, 'index'])
    ->middleware('auth')->name('statistiques');
Route::get('/api/statistics', [App\Http\Controllers\StatistiqueController::class, 'apiStats'])
    ->middleware('auth');

// Authentication Routes
Route::middleware('guest')->group(function () {

    // Routes pour la réinitialisation du mot de passe
    Route::get('forgot-password', [App\Http\Controllers\Auth\PasswordResetLinkController::class, 'create'])
        ->name('password.request');
    Route::post('forgot-password', [App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store'])
        ->name('password.email');
    Route::get('reset-password/{token}', [App\Http\Controllers\Auth\NewPasswordController::class, 'create'])
        ->name('password.reset');
    Route::post('reset-password', [App\Http\Controllers\Auth\NewPasswordController::class, 'store'])
        ->name('password.update');
    
    // Routes pour la vérification d'identite
    Route::get('/identification/form', [FirstRegistrationController::class, 'showRegistrationForm'])
        ->name('identification.form');
    Route::post('/identification/form',[FirstRegistrationController::class,'register'])->name('identification.register');
    Route::get('/identification/identification-after-registration', [FirstRegistrationController::class, 'showIdentification'])
        ->name('identification.identification_after_registration');
    Route::post('/verify-identification', [FirstRegistrationController::class, 'verifyIdentification'])
        ->name('verify.identification');
    Route::post('/resend-identification-code', [FirstRegistrationController::class, 'resendCode'])
        ->name('resend.code');
    Route::get('/code-expired', [FirstRegistrationController::class, 'codeExpired'])
        ->name('code.expired');
});

//Pour les Fichier Pdf
Route::post('/download-pdf', [HqStaffFormController::class, 'telechargerPDF'])->name('download.pdf');
Route::get('/formulaire/create',[HqStaffFormController::class,'showBigForm'])->name('BigForm');
Route::get('/user/{id}/download-pdf', [HqStaffFormController::class, 'downloadUserPDF'])->name('user.download.pdf');
Route::delete('/user/{id}/delete', [UserController::class, 'deleteUser'])->name('user.delete');

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])
        ->name('logout');
    
    // Routes pour le formulaire complet d'inscription
    Route::get('/complete-registration', [UserController::class, 'create'])->name('registration.create');
    Route::post('/complete-registration', [UserController::class, 'store'])->name('registration.store');
    Route::post('/auth/register', [UserController::class, 'finalRegister'])->name('auth.register.submit');

    // Routes du profil
    Route::get('/profile/show', [UserProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [UserProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/password', [UserProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::post('/profile/delete',[UserProfileController::class,'destroy'])->name('profile.destroy');
// Routes for other pages, all with unique names
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/blog', function () {
    return view('blog');
})->name('blog');

});


Route::get('/home',function(){
    return view('home');
})->name('home');

// The route for your home page, with a name
Route::get('/', function () {
    return view('welcome');
})->name('welcome');



Route::get('/check-registration-status', [App\Http\Controllers\Auth\UserStatusController::class, 'checkRegistrationStatus'])
    ->name('check.registration.status');

/*Route::middleware(['auth'])->group(function () {
    Route::get('/department-statistics', [SuperAdminController::class, 'departmentStatistics'])->name('departments.statistics');
    // Super Admin Routes
    Route::group(['middleware' => ['superadmin'], 'prefix' => 'superadmin', 'as' => 'superadmin.'], function () {
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
});
});*/

