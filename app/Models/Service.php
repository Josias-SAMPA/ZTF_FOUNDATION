<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function users(){
        return $this->belongsToMany(User::class, 'service_user', 'service_id', 'user_id')
                    ->withTimestamps();
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
