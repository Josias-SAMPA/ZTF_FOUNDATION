<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'department_id',
        'department_code',
        'location',
        'phone',
        'email',
        'is_active'
    ];

    protected $attributes = [
        'is_active' => true // Définir la valeur par défaut à true
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'service_user', 'service_id', 'user_id')
                    ->withTimestamps();
    }

    public function getUsersCountAttribute()
    {
        // Count directly without caching to ensure accuracy
        return $this->users()->count();
    }
    
    /**
     * Obtient le nombre total d'utilisateurs uniques dans ce service
     * (combinaison des affectations principales et secondaires)
     */
    public function getTotalUsersCountAttribute()
    {
        // On compte simplement les utilisateurs dans la table service_user
        return \DB::table('service_user')
            ->where('service_id', $this->id)
            ->count();
    }
    
    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function manager() {
        return $this->users()->whereHas('roles', function($query) {
            $query->where('name', 'manager');
        })->first();
    }
}
