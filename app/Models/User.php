<?php
namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * Table associée au modèle.
     * @var string
     */
    protected $table = 'users';

    /**
     * Les attributs pouvant être assignés en masse.
     * @var array
     */
    protected $fillable = [
        'name',
        'matricule',
        'email',
        'password',
        'department_id',
        'committee_id',
        'service_id',
        'created_at',
        'last_login_at',
        'last_activity_at',
        'last_login_ip',
        'is_active',
        'phone'
    ];

     protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'last_login_at' => 'datetime',
        'last_activity_at' => 'datetime',
        'info_updated_at' => 'datetime',
        'registered_at' => 'datetime',
    ];

    /**
     * Les attributs cachés pour la sérialisation.
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

   

    
     public function departments(){
        return $this->belongsToMany(Department::class, 'department_user','user_id','department_id')->withTimestamps();
    }

    public function department(){
        return $this->belongsTo(Department::class, 'department_id');
    }



    public function service(){
        return $this->belongsTo(Service::class);
    }

    public function services(){
        return $this->belongsToMany(Service::class, 'service_user', 'user_id', 'service_id');
    }

    public function head(){
        return $this->hasMany(Department::class,'head_id');
    }

    public function comite(){
        return $this->belongsTo(Committee::class,'department_id');
    }

    /**
     * Vérifie si l'utilisateur a un rôle spécifique avec un grade optionnel
     * 
     * @param string $roleName Le nom du rôle à vérifier
     * @param int|null $grade Le grade à vérifier (optionnel)
     * @return bool
     */
    /**
     * Relation avec les rôles
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_users', 'user_id', 'role_id')
                    ->select('roles.id', 'roles.name', 'roles.code', 'roles.display_name', 'roles.grade', 'roles.description', 'roles.created_at', 'roles.updated_at', 'roles.guard_name');
    }

    public function permissions(){
        return $this->belongsToMany(Permission::class,'permission_users','user_id','permission_id');
    }

    public function roleCodeFromMatricule():?string{
        if(!$this->matricule) return null;

        // Vérification spécifique pour le format Super Admin (CM-HQ-SPAD-XXX)
        if(str_starts_with($this->matricule, 'CM-HQ-SPAD')){
            return 'SPAD';
        }

        $segments = explode('-', $this->matricule);
        
        // Vérification pour le format Chef de Département (CM-HQ-XXX-CD)
        if(count($segments) === 4 && $segments[0] === 'CM' && $segments[1] === 'HQ' && $segments[3] === 'CD') {
            return 'CD';
        }

        // Pour les autres formats avec tirets
        if(count($segments) >= 3) {
            return $segments[2]; // Prendre le troisième segment (après CM-HQ-)
        }

        // Pour les autres formats sans tirets
        preg_match('/[A-Z]+/', $this->matricule, $matches);
        if(!empty($matches)){
            $letters = $matches[0];
            $roleCodeStaff = substr($letters, -1);
            return $roleCodeStaff;
        }

        return null;
    }

    public function syncRoleFromMatricule():?string {
        $code = $this->roleCodeFromMatricule();

        if(!$code) return null;

        $role = Role::findByCode($code);

        if($role){
            $this->roles()->syncWithoutDetaching([$role->id]);
            return $role->code;
        }

        return null;
    }

    public function hasRole(string $roleCode){
        // Verification via les matricules
        if ($this->roleCodeFromMatricule() === $roleCode) {
            return true;
        }

        // Verification via la base de donnee
        return $this->roles()->where('code', $roleCode)->exists();
    }

    public function hasPermission(string $permission){
        $direct=$this->permissions()->where('name',$permission)->exists();
        $viaRole=$this->roles()->whereHas('permissions',fn($q) => $q->where('name',$permission))->exists();
        return $direct || $viaRole ;
    }
    
    /**
     * Vérifie si l'utilisateur est super administrateur
     * (le plus haut niveau hiérarchique)
     * 
     * Cette méthode vérifie deux conditions :
     * 1. Le format du matricule (CM-HQ-SPAD-XXX)
     * 2. La présence du rôle SPAD dans la base de données
     * 
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        // Vérifie d'abord le format du matricule
        if ($this->matricule && str_starts_with($this->matricule, 'CM-HQ-SPAD-')) {
            return true;
        }

        // Si le format ne correspond pas, vérifie le rôle dans la base de données
        return $this->roles()->where('code', 'SPAD')->exists();
    }

    /**
     * Vérifie si l'utilisateur est membre du comité de nehemie
     * 
     * @return bool
     */
    public function isAdmin1(): bool
    {
        return $this->hasRole('NEH');
    }

    /**
     * Vérifie si l'utilisateur est chef de département
     * 
     * @return bool
     */
    public function isAdmin2(): bool
    {
        return $this->hasRole('CD');
    }

    /**
     * Vérifie si l'utilisateur est un membre du staff (incluant les chefs de service)
     * 
     * @return bool
     */
    public function isStaff(): bool
    {
        return $this->hasRole('F');   
    }

    /**
     * Vérifie si l'utilisateur a des droits d'administration
     * 
     * @return bool
     */
    public function isAdmin(): bool
    {
        // Soit super admin, soit membre du comité
        return $this->isSuperAdmin() || $this->isAdmin1();
    }
}
